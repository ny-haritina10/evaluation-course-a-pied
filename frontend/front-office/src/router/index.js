import { createRouter, createWebHistory } from 'vue-router';

import UserRegistration from '../examples/static/UserRegistration.vue';
import ProductList from '../examples/static/ProductList.vue';
import Dashboard from '../pages/Dashboard.vue';
import Login from '../components/auth/Login.vue';
import Signup from '../components/auth/Signup.vue';
import ReservationList from '../examples/api/ReservationList.vue';
import Reservation from '../examples/api/Reservation.vue';

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
    path: '/signup', 
    component: Signup 
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
  { 
    path: '/examples/static/form', 
    name: 'UserRegistration', 
    component: UserRegistration,
    meta: { requiresAuth: true }
  },
  { 
    path: '/examples/static/list', 
    name: 'ProductList', 
    component: ProductList,
    meta: { requiresAuth: true }
  },
  { 
    path: '/examples/api/list-reservation', 
    name: 'ReservationList', 
    component: ReservationList,
    meta: { requiresAuth: true }
  },
  { 
    path: '/examples/api/form-reservation', 
    name: 'Reservation', 
    component: Reservation,
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