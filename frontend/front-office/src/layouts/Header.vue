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
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: 'Header',
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