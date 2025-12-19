<template>
  <AdminLayout>
    <div class="container-fluid py-4">
      <div class="row mb-4">
        <div class="col">
          <inertia-link :href="$route('admin.publishing.queue.index')" class="btn btn-link text-decoration-none">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Publishing Queue
          </inertia-link>
          <h1 class="h3 mt-2 mb-0">{{ publishingQueueItem.title }}</h1>
        </div>
        <div class="col-auto">
          <div class="btn-group" role="group">
            <inertia-link
              :href="$route('admin.publishing.queue.edit', publishingQueueItem.id)"
              class="btn btn-primary"
            >
              Edit
            </inertia-link>
            <button
              @click="destroy"
              class="btn btn-danger"
            >
              Delete
            </button>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Queue Item Details</h5>
                <span :class="getStatusBadgeClass(publishingQueueItem.status)">
                  {{ publishingQueueItem.status.charAt(0).toUpperCase() + publishingQueueItem.status.slice(1) }}
                </span>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <p><strong>Type:</strong>
                    <span :class="getTypeBadgeClass(publishingQueueItem.type)">
                      {{ publishingQueueItem.type.charAt(0).toUpperCase() + publishingQueueItem.type.slice(1) }}
                    </span>
                  </p>
                </div>
                <div class="col-md-6">
                  <p><strong>Created By:</strong> {{ publishingQueueItem.user.name }}</p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <p><strong>Created At:</strong> {{ formatDate(publishingQueueItem.created_at) }}</p>
                </div>
                <div class="col-md-6">
                  <p v-if="publishingQueueItem.published_at">
                    <strong>Published At:</strong> {{ formatDate(publishingQueueItem.published_at) }}
                  </p>
                  <p v-else>
                    <strong>Scheduled For:</strong>
                    <span v-if="publishingQueueItem.scheduled_at">
                      {{ formatDate(publishingQueueItem.scheduled_at) }}
                    </span>
                    <span v-else>N/A</span>
                  </p>
                </div>
              </div>

              <div class="mb-3">
                <p><strong>Description:</strong></p>
                <p>{{ publishingQueueItem.description || 'No description provided' }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Actions</h5>
            </div>
            <div class="card-body">
              <div v-if="publishingQueueItem.status !== 'published'" class="d-grid gap-2">
                <button
                  @click="publishItem"
                  class="btn btn-success"
                >
                  Publish Now
                </button>
              </div>
              <div v-else class="alert alert-success mb-0">
                <strong>This item has been published.</strong>
              </div>
            </div>
          </div>

          <div class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Metadata</h5>
            </div>
            <div class="card-body">
              <p class="mb-0 text-muted">
                <small>
                  This item is in the publishing queue and will be processed according to its status and schedule.
                </small>
              </p>
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
  components: {
    AdminLayout,
  },
  props: {
    publishingQueueItem: {
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
        this.$inertia.delete(this.$route('admin.publishing.queue.destroy', this.publishingQueueItem.id));
      }
    },
    async publishItem() {
      const result = await this.$swal.fire({
        title: 'Publish Item?',
        text: "Are you sure you want to publish this item now?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, publish it!'
      });

      if (result.isConfirmed) {
        this.$inertia.post(this.$route('admin.publishing.queue.publish', this.publishingQueueItem.id));
      }
    },
    formatDate(dateString) {
      if (!dateString) return 'N/A'
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    },
    getTypeBadgeClass(type) {
      const classes = {
        'king': 'badge bg-primary',
        'event': 'badge bg-success',
        'artifact': 'badge bg-warning',
        'tour': 'badge bg-info',
        'ticket': 'badge bg-secondary'
      }
      return classes[type] || 'badge bg-secondary'
    },
    getStatusBadgeClass(status) {
      const classes = {
        'draft': 'badge bg-warning',
        'ready': 'badge bg-info',
        'published': 'badge bg-success'
      }
      return classes[status] || 'badge bg-secondary'
    }
  }
}
</script>
