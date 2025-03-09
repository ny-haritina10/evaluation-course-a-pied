<template>
  <div class="app-table">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <div>
          <h5 class="card-title mb-0">{{ title }}</h5>
          <p v-if="subtitle" class="card-subtitle text-muted mt-1 mb-0">{{ subtitle }}</p>
        </div>
        
        <div class="d-flex align-items-center">
          <!-- Search Input -->
          <div v-if="showSearch" class="search-container me-2">
            <div class="input-group">
              <span class="input-group-text bg-light border-0">
                <i class="bi bi-search"></i>
              </span>
              <input 
                type="text" 
                class="form-control border-0 bg-light"
                v-model="searchQuery"
                placeholder="Keyword search..."
                @input="handleSearch"
              >
            </div>
          </div>
          
          <!-- Actions Slot -->
          <slot name="actions"></slot>
        </div>
      </div>
      
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <!-- Column Headers -->
                <th 
                  v-for="column in columns" 
                  :key="column.key"
                  :class="[
                    column.headerClass, 
                    column.sortable ? 'sortable-column' : '',
                    'px-4'
                  ]"
                  :style="column.width ? `width: ${column.width}` : ''"
                  @click="column.sortable ? sortBy(column.key) : null"
                >
                  <div class="d-flex align-items-center">
                    <span>{{ column.label }}</span>
                    <span v-if="column.sortable" class="ms-1">
                      <i v-if="sortKey === column.key" 
                         class="bi" 
                         :class="sortOrder === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill'">
                      </i>
                      <i v-else class="bi bi-arrow-down-up text-muted opacity-50"></i>
                    </span>
                  </div>
                </th>
                
                <!-- Actions Column -->
                <th v-if="hasRowActions || $slots.rowActions" class="px-4 text-end">
                  Actions
                </th>
              </tr>
            </thead>
            
            <tbody>
              <!-- Loading State -->
              <tr v-if="loading">
                <td :colspan="calculateColspan()" class="text-center py-5">
                  <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                  <p class="mt-2 text-muted">Loading data...</p>
                </td>
              </tr>
              
              <!-- Empty State -->
              <tr v-else-if="filteredItems.length === 0">
                <td :colspan="calculateColspan()" class="text-center py-5">
                  <div class="empty-state">
                    <i class="bi bi-inbox text-muted display-1"></i>
                    <h5 class="mt-3">{{ emptyStateText }}</h5>
                    <p class="text-muted">{{ emptyStateSubtext }}</p>
                  </div>
                </td>
              </tr>
              
              <!-- Table Data -->
              <tr 
                v-else 
                v-for="(item, index) in paginatedItems" 
                :key="item.id || index"
              > 
                <td 
                  v-for="column in columns" 
                  :key="column.key"
                  :class="column.cellClass"
                  class="px-4"
                >
                  <slot 
                    :name="`cell-${column.key}`" 
                    :item="item" 
                    :value="getCellValue(item, column.key)"
                  >
                    <!-- Apply formatter if provided, otherwise handle type-based formatting -->
                    <span v-if="column.formatter">
                      {{ column.formatter(getCellValue(item, column.key), item) }}
                    </span>
                    <span v-else-if="column.type === 'currency'">
                      {{ formatNumber(getCellValue(item, column.key), { style: 'currency', currency: column.currency || 'USD' }) }}
                    </span>
                    <span v-else-if="column.type === 'number'">
                      {{ formatNumber(getCellValue(item, column.key), { decimals: column.decimals || 2 }) }}
                    </span>
                    <span v-else>
                      {{ getCellValue(item, column.key) }}
                    </span>
                  </slot>
                </td>
                
                <!-- Row Actions -->
                <td v-if="hasRowActions || $slots.rowActions" class="px-4 text-end">
                  <slot name="rowActions" :item="item">
                    <div class="btn-group">
                      <button 
                        v-for="action in rowActions" 
                        :key="action.key"
                        type="button" 
                        class="btn btn-sm"
                        :class="action.class || 'btn-outline-secondary'"
                        @click="handleRowAction(action.key, item)"
                      >
                        <i v-if="action.icon" :class="`bi bi-${action.icon}`"></i>
                        <span v-if="action.label">{{ action.label }}</span>
                      </button>
                    </div>
                  </slot>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <!-- Pagination -->
      <div 
        v-if="showPagination && filteredItems.length > 0" 
        class="card-footer bg-white d-flex align-items-center justify-content-between py-3"
      >
        <div class="pagination-info text-muted small">
          Showing {{ paginationInfo.from }} to {{ paginationInfo.to }} of {{ filteredItems.length }} entries
        </div>
        
        <nav aria-label="Table pagination">
          <ul class="pagination pagination-sm mb-0">
            <!-- First Page -->
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <a class="page-link" href="#" @click.prevent="goToPage(1)">
                <i class="bi bi-chevron-double-left"></i>
              </a>
            </li>
            
            <!-- Previous Page -->
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">
                <i class="bi bi-chevron-left"></i>
              </a>
            </li>
            
            <!-- Page Numbers -->
            <li 
              v-for="page in visiblePageNumbers" 
              :key="page"
              class="page-item" 
              :class="{ active: currentPage === page }"
            >
              <a class="page-link" href="#" @click.prevent="goToPage(page)">
                {{ page }}
              </a>
            </li>
            
            <!-- Next Page -->
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">
                <i class="bi bi-chevron-right"></i>
              </a>
            </li>
            
            <!-- Last Page -->
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <a class="page-link" href="#" @click.prevent="goToPage(totalPages)">
                <i class="bi bi-chevron-double-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'List',
  props: {
    title: {
      type: String,
      default: 'Data Table'
    },
    subtitle: {
      type: String,
      default: ''
    },
    columns: {
      type: Array,
      required: true
    },
    items: {
      type: Array,
      required: true
    },
    loading: {
      type: Boolean,
      default: false
    },
    emptyStateText: {
      type: String,
      default: 'No items found'
    },
    emptyStateSubtext: {
      type: String,
      default: 'Try adjusting your search or filter to find what you\'re looking for.'
    },
    rowActions: {
      type: Array,
      default: () => []
    },
    pagination: {
      type: Boolean,
      default: true
    },
    itemsPerPage: {
      type: Number,
      default: 10
    },
    showSearch: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      searchQuery: '',
      selectedItems: [],
      currentPage: 1
    }
  },
  computed: {
    hasRowActions() {
      return this.rowActions && this.rowActions.length > 0;
    },
    filteredItems() {
      let result = [...this.items];
      
      // Apply search filter
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        result = result.filter(item => {
          return this.columns.some(column => {
            const value = this.getCellValue(item, column.key);
            return value != null && String(value).toLowerCase().includes(query);
          });
        });
      }
      
      return result;
    },
    showPagination() {
      return this.pagination && this.filteredItems.length > this.itemsPerPage;
    },
    totalPages() {
      return Math.ceil(this.filteredItems.length / this.itemsPerPage);
    },
    paginatedItems() {
      if (!this.pagination) return this.filteredItems;
      
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredItems.slice(start, end);
    },
    paginationInfo() {
      const from = this.filteredItems.length === 0 
        ? 0 
        : (this.currentPage - 1) * this.itemsPerPage + 1;
        
      const to = Math.min(this.currentPage * this.itemsPerPage, this.filteredItems.length);
      
      return { from, to };
    },
    visiblePageNumbers() {
      const delta = 2; // Number of pages to show before and after current page
      const range = [];
      
      // Always show first page
      range.push(1);
      
      // Calculate start and end of range
      const rangeStart = Math.max(2, this.currentPage - delta);
      const rangeEnd = Math.min(this.totalPages - 1, this.currentPage + delta);
      
      // Add ellipsis after first page if necessary
      if (rangeStart > 2) {
        range.push('...');
      }
      
      // Add pages in the middle of the range
      for (let i = rangeStart; i <= rangeEnd; i++) {
        range.push(i);
      }
      
      // Add ellipsis before last page if necessary
      if (rangeEnd < this.totalPages - 1) {
        range.push('...');
      }
      
      // Always show last page if there is more than one page
      if (this.totalPages > 1) {
        range.push(this.totalPages);
      }
      
      return range;
    }
  },
  methods: {
    formatNumber(value, options = {}) {
      if (value == null || isNaN(value)) return value;
      return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: options.decimals || 0,
        maximumFractionDigits: options.decimals || 2,
        style: options.style || 'decimal',
        currency: options.currency || 'USD',
      }).format(value);
    },
    getCellValue(item, key) {
      const keys = key.split('.');
      let value = item;
      
      for (const k of keys) {
        if (value === null || value === undefined) return '';
        value = value[k];
      }
      
      return value;
    },
    handleRowAction(actionKey, item) {
      this.$emit('row-action', { action: actionKey, item });
    },
    handleSearch() {
      this.currentPage = 1;
      this.$emit('search', this.searchQuery);
    },
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        this.$emit('page-change', page);
      }
    },
    calculateColspan() {
      let count = this.columns.length;
      if (this.selectable) count++;
      if (this.hasRowActions || this.$slots.rowActions) count++;
      return count;
    }
  }
}
</script>

<style scoped>
.app-table {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.card {
  border-radius: 8px;
  overflow: hidden;
}

.card-header {
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.card-footer {
  border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.search-container {
  width: 240px;
}

.search-container .form-control {
  height: 38px;
  border-top-right-radius: 6px;
  border-bottom-right-radius: 6px;
}

.search-container .input-group-text {
  border-top-left-radius: 6px;
  border-bottom-left-radius: 6px;
}

.search-container .form-control:focus {
  box-shadow: none;
}

table {
  margin-bottom: 0;
}

th {
  font-weight: 600;
  color: #495057;
  font-size: 0.875rem;
}

td {
  vertical-align: middle;
  font-size: 0.875rem;
}

.empty-state {
  padding: 2rem 0;
  text-align: center;
}

.pagination {
  margin-bottom: 0;
}

.pagination .page-link {
  border-radius: 4px;
  margin: 0 2px;
}
</style>