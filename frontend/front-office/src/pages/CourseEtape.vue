<template>
  <div class="container mt-4">
    <h1 class="mb-4">Course and Etapes Viewer</h1>
    
    <!-- Loading Indicator -->
    <div v-if="loading" class="text-center my-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-2">Loading data...</p>
    </div>
    
    <!-- Error Message -->
    <div v-if="error" class="alert alert-danger">
      {{ error }}
    </div>
    
    <!-- Main Content -->
    <div v-if="!loading && !error">
      <!-- Courses Cards -->
      <div class="row">
        <div v-for="course in paginatedCourses" :key="course.id" class="col-md-12 mb-4">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h2 class="h4 mb-0">{{ course.label }}</h2>
              <button 
                class="btn btn-light btn-sm" 
                @click="toggleCourse(course.id)"
              >
                {{ expandedCourses.includes(course.id) ? 'Hide Details' : 'Show Details' }}
              </button>
            </div>
            
            <div class="card-body" v-if="expandedCourses.includes(course.id)">
              <div v-if="course.etapes.length === 0" class="text-muted text-center py-3">
                No stages available for this course.
              </div>
              
              <div v-else class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>Stage</th>
                      <th>Date</th>
                      <th>Start Time</th>
                      <th>Distance (km)</th>
                      <th>Runners</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="etape in course.etapes" :key="etape.id">
                      <td>{{ etape.label }}</td>
                      <td>{{ formatDate(etape.date_etape) }}</td>
                      <td>{{ formatTime(etape.heure_depart) }}</td>
                      <td>{{ etape.longueur_km }}</td>
                      <td>{{ etape.nbr_coureur }}</td>
                      <td>
                        <button 
                          class="btn btn-outline-primary btn-sm me-1"
                          @click="viewEtapeDetails(etape)"
                          data-bs-toggle="modal" 
                          data-bs-target="#etapeDetailsModal"
                        >
                          View Details
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Pagination -->
      <nav v-if="totalPages > 1" aria-label="Courses pagination" class="d-flex justify-content-center mt-4">
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: currentPage === 1 }">
            <a class="page-link" @click="changePage(currentPage - 1)" href="javascript:void(0)">Previous</a>
          </li>
          <li 
            v-for="page in pagesArray" 
            :key="page" 
            class="page-item"
            :class="{ active: currentPage === page }"
          >
            <a class="page-link" @click="changePage(page)" href="javascript:void(0)">{{ page }}</a>
          </li>
          <li class="page-item" :class="{ disabled: currentPage === totalPages }">
            <a class="page-link" @click="changePage(currentPage + 1)" href="javascript:void(0)">Next</a>
          </li>
        </ul>
      </nav>
      
      <!-- Modal for Etape Details -->
      <div class="modal fade" id="etapeDetailsModal" tabindex="-1" aria-labelledby="etapeDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="etapeDetailsModalLabel">
                {{ selectedEtape ? selectedEtape.label : 'Stage Details' }}
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" v-if="selectedEtape">
              <div class="row mb-4">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header bg-info text-white">Stage Information</div>
                    <div class="card-body">
                      <p><strong>Date:</strong> {{ formatDate(selectedEtape.date_etape) }}</p>
                      <p><strong>Start time:</strong> {{ formatTime(selectedEtape.heure_depart) }}</p>
                      <p><strong>Distance:</strong> {{ selectedEtape.longueur_km }} km</p>
                      <p><strong>Number of runners:</strong> {{ selectedEtape.nbr_coureur }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header bg-success text-white">Points Structure</div>
                    <div class="card-body">
                      <table class="table table-sm">
                        <thead>
                          <tr>
                            <th>Rank</th>
                            <th>Points</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="point in selectedEtape.rang_points" :key="point.id">
                            <td>{{ point.rang }}</td>
                            <td>{{ point.point_attribue }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header bg-warning">
                  Runners List
                </div>
                <div class="card-body">
                  <div v-if="selectedEtape.coureurs.length === 0" class="text-muted text-center py-3">
                    No runners registered for this stage.
                  </div>
                  <table v-else class="table table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="coureur in selectedEtape.coureurs" :key="coureur.id">
                        <td>{{ coureur.id }}</td>
                        <td>{{ coureur.name }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import api from '@/api/axiosInstance';

export default {

  name: 'CourseEtapesViewer',
  data() {
    return {
      courses: [],
      loading: true,
      error: null,
      expandedCourses: [],
      selectedEtape: null,
      
      // Pagination
      currentPage: 1,
      coursesPerPage: 1,
    }
  },
  computed: {
    totalPages() {
      return Math.ceil(this.courses.length / this.coursesPerPage);
    },
    paginatedCourses() {
      const startIndex = (this.currentPage - 1) * this.coursesPerPage;
      const endIndex = startIndex + this.coursesPerPage;
      return this.courses.slice(startIndex, endIndex);
    },
    pagesArray() {
      return Array.from({ length: this.totalPages }, (_, i) => i + 1);
    }
  },
  methods: {
    async fetchData() {
      this.loading = true;
      this.error = null;

      try {
        const response = await api.get('/equipe/courses/etapes');
        
        // Axios puts the response data in response.data
        const data = response.data;

        if (data.status === 'success') {
          this.courses = data.data;
          
          // Auto-expand first course if available
          if (this.courses.length > 0) {
            this.expandedCourses = [this.courses[0].id];
          }
        } else {
          throw new Error(data.message || 'Failed to fetch data');
        }
      } catch (err) {
        const errorMessage = err.response?.data?.message || err.message || 'An error occurred';
        this.error = `Error loading data: ${errorMessage}`;
        console.error(err);
      } finally {
        this.loading = false;
      }
    },
    toggleCourse(courseId) {
      if (this.expandedCourses.includes(courseId)) {
        this.expandedCourses = this.expandedCourses.filter(id => id !== courseId);
      } else {
        this.expandedCourses.push(courseId);
      }
    },
    viewEtapeDetails(etape) {
      this.selectedEtape = etape;
    },
    formatDate(dateString) {
      if (!dateString) return 'N/A';
      
      const date = new Date(dateString);
      return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
      }).format(date);
    },
    formatTime(timeString) {
      if (!timeString) return 'N/A';
      
      const timeParts = timeString.split(':');
      return `${timeParts[0]}:${timeParts[1]}`;
    },
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        window.scrollTo(0, 0);
      }
    }
  },
  mounted() {
    this.fetchData();
  }
}
</script>

<style scoped>
.card {
  transition: all 0.3s ease;
}

.card:hover {
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.page-link {
  cursor: pointer;
}

.table {
  margin-bottom: 0;
}

.card-header {
  font-weight: bold;
}
</style>