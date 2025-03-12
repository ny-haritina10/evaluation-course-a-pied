<template>
  <component :is="layout">
    <router-view></router-view>
  </component>
</template>

<script>
import DefaultLayout from './layouts/DefaultLayout.vue';
import AuthLayout from './layouts/AuthLayout.vue';

export default {
  name: 'App',
  components: {
    DefaultLayout,
    AuthLayout
  },
  computed: {
    layout() {
      // Check the current route meta to determine which layout to use
      const route = this.$route;
      
      // If the route is login or signup, use the AuthLayout
      if (route.path === '/login' || route.path === '/signup') {
        return 'AuthLayout';
      }
      // Otherwise use the default layout
      return 'DefaultLayout';
    }
  }
};
</script>

<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');

</style>