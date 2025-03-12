<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
          <!-- More subtle header -->
          <div class="card-header bg-light text-center py-3 rounded-top-4 border-bottom">
            <h3 class="mb-0 text-primary">
              <i class="bi bi-flag me-2"></i>
              Relay Race Front Office
            </h3>
          </div>
          
          <div class="card-body p-4">
            <!-- Decorative element -->
            <div class="text-center mb-4">
              <div class="relay-icon-container">
                <i class="bi bi-people-fill text-primary fs-1"></i>
                <span class="relay-line"></span>
                <i class="bi bi-stopwatch-fill text-danger fs-1"></i>
              </div>
              <h5 class="text-muted">Team Management Portal</h5>
            </div>
            
            <div v-if="errorMessage" class="alert alert-danger">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>
              {{ errorMessage }}
            </div>
            
            <form @submit.prevent="handleLogin">
              <div class="mb-3">
                <label for="email" class="form-label fw-bold">Team Manager Email</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text bg-light">
                    <i class="bi bi-envelope-fill text-primary"></i>
                  </span>
                  <input 
                    type="email" 
                    class="form-control border-start-0" 
                    id="email" 
                    v-model="email" 
                    placeholder="Enter your email"
                    required
                  >
                </div>
              </div>
              
              <div class="mb-4">
                <label for="password" class="form-label fw-bold">Access Code</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text bg-light">
                    <i class="bi bi-shield-lock-fill text-primary"></i>
                  </span>
                  <input 
                    :type="showPassword ? 'text' : 'password'" 
                    class="form-control border-start-0" 
                    id="password" 
                    v-model="password" 
                    placeholder="Enter your access code"
                    required
                  >
                  <span class="input-group-text cursor-pointer bg-light" @click="togglePasswordVisibility">
                    <i :class="showPassword ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill'" class="text-secondary"></i>
                  </span>
                </div>
              </div>
              
              <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe" v-model="rememberMe">
                <label class="form-check-label" for="rememberMe">
                  <i class="bi bi-clock-history text-secondary me-1"></i>
                  Remember my credentials
                </label>
              </div>
              
              <button type="submit" class="btn btn-primary btn-lg w-100 py-2 mb-3 d-flex align-items-center justify-content-center" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
                <i v-else class="bi bi-box-arrow-in-right me-2"></i>
                Enter Race Management
              </button>
              
              <div class="text-center text-muted mt-3">
                <small>
                  <i class="bi bi-info-circle me-1"></i>
                  Access restricted to authorized team managers and race officials
                </small>
              </div>
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
          this.errorMessage = error.response.data.message || 'Invalid credentials. Please check and try again.';
        } else if (error.request) {
          this.errorMessage = 'No response from race server. Please try again later.';
        } else {
          this.errorMessage = 'Connection error. Please verify your network and try again.';
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

.relay-icon-container {
  position: relative;
  display: inline-block;
  width: 150px;
  height: 60px;
}

.relay-line {
  position: absolute;
  top: 50%;
  left: 25%;
  right: 25%;
  height: 3px;
  background: linear-gradient(to right, #0d6efd, #dc3545);
  animation: pulse 2s infinite;
  border-radius: 2px;
}

.relay-icon-container i {
  position: relative;
  z-index: 1;
  background-color: white;
  padding: 0 5px;
}

.card-header {
  border-bottom: 1px solid rgba(0,0,0,0.1);
}

.card {
  transition: transform 0.3s;
}

.card:hover {
  transform: translateY(-5px);
}

@keyframes pulse {
  0% {
    opacity: 0.6;
  }
  50% {
    opacity: 1;
  }
  100% {
    opacity: 0.6;
  }
}

.form-control:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn-primary {
  background: linear-gradient(45deg, #0d6efd, #0a58ca);
  border: none;
  transition: all 0.3s;
}

.btn-primary:hover:not(:disabled) {
  background: linear-gradient(45deg, #0a58ca, #084298);
  transform: translateY(-2px);
}
</style>