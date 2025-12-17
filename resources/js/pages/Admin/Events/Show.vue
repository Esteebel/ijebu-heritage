<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Event Details</h1>
        <div class="d-flex gap-2">
          <inertia-link
            :href="$route('admin.events.edit', event.id)"
            class="btn btn-primary"
          >
            <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Event
          </inertia-link>
          <inertia-link
            :href="$route('admin.events.index')"
            class="btn btn-outline-secondary"
          >
            <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Events
          </inertia-link>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ event.title }}</h5>
                <span class="badge bg-success">Published</span>
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-4">
                <div class="col-md-6">
                  <p class="mb-1"><strong>Start Date & Time:</strong></p>
                  <p>{{ formatDate(event.start_datetime) }}</p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1"><strong>End Date & Time:</strong></p>
                  <p>{{ formatDate(event.end_datetime) }}</p>
                </div>
              </div>

              <div class="mb-4">
                <p class="mb-1"><strong>Location:</strong></p>
                <p>{{ event.location || 'Not specified' }}</p>
              </div>

              <div>
                <p class="mb-1"><strong>Description:</strong></p>
                <div class="border rounded p-3 bg-light">
                  <p class="mb-0" v-html="event.description || 'No description provided.'"></p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Featured Media</h5>
            </div>
            <div class="card-body">
              <div v-if="event.featuredMedia" class="text-center">
                <img
                  :src="`/storage/${event.featuredMedia.file_path}`"
                  :alt="event.featuredMedia.file_name"
                  class="img-fluid rounded"
                >
                <p class="mt-2 mb-0 text-muted">{{ event.featuredMedia.file_name }}</p>
              </div>
              <div v-else class="text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                  <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <p class="mb-0">No featured image selected</p>
              </div>
            </div>
          </div>

          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Event Metadata</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <p class="mb-1"><strong>Created:</strong></p>
                  <p class="text-muted">{{ formatDate(event.created_at) }}</p>
                </div>
                <div class="col-6">
                  <p class="mb-1"><strong>Last Updated:</strong></p>
                  <p class="text-muted">{{ formatDate(event.updated_at) }}</p>
                </div>
              </div>

              <div class="mt-3 pt-3 border-top">
                <button
                  v-if="isAdmin"
                  @click="destroy"
                  class="btn btn-danger w-100"
                >
                  <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                  Delete Event
                </button>
              </div>
            </div>
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
    event: Object,
  },
  computed: {
    isAdmin() {
      return this.$page.props.auth &&
             this.$page.props.auth.user &&
             this.$page.props.auth.user.role === 'admin';
    }
  },
  methods: {
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
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
        this.$inertia.delete(this.$route('admin.events.destroy', this.event.id));
      }
    }
  }
}
</script>

<style scoped>
.card-title {
  font-weight: 600;
}

.border.rounded {
  border: 1px solid rgba(0,0,0,0.125);
}
</style>
