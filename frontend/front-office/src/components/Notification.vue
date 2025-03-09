<template>
  <transition name="fade">
    <div 
      v-if="show" 
      class="notification"
      :class="[`notification-${type}`, customClass]"
    >
      <div class="notification-icon" v-if="showIcon">
        <i v-if="type === 'success'" class="fas fa-check-circle"></i>
        <i v-else-if="type === 'error'" class="fas fa-exclamation-circle"></i>
        <i v-else-if="type === 'warning'" class="fas fa-exclamation-triangle"></i>
        <i v-else-if="type === 'info'" class="fas fa-info-circle"></i>
      </div>
      <div class="notification-content">
        <div class="notification-title" v-if="title">{{ title }}</div>
        <div class="notification-message">{{ message }}</div>
      </div>
      <button v-if="dismissible" class="notification-close" @click="dismiss">
        &times;
      </button>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'Notification',
  props: {
    show: {
      type: Boolean,
      default: false
    },
    type: {
      type: String,
      default: 'info',
      validator: value => ['success', 'error', 'warning', 'info'].includes(value)
    },
    title: {
      type: String,
      default: ''
    },
    message: {
      type: String,
      required: true
    },
    duration: {
      type: Number,
      default: 0 // 0 means it won't auto-dismiss
    },
    dismissible: {
      type: Boolean,
      default: true
    },
    showIcon: {
      type: Boolean,
      default: true
    },
    customClass: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      dismissTimer: null
    };
  },
  watch: {
    show(newVal) {
      if (newVal && this.duration > 0) {
        this.setDismissTimer();
      }
    },
    duration(newVal) {
      if (this.show && newVal > 0) {
        this.clearDismissTimer();
        this.setDismissTimer();
      }
    }
  },
  mounted() {
    if (this.show && this.duration > 0) {
      this.setDismissTimer();
    }
  },
  beforeDestroy() {
    this.clearDismissTimer();
  },
  methods: {
    dismiss() {
      this.$emit('update:show', false);
      this.$emit('dismiss');
    },
    setDismissTimer() {
      this.clearDismissTimer();
      if (this.duration > 0) {
        this.dismissTimer = setTimeout(() => {
          this.dismiss();
        }, this.duration);
      }
    },
    clearDismissTimer() {
      if (this.dismissTimer) {
        clearTimeout(this.dismissTimer);
        this.dismissTimer = null;
      }
    }
  }
};
</script>

<style scoped>
.notification {
  display: flex;
  align-items: flex-start;
  padding: 16px;
  border-radius: 8px;
  margin-bottom: 16px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  position: relative;
}

.notification-success {
  background-color: #d4edda;
  border-left: 4px solid #28a745;
  color: #155724;
}

.notification-error {
  background-color: #f8d7da;
  border-left: 4px solid #dc3545;
  color: #721c24;
}

.notification-warning {
  background-color: #fff3cd;
  border-left: 4px solid #ffc107;
  color: #856404;
}

.notification-info {
  background-color: #d1ecf1;
  border-left: 4px solid #17a2b8;
  color: #0c5460;
}

.notification-icon {
  margin-right: 12px;
  font-size: 1.25rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.notification-content {
  flex: 1;
}

.notification-title {
  font-weight: 600;
  font-size: 1rem;
  margin-bottom: 4px;
}

.notification-message {
  font-size: 0.9rem;
}

.notification-close {
  background: transparent;
  border: none;
  font-size: 1.25rem;
  line-height: 1;
  padding: 0;
  cursor: pointer;
  opacity: 0.5;
  transition: opacity 0.2s;
  color: inherit;
  margin-left: 12px;
}

.notification-close:hover {
  opacity: 1;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s, transform 0.3s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>