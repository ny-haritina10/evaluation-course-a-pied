<template>
  <header class="header bg-white border-bottom">
    <div class="container-fluid">
      <div class="row py-3">
        <div class="col d-flex align-items-center">
          <button 
            class="btn btn-outline-secondary border-0 d-md-none me-2" 
            @click="$emit('toggle-mobile-sidebar')"
          >
            <i class="bi bi-list"></i>
          </button>
          
          <div class="search-bar d-none d-md-flex">
            <div class="input-group">
              <span class="input-group-text bg-light border-0">
                <i class="bi bi-search"></i>
              </span>
              <input 
                type="text" 
                class="form-control border-0 bg-light" 
                placeholder="Search..." 
              >
            </div>
          </div>
        </div>
        
        <div class="col-auto d-flex align-items-center">
          <div class="header-actions d-flex align-items-center">
            <div class="dropdown ms-2">
              <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                  <span>{{ userInitials }}</span>
                </div>
                <span class="d-none d-md-inline">{{ user.name }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: 'Header',
  props: {
    user: {
      type: Object,
      default: () => ({
        name: 'John Doe',
        role: 'Administrator'
      })
    }
  },
  computed: {
    userInitials() {
      return this.user.name
        .split(' ')
        .map(name => name.charAt(0))
        .join('')
        .toUpperCase();
    }
  }
}
</script>

<style scoped>
.header {
  height: 70px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.search-bar {
  width: 300px;
}

.search-bar .form-control:focus {
  box-shadow: none;
}

.avatar {
  width: 36px;
  height: 36px;
  color: white;
}

.dropdown-toggle::after {
  display: none;
}
</style>