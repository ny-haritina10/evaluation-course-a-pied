<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body p-5">
            <h2 class="text-center mb-4">Front Office Login</h2>
            
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
              
              <button type="submit" class="btn btn-primary w-100 py-2 mb-3" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
                Login
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/api/axiosInstance';

export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: '',
      rememberMe: false,
      errorMessage: '',
      isLoading: false,
      showPassword: false
    }
  },
  methods: {
    async handleLogin() {
      this.isLoading = true;
      this.errorMessage = '';

      try {
        const response = await api.post('/equipe/login', {
          email: this.email,
          password: this.password
        });

        console.log('response: ', response);

        if (response.data.status === 'success') {
          localStorage.setItem('token', response.data.data.token);
          localStorage.setItem('isAuthenticated', 'true');
          
          if (this.rememberMe) {
            localStorage.setItem('userEmail', this.email);
          } else {
            localStorage.removeItem('userEmail');
          }

          localStorage.setItem('equipeData', JSON.stringify(response.data.data.equipe));
          this.$router.push('/dashboard');
        }
      } catch (error) {
        if (error.response) {
          this.errorMessage = error.response.data.message || 'Invalid email or password';
        } else if (error.request) {
          this.errorMessage = 'No response from server. Please try again later.';
        } else {
          this.errorMessage = 'An error occurred. Please try again.';
        }
      } finally {
        this.isLoading = false;
      }
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