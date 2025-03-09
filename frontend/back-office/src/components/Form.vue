<template>
  <div class="app-form">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0">{{ title }}</h5>
        <p v-if="subtitle" class="card-subtitle text-muted mt-1 mb-0">{{ subtitle }}</p>
      </div>
      <div class="card-body">
        <!-- Notification component -->
        <Notification
          :show.sync="notification.show"
          :type="notification.type"
          :title="notification.title"
          :message="notification.message"
          :duration="notification.duration"
          :dismissible="notification.dismissible"
          @dismiss="onNotificationDismiss"
          class="mb-4"
        />
        
        <form @submit.prevent="handleSubmit">
          <div class="row g-3">
            <div v-for="field in formFields" :key="field.id" 
                 :class="getFieldColClass(field)">
              <div class="form-group">
                <label :for="field.id" class="form-label">
                  {{ field.label }}
                  <span v-if="field.required" class="text-danger">*</span>
                </label>
                
                <!-- Form field types - unchanged from your original component -->
                <!-- Text Input -->
                <input 
                  v-if="field.type === 'text' || field.type === 'email' || field.type === 'password' || field.type === 'number'"
                  :type="field.type"
                  :id="field.id"
                  v-model="formData[field.id]"
                  class="form-control"
                  :class="{'is-invalid': errors[field.id]}"
                  :placeholder="field.placeholder"
                  :disabled="field.disabled"
                  :required="field.required"
                  :min="field.min"
                  :max="field.max"
                >
                
                <!-- Textarea -->
                <textarea 
                  v-else-if="field.type === 'textarea'"
                  :id="field.id"
                  v-model="formData[field.id]"
                  class="form-control"
                  :class="{'is-invalid': errors[field.id]}"
                  :placeholder="field.placeholder"
                  :rows="field.rows || 3"
                  :disabled="field.disabled"
                  :required="field.required"
                ></textarea>
                
                <!-- Select -->
                <select 
                  v-else-if="field.type === 'select'"
                  :id="field.id"
                  v-model="formData[field.id]"
                  class="form-select"
                  :class="{'is-invalid': errors[field.id]}"
                  :disabled="field.disabled"
                  :required="field.required"
                  :multiple="field.multiple"
                >
                  <option v-if="!field.multiple" value="" disabled>{{ field.placeholder || 'Select an option' }}</option>
                  <option 
                    v-for="option in field.options" 
                    :key="option.value || option.id"
                    :value="option.value || option.id"
                  >
                    {{ option.label }}
                  </option>
                </select>
                
                <!-- Checkbox -->
                <div v-else-if="field.type === 'checkbox'" class="form-check mt-2">
                  <div 
                    v-for="option in field.options" 
                    :key="option.value"
                    class="form-check"
                  >
                    <input 
                      type="checkbox"
                      :id="`${field.id}_${option.value}`"
                      :value="option.value"
                      v-model="formData[field.id]"
                      class="form-check-input"
                      :class="{'is-invalid': errors[field.id]}"
                      :disabled="field.disabled"
                    >
                    <label class="form-check-label" :for="`${field.id}_${option.value}`">
                      {{ option.label }}
                    </label>
                  </div>
                </div>
                
                <!-- Radio Group -->
                <div v-else-if="field.type === 'radio'" class="mt-2">
                  <div 
                    v-for="option in field.options" 
                    :key="option.value"
                    class="form-check"
                  >
                    <input 
                      type="radio"
                      :id="`${field.id}_${option.value}`"
                      v-model="formData[field.id]"
                      :value="option.value"
                      class="form-check-input"
                      :class="{'is-invalid': errors[field.id]}"
                      :disabled="field.disabled"
                      :required="field.required"
                    >
                    <label class="form-check-label" :for="`${field.id}_${option.value}`">
                      {{ option.label }}
                    </label>
                  </div>
                </div>
                
                <!-- File Upload -->
                <div v-else-if="field.type === 'file'" class="mt-2">
                  <input 
                    type="file"
                    :id="field.id"
                    class="form-control"
                    :class="{'is-invalid': errors[field.id]}"
                    :disabled="field.disabled"
                    :required="field.required"
                    :accept="field.accept"
                    @change="handleFileChange($event, field.id)"
                  >
                </div>
                
                <!-- Date Picker -->
                <input 
                  v-else-if="field.type === 'date'"
                  type="date"
                  :id="field.id"
                  v-model="formData[field.id]"
                  class="form-control"
                  :class="{'is-invalid': errors[field.id]}"
                  :disabled="field.disabled"
                  :required="field.required"
                >
                
                <!-- Error Message -->
                <div v-if="errors[field.id]" class="invalid-feedback">
                  {{ errors[field.id] }}
                </div>
                
                <!-- Help Text -->
                <div v-if="field.helpText" class="form-text text-muted mt-1">
                  {{ field.helpText }}
                </div>
              </div>
            </div>
          </div>

          <div class="form-actions mt-4 d-flex" :class="actionAlignment">
            <button 
              v-if="showCancelButton" 
              type="button" 
              class="btn btn-outline-secondary me-2"
              @click="handleCancel"
            >
              {{ cancelButtonText }}
            </button>
            
            <button 
              type="submit" 
              class="btn btn-primary"
              :disabled="isSubmitting"
            >
              <span v-if="isSubmitting" class="spinner-border spinner-border-sm me-2" role="status"></span>
              {{ submitButtonText }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Notification from './Notification.vue';

export default {
  name: 'Form',
  components: {
    Notification
  },
  props: {
    title: {
      type: String,
      default: 'Form'
    },
    subtitle: {
      type: String,
      default: ''
    },
    formFields: {
      type: Array,
      required: true
    },
    initialData: {
      type: Object,
      default: () => ({})
    },
    submitButtonText: {
      type: String,
      default: 'Submit'
    },
    showCancelButton: {
      type: Boolean,
      default: false
    },
    cancelButtonText: {
      type: String,
      default: 'Cancel'
    },
    actionAlignment: {
      type: String,
      default: 'justify-content-end',
      validator: value => ['justify-content-start', 'justify-content-center', 'justify-content-end'].includes(value)
    }
  },
  data() {
    return {
      formData: { ...this.initialData },
      errors: {},
      isSubmitting: false,
      files: {},
      notification: {
        show: false,
        type: 'info',
        title: '',
        message: '',
        duration: 5000, // Auto-dismiss after 5 seconds by default
        dismissible: true
      }
    }
  },
  methods: {
    handleSubmit() {
      if (this.validateForm()) {
        this.isSubmitting = true;
        
        const formData = { ...this.formData };        
        this.$emit('submit', formData);
      }
    },
    handleCancel() {
      this.hideNotification();
      this.$emit('cancel');
    },
    validateForm() {
      this.errors = {};
      let isValid = true;
      
      this.formFields.forEach(field => {
        // Skip validation for disabled fields
        if (field.disabled) return;
        
        const value = this.formData[field.id];
        
        // Required field validation
        if (field.required && (value === undefined || value === null || value === '')) {
          this.errors[field.id] = `${field.label} is required`;
          isValid = false;
        }
        
        // Email validation
        if (field.type === 'email' && value && !this.validateEmail(value)) {
          this.errors[field.id] = 'Please enter a valid email address';
          isValid = false;
        }
        
        // Number validation
        if (field.type === 'number' && value !== '') {
          const numValue = Number(value);
          
          if (isNaN(numValue)) {
            this.errors[field.id] = 'Please enter a valid number';
            isValid = false;
          }
          
          if (field.min !== undefined && numValue < field.min) {
            this.errors[field.id] = `Value must be at least ${field.min}`;
            isValid = false;
          }
          
          if (field.max !== undefined && numValue > field.max) {
            this.errors[field.id] = `Value must be no more than ${field.max}`;
            isValid = false;
          }
        }
        
        // Custom validation
        if (field.validator && value) {
          const validationResult = field.validator(value);
          if (validationResult !== true) {
            this.errors[field.id] = validationResult;
            isValid = false;
          }
        }
      });
      
      return isValid;
    },
    validateEmail(email) {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    },
    handleFileChange(event, fieldId) {
      const fileList = event.target.files;
      if (fileList.length > 0) {
        this.files[fieldId] = fileList;
      } else {
        delete this.files[fieldId];
      }
    },
    getFieldColClass(field) {
      return field.colClass || 'col-md-12';
    },
    setError(field, message) {
      this.$set(this.errors, field, message);
      this.isSubmitting = false; 
    },
    showNotification(type, message, title = '', duration = 5000) {
      this.notification = {
        show: true,
        type,
        title,
        message,
        duration,
        dismissible: true
      };
    },
    hideNotification() {
      this.notification.show = false;
    },
    onNotificationDismiss() {
      // Optional: You can add any actions to perform when notification is dismissed
    },
    showSuccessNotification(message, title = 'Success') {
      this.showNotification('success', message, title);
    },
    showErrorNotification(message, title = 'Error') {
      this.showNotification('error', message, title);
    },
    showInfoNotification(message, title = 'Information') {
      this.showNotification('info', message, title);
    },
    showWarningNotification(message, title = 'Warning') {
      this.showNotification('warning', message, title);
    },
    resetSubmitting() {
      this.isSubmitting = false;
    },
    resetForm() {
      this.formData = { ...this.initialData };
      this.errors = {};
      this.isSubmitting = false;
      this.files = {};
      this.hideNotification();
    }
  }
}
</script>

<style scoped>
.app-form {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.card {
  border-radius: 8px;
  overflow: hidden;
}

.card-header {
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.form-label {
  font-weight: 500;
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
}

.form-control, .form-select {
  border-radius: 6px;
  padding: 0.6rem 0.75rem;
  transition: all 0.2s ease;
  border: 1px solid #dee2e6;
}

.form-control:focus, .form-select:focus {
  border-color: #a3c0f8;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.btn {
  padding: 0.6rem 1.25rem;
  font-weight: 500;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.btn-primary {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.btn-primary:hover {
  background-color: #0b5ed7;
  border-color: #0a58ca;
}

.invalid-feedback {
  font-size: 0.8rem;
  margin-top: 0.35rem;
}

.form-text {
  font-size: 0.8rem;
}
</style>