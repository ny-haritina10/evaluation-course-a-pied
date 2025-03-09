<template>
  <div>
    <List 
      :title="'Product List'" 
      :subtitle="'List of available products'"
      :columns="columns"
      :items="products"
      :loading="loading"
      :pagination="true"
      :itemsPerPage="3"
      @selection-change="onSelectionChange"
      @row-action="onRowAction"
      @search="onSearch"
    >
      <template v-slot:rowActions="{ item }">
        <button class="btn btn-info btn-sm" @click="viewProductDetails(item)">
          View
        </button>
        <button class="btn btn-danger btn-sm" @click="deleteProduct(item)">
          Delete
        </button>
      </template>
    </List>
  </div>
</template>

<script>
import List from '../../components/List.vue';

export default {
  components: {
    List
  },
  data() {
    return {
      loading: false,
      products: [
        { id: 1, name: 'Product 1', category: 'Category A', price: 10.0 },
        { id: 2, name: 'Product 2', category: 'Category B', price: 15.5 },
        { id: 3, name: 'Product 3', category: 'Category C', price: 20.0 },
        { id: 4, name: 'Product 4', category: 'Category A', price: 25.5 },
        { id: 5, name: 'Product 5', category: 'Category B', price: 30.0 },
        { id: 6, name: 'Product 6', category: 'Category C', price: 35.0 },
        { id: 7, name: 'Product 7', category: 'Category A', price: 40.0 }
      ],
      columns: [
        { key: 'name', label: 'Product Name' },
        { key: 'category', label: 'Category' },
        { key: 'price', label: 'Price' }
      ]
    };
  },
  methods: {
    onSelectionChange(selectedItems) {
      console.log('Selected items:', selectedItems);
    },
    onRowAction(actionData) {
      console.log('Row action:', actionData);
    },
    onSearch(searchQuery) {
      console.log('Search query:', searchQuery);
    },
    viewProductDetails(product) {
      alert(`Viewing details for: ${product.name}`);
    },
    deleteProduct(product) {
      if (confirm(`Are you sure you want to delete ${product.name}?`)) {
        this.products = this.products.filter(p => p.id !== product.id);
      }
    }
  }
}
</script>