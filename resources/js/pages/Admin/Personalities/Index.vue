<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Notable Figures Management</h1>
        <inertia-link
          :href="$route('admin.personalities.create')"
          class="btn btn-primary"
        >
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Add Figure
        </inertia-link>
      </div>

      <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Notable Figures List</h5>
            <div class="d-flex">
              <input type="text" class="form-control form-control-sm me-2" placeholder="Search figures...">
              <select class="form-select form-select-sm">
                <option>All Tribes</option>
                <option>Ijebu</option>
                <option>Yoruba</option>
                <option>Other</option>
              </select>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Figure</th>
                <th>Lifespan</th>
                <th>Tribe</th>
                <th>Featured</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="personality in personalities" :key="personality.id">
                <td>
                  <div class="d-flex align-items-center">
                    <div v-if="personality.portrait" class="me-3">
                      <img :src="'/storage/' + personality.portrait.path" alt="Portrait" class="rounded-circle" width="50" height="50">
                    </div>
                    <div>
                      <strong>{{ personality.name }}</strong>
                      <div class="small text-muted">{{ personality.biography ? personality.biography.substring(0, 50) + '...' : 'No biography' }}</div>
                    </div>
                  </div>
                </td>
                <td>{{ personality.birth_year || '?' }} - {{ personality.death_year || '?' }}</td>
                <td>{{ personality.tribe || 'N/A' }}</td>
                <td>
                  <span v-if="personality.is_featured" class="badge bg-success">Featured</span>
                  <span v-else class="badge bg-secondary">Normal</span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <inertia-link
                      :href="$route('admin.personalities.edit', personality.id)"
                      class="btn btn-outline-secondary"
                    >
                      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                    </inertia-link>
                    <button
                      @click="destroy(personality.id)"
                      class="btn btn-outline-danger"
                    >
                      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer bg-white border-top">
          <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
              Showing {{ personalities.length }} of {{ personalities.length }} figures
            </div>
            <nav>
              <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active">
                  <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import AdminLayout from '../../../layouts/AdminLayout.vue'

export default {
  components: {
    AdminLayout,
  },
  props: {
    personalities: Array,
  },
  methods: {
    destroy(id) {
      if (confirm('Are you sure you want to delete this figure?')) {
        this.$inertia.delete(this.$route('admin.personalities.destroy', id))
      }
    }
  }
}
</script>

<style scoped>
.table th {
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.875rem;
  letter-spacing: 0.5px;
}
</style>
