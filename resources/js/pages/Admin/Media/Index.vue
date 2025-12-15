<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Media Library</h1>
        <inertia-link
          :href="$route('media.create')"
          class="btn btn-primary"
        >
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Upload Media
        </inertia-link>
      </div>

      <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Media Items</h5>
            <div class="d-flex">
              <input type="text" class="form-control form-control-sm me-2" placeholder="Search media...">
              <select class="form-select form-select-sm me-2">
                <option>All Types</option>
                <option>Images</option>
                <option>Videos</option>
                <option>Documents</option>
              </select>
              <select class="form-select form-select-sm">
                <option>Newest First</option>
                <option>Oldest First</option>
                <option>Name A-Z</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-4">
            <div v-for="medium in media" :key="medium.id" class="col-md-6 col-lg-4 col-xl-3">
              <div class="card h-100">
                <div class="position-relative" style="height: 150px; overflow: hidden;">
                  <img v-if="medium.type === 'image'" :src="'/storage/' + medium.path" :alt="medium.name" class="card-img-top h-100 object-fit-cover">
                  <video v-else-if="medium.type === 'video'" class="card-img-top h-100 object-fit-cover">
                    <source :src="'/storage/' + medium.path" :type="medium.mime_type">
                    Your browser does not support the video tag.
                  </video>
                  <div v-else class="d-flex align-items-center justify-content-center h-100 bg-light">
                    <svg class="text-muted" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                  </div>
                </div>
                <div class="card-body d-flex flex-column">
                  <h6 class="card-title text-truncate mb-1">{{ medium.name }}</h6>
                  <small class="text-muted mb-2">{{ medium.mime_type }}</small>
                  <div class="mt-auto d-flex justify-content-between">
                    <inertia-link
                      :href="$route('media.edit', medium.id)"
                      class="btn btn-sm btn-outline-primary"
                    >
                      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                    </inertia-link>
                    <button
                      @click="destroy(medium.id)"
                      class="btn btn-sm btn-outline-danger"
                    >
                      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer bg-white border-top">
          <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
              Showing {{ media.length }} of {{ media.length }} media items
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
    media: Array,
  },
  methods: {
    destroy(id) {
      if (confirm('Are you sure you want to delete this media item?')) {
        this.$inertia.delete(this.$route('media.destroy', id))
      }
    }
  }
}
</script>

<style scoped>
.card-title {
  font-size: 0.95rem;
}

.object-fit-cover {
  object-fit: cover;
}
</style>
