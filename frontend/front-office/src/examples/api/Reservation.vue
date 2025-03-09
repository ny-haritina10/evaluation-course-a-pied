<template>
  <div>
    <Form
      ref="reservationForm"
      title="Make a Reservation"
      subtitle="Fill in the details to book a space"
      :formFields="formFields"
      :initialData="initialData"
      submitButtonText="Reserve"
      :showCancelButton="true"
      cancelButtonText="Reset"
      @submit="handleSubmit"
      @cancel="handleCancel"
    />
  </div>
</template>

<script>
import api from '@/api/axiosInstance';
import Form from '../../components/Form.vue';

export default {
  components: { Form },
  data() {
    return {
      options: [],
      espaces: [],
      isSubmitting: false,
      formFields: [
        { id: 'id_client', label: 'Client ID', type: 'number', required: true, placeholder: 'Enter Client ID' },
        { id: 'espaces', label: 'Select your Espace', type: 'select', required: true, options: [] },        
        { id: 'date_reservation', label: 'Reservation Date', type: 'date', required: true },
        { id: 'hour_begin', label: 'Start Hour', type: 'number', required: true, placeholder: 'Enter Start Hour' },
        { id: 'duration', label: 'Duration (Hours)', type: 'number', required: true, placeholder: 'Enter Duration' },
        { id: 'options', label: 'Additional Options',  type: 'checkbox', options: [] },
      ],
      initialData: {
        id_client: '',
        date_reservation: '',
        hour_begin: '',
        duration: '',
        options: [],
        espaces: ''
      }
    };
  },
  created() {
    this.fetchOptions();
    this.fetchEspaces();
  },
  methods: {
    async fetchOptions() {
      try {
        const response = await api.get('/back-office/options');
        if (response.data.success) {
          this.options = response.data.data.map(opt => ({ value: opt.id, label: opt.label }));
          this.formFields.find(f => f.id === 'options').options = this.options;
        }
      } catch (error) {
        console.error('Error fetching options:', error);
      }
    },
    async fetchEspaces() {
      try {
        const response = await api.get('/test/espaces'); 

        if (response.data) {
          this.espaces = response.data.data.map(esp => ({ 
            id: esp.id,
            label: esp.label,
            hourPrice: esp.hour_price
          }));
          this.formFields.find(f => f.id === 'espaces').options = this.espaces;
        }
      } catch(error) {
        console.error('Error fetching Espaces');
      }
    },
    async handleSubmit(formData) {
      // Prevent multiple submissions
      if (this.isSubmitting) return;
      
      this.isSubmitting = true;
      
      try {
        const espaceId = Array.isArray(formData.espaces) && formData.espaces.length > 0 
          ? formData.espaces[0] 
          : formData.espaces;
          
        const payload = {
          id_client: Number(formData.id_client),
          id_espace: Number(espaceId), 
          date_reservation: formData.date_reservation,
          hour_begin: Number(formData.hour_begin),
          duration: Number(formData.duration),
          options: Array.isArray(formData.options) ? [...formData.options] : []
        };
                
        const response = await api.post('/front-office/reservations', payload);

        // show success notification
        this.$refs.reservationForm.showSuccessNotification(
          'Your reservation has been successfully created!', 
          'Reservation Successful'
        );
        
        // Reset form data but keep notification visible
        setTimeout(() => {
          this.resetForm(false);
        }, 500);
        
      } catch (error) {
        console.error('Error submitting reservation:', error);
        
        // Extract error message
        const errorMsg = error.response?.data?.message || 'Failed to make reservation.';
        
        // Show error notification instead of alert
        this.$refs.reservationForm.showErrorNotification(
          errorMsg,
          'Reservation Failed'
        );
        
        // Reset submission state but keep form data for correction
        this.$refs.reservationForm.resetSubmitting();
        this.isSubmitting = false;
      }
    },
    
    handleCancel() {
      this.resetForm();
    },
    
    resetForm(hideNotification = true) {
      // Reset local data
      this.initialData = {
        id_client: '',
        date_reservation: '',
        hour_begin: '',
        duration: '',
        options: [],
        espaces: ''
      };
      
      // Reset the form component state
      if (this.$refs.reservationForm) {
        if (hideNotification) {
          this.$refs.reservationForm.resetForm(); // Full reset including hiding notification
        } else {
          // Reset form data but keep notification visible
          this.$refs.reservationForm.formData = { ...this.initialData };
          this.$refs.reservationForm.errors = {};
          this.$refs.reservationForm.isSubmitting = false;
          this.$refs.reservationForm.files = {};
        }
      }
      
      // Reset submission state
      this.isSubmitting = false;
    }
  }
};
</script>