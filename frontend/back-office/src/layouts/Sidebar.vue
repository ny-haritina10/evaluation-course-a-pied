<template>
  <div class="sidebar bg-dark text-white" :class="{ 'collapsed': isCollapsed }">
    <div class="sidebar-header d-flex align-items-center justify-content-between p-3">
      <div class="d-flex align-items-center">
        <i class="bi bi-grid-1x2-fill me-2"></i>
        <span class="brand-name" v-if="!isCollapsed">Admin Panel</span>
      </div>
      <button class="btn btn-link text-white p-0" @click="toggleSidebar">
        <i class="bi" :class="isCollapsed ? 'bi-chevron-right' : 'bi-chevron-left'"></i>
      </button>
    </div>
    
    <div class="sidebar-menu p-2">
      <ul class="nav flex-column">
        <li class="nav-item mb-2" v-for="(item, index) in menuItems" :key="index">
          <router-link 
            class="nav-link d-flex align-items-center text-white" 
            :to="item.link" 
            @click="item.submenu ? toggleDropdown(index) : null"
          >
            <i class="bi" :class="item.icon"></i>
            <span class="ms-2" v-if="!isCollapsed">{{ item.name }}</span>
            <i 
              v-if="item.submenu && !isCollapsed" 
              class="bi ms-auto" 
              :class="isDropdownOpen[index] ? 'bi-chevron-up' : 'bi-chevron-down'"
            ></i>
          </router-link>
          
          <ul 
            v-if="item.submenu && !isCollapsed" 
            class="nav flex-column ps-3 submenu"
            :class="{ 'is-open': isDropdownOpen[index] }"
          >
            <li class="nav-item" v-for="(subItem, subIndex) in item.submenu" :key="subIndex">
              <router-link class="nav-link text-white" :to="subItem.link">{{ subItem.name }}</router-link>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    
    <div class="sidebar-footer mt-auto p-3" v-if="!isCollapsed">
      <div class="user-info d-flex align-items-center mb-3">
        <div class="avatar bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
          <span>{{ userInitials }}</span>
        </div>
        <div>
          <p class="mb-0 fw-bold">{{ adminData.email }}</p>
          <small>ADMIN</small>
        </div>
      </div>
      <button class="btn btn-danger w-100 d-flex align-items-center justify-content-center" @click="logout">
        <i class="bi bi-box-arrow-right me-2"></i>
        <span>Logout</span>
      </button>
    </div>

    <!-- Collapsed state logout button -->
    <div class="sidebar-footer p-2" v-else>
      <button class="btn btn-danger btn-sm w-100" @click="logout" title="Logout">
        <i class="bi bi-box-arrow-right"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Sidebar',
  data() {
    return {
      isCollapsed: false,
      isDropdownOpen: {},
      adminData: {
        email: 'Loading...',
      },
      menuItems: [
        { name: 'Dashboard', icon: 'bi-speedometer2', link: '/' },
        { 
          name: 'Examples', 
          icon: 'bi-gear', 
          link: '#', 
          submenu: [
            { name: 'Form', link: '/examples/static/form' },
            { name: 'List', link: '/examples/static/list' },
            { name: 'List Reservation', link: '/examples/api/list-reservation' },
            { name: 'Form Reservation', link: '/examples/api/form-reservation' }
          ]
        }
      ]
    }
  },
  created() {
    this.menuItems.forEach((item, index) => {
      if (item.submenu) {
        this.isDropdownOpen[index] = false;
      }
    });
    this.loadAdminData();
  },
  computed: {
    userInitials() {
      return this.adminData.email
        .split('@')[0]  // Get part before @
        .split('.')
        .map(part => part.charAt(0))
        .join('')
        .toUpperCase()
        .slice(0, 2);  // Limit to 2 characters
    }
  },
  methods: {
    loadAdminData() {
      const storedAdminData = localStorage.getItem('adminData');
      if (storedAdminData) {
        this.adminData = JSON.parse(storedAdminData);
      } else {
        this.$router.push('/login');
      }
    },
    toggleSidebar() {
      this.isCollapsed = !this.isCollapsed;
      this.$emit('sidebar-toggle', this.isCollapsed);
    },
    toggleDropdown(index) {
      this.isDropdownOpen[index] = !this.isDropdownOpen[index];
    },
    logout() {
      localStorage.removeItem('isAuthenticated');
      localStorage.removeItem('token');
      localStorage.removeItem('adminData');

      this.$router.push('/login'); 
    }
  }
}
</script>

<style scoped>
.sidebar {
  display: flex;
  flex-direction: column;
  height: 100vh;
  width: 250px;
  transition: all 0.3s ease;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
}

.sidebar.collapsed {
  width: 60px;
}

.sidebar-header {
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.brand-name {
  font-weight: 600;
  font-size: 1.2rem;
}

.nav-link {
  border-radius: 6px;
  padding: 0.75rem 1rem;
  transition: all 0.2s ease;
}

.nav-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.submenu {
  max-height: 0;
  overflow: hidden;
}

.submenu.is-open {
  max-height: 200px;
}

.sidebar-footer {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.avatar {
  width: 36px;
  height: 36px;
  color: white;
  font-size: 1rem;
  font-weight: bold;
}

.btn-danger {
  transition: background-color 0.3s ease, transform 0.2s ease;
  padding: 0.5rem 1rem;
  font-size: 0.9rem;
}

.btn-danger:hover {
  background-color: #c82333;
  transform: translateY(-1px);
}

.btn-danger:active {
  transform: translateY(0);
}

.sidebar.collapsed .sidebar-footer {
  display: flex;
  justify-content: center;
  padding: 0.5rem;
}

.sidebar.collapsed .btn-danger {
  padding: 0.5rem;
}

.sidebar-menu {
  flex-grow: 1;
  overflow-y: auto;
}
</style>