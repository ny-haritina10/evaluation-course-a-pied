<template>
  <div class="app-layout d-flex">
    <!-- Mobile Sidebar Overlay -->
    <div 
      v-if="isMobileSidebarOpen" 
      class="sidebar-overlay" 
      @click="isMobileSidebarOpen = false"
    ></div>
    
    <!-- Sidebar -->
    <div class="sidebar-container" :class="{ 'mobile-open': isMobileSidebarOpen }">
      <Sidebar 
        :user="user" 
        @sidebar-toggle="handleSidebarToggle" 
      />
    </div>
    
    <!-- Main Content Area -->
    <div class="main-content d-flex flex-column" :class="{ 'expanded': isSidebarCollapsed }">
      <Header 
        :user="user" 
        @toggle-mobile-sidebar="isMobileSidebarOpen = !isMobileSidebarOpen" 
      />
      
      <main class="content-body flex-grow-1 p-3">
        <slot></slot>
      </main>
      
      <Footer />
    </div>
  </div>
</template>

<script>
import Sidebar from './Sidebar.vue';
import Header from './Header.vue';
import Footer from './Footer.vue';

export default {
  name: 'DefaultLayout',
  components: {
    Sidebar,
    Header,
    Footer
  },
  data() {
    return {
      isSidebarCollapsed: false,
      isMobileSidebarOpen: false,
      user: {
        name: 'John Doe',
        role: 'Administrator'
      }
    }
  },
  methods: {
    handleSidebarToggle(isCollapsed) {
      this.isSidebarCollapsed = isCollapsed;
    }
  }
}
</script>

<style scoped>
.app-layout {
  min-height: 100vh;
  overflow-x: hidden;
}

.sidebar-container {
  position: fixed;
  height: 100vh;
  z-index: 1030;
}

.main-content {
  margin-left: 250px;
  width: calc(100% - 250px);
  transition: all 0.3s ease;
}

.main-content.expanded {
  margin-left: 60px;
  width: calc(100% - 60px);
}

.content-body {
  background-color: #f8f9fa;
  overflow-y: auto;
}

.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1020;
  display: none;
}

/* Responsive styles */
@media (max-width: 768px) {
  .sidebar-container {
    transform: translateX(-100%);
    transition: all 0.3s ease;
  }
  
  .sidebar-container.mobile-open {
    transform: translateX(0);
  }
  
  .main-content {
    margin-left: 0;
    width: 100%;
  }
  
  .main-content.expanded {
    margin-left: 0;
    width: 100%;
  }
  
  .sidebar-overlay {
    display: block;
  }
}
</style>