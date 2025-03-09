<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body p-5">
            <h2 class="text-center mb-4">Login</h2>
            
            <div v-if="errorMessage" class="alert alert-danger">
              {{ errorMessage }}
            </div>
            
            <form @submit.prevent="handleLogin">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                  </span>
                  <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    v-model="email" 
                    placeholder="Enter your email"
                    required
                  >
                </div>
              </div>
              
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                  </span>
                  <input 
                    :type="showPassword ? 'text' : 'password'" 
                    class="form-control" 
                    id="password" 
                    v-model="password" 
                    placeholder="Enter your password"
                    required
                  >
                  <span class="input-group-text cursor-pointer" @click="togglePasswordVisibility">
                    <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                  </span>
                </div>
              </div>
              
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe" v-model="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
              </div>
              
              <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
                Login
              </button>
              
              <div class="text-center">
                <p>Don't have an account? <router-link to="/signup">Sign up</router-link></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LoginComponent',
  data() {
    return {
      email: '',
      password: '',
      rememberMe: false,
      errorMessage: '',
      isLoading: false,
      showPassword: false,
      // Hardcoded credentials (to be replaced with backend implementation later)
      validCredentials: [
        { email: 'user@example.com', password: 'password123' },
        { email: 'admin@gmail.com', password: 'admin' }
      ]
    }
  },
  methods: {
    handleLogin() {
      this.isLoading = true;
      this.errorMessage = '';
      
      // Simulate API call delay
      setTimeout(() => {
        const userFound = this.validCredentials.find(
          user => user.email === this.email && user.password === this.password
        );
        
        if (userFound) {
          localStorage.setItem('isAuthenticated', 'true');
          if (this.rememberMe) {
            localStorage.setItem('userEmail', this.email);
          }
          
          // Redirect to dashboard
          this.$router.push('/dashboard');
        } else {
          this.errorMessage = 'Invalid email or password. Please try again.';
        }
        
        this.isLoading = false;
      }, 1000);
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    }
  },
  mounted() {
    // Check if user has saved email (remember me feature)
    const savedEmail = localStorage.getItem('userEmail');
    if (savedEmail) {
      this.email = savedEmail;
      this.rememberMe = true;
    }
  }
}
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>