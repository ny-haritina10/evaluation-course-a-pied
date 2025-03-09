<!-- ###################################################################### -->
<!-- THIS IS AN EXAMPLE USAGE OF THE `Form.vue` COMPONENT USING STATIC DATA -->
<!-- ###################################################################### -->

<template>
  <div>
    <Form
      title="User Registration"
      subtitle="Fill in the details to create an account"
      :formFields="formFields"
      :initialData="initialData"
      submitButtonText="Register"
      :showCancelButton="true"
      cancelButtonText="Reset"
      @submit="handleSubmit"
      @cancel="handleCancel"
    />
  </div>
</template>

<script>
import Form from '../../components/Form.vue';

export default {
  components: { Form },
  data() {
    return {
      formFields: [
        { id: 'username', label: 'Username', type: 'text', required: true, placeholder: 'Enter username' },
        { id: 'email', label: 'Email', type: 'email', required: true, placeholder: 'Enter email' },
        { id: 'password', label: 'Password', type: 'password', required: true, placeholder: 'Enter password' },
        { id: 'confirmPassword', label: 'Confirm Password', type: 'password', required: true, placeholder: 'Confirm password' },
        { id: 'gender', label: 'Gender', type: 'select', required: true, placeholder: 'Select a gender', options: [
          { value: 'male', label: 'Male' },
          { value: 'female', label: 'Female' },
          { value: 'other', label: 'Other' }
        ] },
        { id: 'gender-radio', label: 'Gender', type: 'radio', required: true, options: [
          { value: 'male', label: 'Male' },
          { value: 'female', label: 'Female' },
          { value: 'other', label: 'Other' }
        ] },
      ],
      initialData: {
        username: '',
        email: '',
        password: '',
        confirmPassword: '',
        gender: '',
        terms: false
      }
    };
  },
  methods: {
    handleSubmit(formData) {
      console.log('Submitted Data:', formData);
      alert('Registration successful!');
    },
    handleCancel() {
      this.initialData = {
        username: '',
        email: '',
        password: '',
        confirmPassword: '',
        gender: '',
        terms: false
      };
    }
  }
};
</script>