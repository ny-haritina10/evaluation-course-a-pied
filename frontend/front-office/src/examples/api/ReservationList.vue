<template>
  <div>
    <List 
      title="Reservation List" 
      subtitle="List of reservations for the client"
      :columns="columns"
      :items="reservations"
      :loading="loading"
      :selectable="true"
      :pagination="true"
      :itemsPerPage="3"
      @selection-change="onSelectionChange"
      @row-action="onRowAction"
    >
    </List>
  </div>
</template>

<script>
import List from '../../components/List.vue';
import api from '@/api/axiosInstance';

export default {
  components: {
    List
  },
  data() {
    return {
      loading: false,
      reservations: [],
      columns: [
        { key: 'reservation_date', label: 'Date' },
        { key: 'hour_begin', label: 'Start' },
        { key: 'hour_end', label: 'End' },
        { key: 'name_client', label: 'Client' },
        { key: 'options', label: 'Options' },
        { key: 'duration', label: 'Duration (hours)', type: 'number', decimals: 1 },
        { key: 'reservation_amount', label: 'Amount', type: 'currency', currency: 'MGA' },
        { key: 'status', label: 'Status' }
      ]
    };
  },
  created() {
    this.fetchReservations();
  },
  methods: {
    async fetchReservations() {
      this.loading = true;
      try {
        const clientId = 1; // hard-coded value 
        const response = await api.get(`/front-office/clients/${clientId}/reservations`);
        this.reservations = response.data.data;
      } catch (error) {
        console.error('Error fetching reservations:', error);
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
</style>