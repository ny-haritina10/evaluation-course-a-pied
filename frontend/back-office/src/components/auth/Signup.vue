<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body p-5">
            <h2 class="text-center mb-4">Create Account</h2>
            
            <div v-if="successMessage" class="alert alert-success">
              {{ successMessage }}
            </div>
            
            <div v-if="errorMessage" class="alert alert-danger">
              {{ errorMessage }}
            </div>
            
            <form @submit.prevent="handleSignup">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class="bi bi-person"></i>
                  </span>
                  <input 
                    type="text" 
                    class="form-control" 
                    id="name" 
                    v-model="name" 
                    placeholder="Enter your full name"
                    required
                  >
                </div>
              </div>
              
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
              
              <div class="mb-3">
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
                    placeholder="Create a password"
                    required
                    @input="validatePassword"
                  >
                  <span class="input-group-text cursor-pointer" @click="togglePasswordVisibility">
                    <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                  </span>
                </div>
                <div v-if="password" class="password-strength mt-2">
                  <div class="progress">
                    <div 
                      class="progress-bar" 
                      :class="passwordStrengthClass" 
                      role="progressbar" 
                      :style="{width: passwordStrength + '%'}" 
                      :aria-valuenow="passwordStrength" 
                      aria-valuemin="0" 
                      aria-valuemax="100"
                    ></div>
                  </div>
                  <small class="text-muted">
                    Password strength: {{ passwordStrengthText }}
                  </small>
                </div>
              </div>
              
              <button 
                type="submit" 
                class="btn btn-primary w-100 py-2 mb-3"
                :disabled="!isFormValid || isLoading"
              >
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"></span>
                Create Account
              </button>
              
              <div class="text-center">
                <p>Already have an account? <router-link to="/login">Login</router-link></p>
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
  name: 'SignupComponent',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: '',
      agreeTerms: false,
      errorMessage: '',
      successMessage: '',
      isLoading: false,
      showPassword: false,
      passwordStrength: 0,
      // List of existing user emails (to be replaced with backend validation)
      existingEmails: ['user@example.com', 'admin@example.com']
    }
  },
  computed: {
    isFormValid() {
      return this.name && 
             this.email && 
             this.password && 
             this.password === this.confirmPassword && 
             this.passwordStrength >= 40 &&
             this.agreeTerms;
    },
    passwordStrengthClass() {
      if (this.passwordStrength < 40) return 'bg-danger';
      if (this.passwordStrength < 70) return 'bg-warning';
      return 'bg-success';
    },
    passwordStrengthText() {
      if (this.passwordStrength < 40) return 'Weak';
      if (this.passwordStrength < 70) return 'Medium';
      return 'Strong';
    }
  },
  methods: {
    handleSignup() {
      if (!this.isFormValid) return;
      
      this.isLoading = true;
      this.errorMessage = '';
      this.successMessage = '';
      
      // Check if email already exists
      if (this.existingEmails.includes(this.email)) {
        this.errorMessage = 'This email is already registered. Please use a different email or login.';
        this.isLoading = false;
        return;
      }
      
      // Simulate API call delay
      setTimeout(() => {
        // In a real implementation, this would send data to a backend
        this.successMessage = 'Account created successfully! Redirecting to login...';
        
        // Add the new user to our "database" (for demo purposes)
        this.existingEmails.push(this.email);
        
        // Reset form
        this.resetForm();
        
        // Redirect to login after a delay
        setTimeout(() => {
          this.$router.push('/login');
        }, 2000);
        
        this.isLoading = false;
      }, 1500);
    },
    validatePassword() {
      // Simple password strength calculation
      let strength = 0;
      
      // Length check
      if (this.password.length >= 8) strength += 25;
      
      // Complexity checks
      if (/[A-Z]/.test(this.password)) strength += 25; // Has uppercase
      if (/[0-9]/.test(this.password)) strength += 25; // Has number
      if (/[^A-Za-z0-9]/.test(this.password)) strength += 25; // Has special char
      
      this.passwordStrength = strength;
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    showTerms() {
      alert('Terms and Conditions would be displayed here.');
    },
    resetForm() {
      this.name = '';
      this.email = '';
      this.password = '';
      this.confirmPassword = '';
      this.agreeTerms = false;
    }
  }
}
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>