import { createRouter, createWebHistory } from 'vue-router';

import Dashboard from '../pages/Dashboard.vue';
import Login from '../components/auth/Login.vue';


const routes = [
  { 
    path: '/', 
    redirect: '/login'
  },
  {
    path: '/login',
    component: Login
  },
  { 
    path: '/:pathMatch(.*)*', 
    redirect: '/login'
  },
  { 
    path: '/dashboard', 
    name: 'Dashboard', 
    component: Dashboard,
    meta: { requiresAuth: true }
  },
];

const requireAuth = (to, from, next) => {
  const isAuthenticated = localStorage.getItem('isAuthenticated') === 'true';
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login');
  } else if ((to.path === '/login' || to.path === '/signup') && isAuthenticated) {
    next('/dashboard');
  } else {
    next();
  }
}

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach(requireAuth);
export default router;