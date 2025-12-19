<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>{{ tour.title }}</h1>
          <p class="text-muted">View virtual tour details</p>
        </div>
        <div class="col-auto">
          <div class="btn-group" role="group">
            <inertia-link :href="$route('admin.tours.edit', tour.id)" class="btn btn-primary">
              Edit
            </inertia-link>
            <button @click="destroy" class="btn btn-danger">
              Delete
            </button>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0">Tour Details</h5>
              <div class="d-flex gap-2 mt-2">
                <span :class="getDifficultyClass(tour.difficulty)">
                  {{ tour.difficulty.charAt(0).toUpperCase() + tour.difficulty.slice(1) }}
                </span>
                <span :class="tour.is_published ? 'badge bg-success' : 'badge bg-secondary'">
                  {{ tour.is_published ? 'Published' : 'Draft' }}
                </span>
              </div>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <p><strong>Duration:</strong> {{ tour.duration }}</p>
                </div>
                <div class="col-md-6">
                  <p><strong>Price:</strong> ₦{{ parseFloat(tour.price).toFixed(2) }}</p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <p><strong>Maximum Participants:</strong> {{ tour.max_participants }}</p>
                </div>
              </div>

              <div class="mb-3">
                <p><strong>Description:</strong></p>
                <p>{{ tour.description || 'No description provided' }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0">Featured Image</h5>
            </div>

            <div class="card-body">
              <img
                v-if="tour.featuredImage"
                :src="'/storage/' + tour.featuredImage.path"
                :alt="tour.featuredImage.filename"
                class="img-fluid rounded"
              >
              <div v-else class="text-center py-5">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto text-muted mb-3">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-muted mb-0">No featured image</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '../../../layouts/AdminLayout.vue'

export default {
  name: 'ToursShow',
  layout: AdminLayout,
  props: {
    tour: {
      type: Object,
      required: true
    }
  },
  methods: {
    async destroy() {
      const result = await this.$swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      });

      if (result.isConfirmed) {
        this.$inertia.delete(this.$route('admin.tours.destroy', this.tour.id));
      }
    },
    getDifficultyClass(difficulty) {
      const classes = {
        easy: 'badge bg-success',
        moderate: 'badge bg-warning text-dark',
        difficult: 'badge bg-danger'
      };
      return classes[difficulty] || 'badge bg-secondary';
    }
  }
}
</script>
