<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <!-- Header -->
      <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
          <h1 class="h3 mb-0">Publishing Queue</h1>
          <button
            @click="$inertia.visit(route('admin.publishing.queue.create'))"
            class="btn btn-primary"
          >
            <i class="bi bi-plus-circle me-1"></i> Add New Item
          </button>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-primary bg-opacity-10 me-3">
                  <i class="bi bi-file-earmark-text text-primary dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Total Items</h6>
                  <h3 class="mb-0">{{ totalItems }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-warning bg-opacity-10 me-3">
                  <i class="bi bi-pencil-square text-warning dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Draft</h6>
                  <h3 class="mb-0">{{ draftItems }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-info bg-opacity-10 me-3">
                  <i class="bi bi-check-circle text-info dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Ready</h6>
                  <h3 class="mb-0">{{ readyItems }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-success bg-opacity-10 me-3">
                  <i class="bi bi-box-arrow-up-right text-success dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Published</h6>
                  <h3 class="mb-0">{{ publishedItems }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Publishing Queue Table -->
      <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Queue Items</h5>
          <div class="d-flex gap-2">
            <select class="form-select form-select-sm" v-model="filterType">
              <option value="">All Types</option>
              <option value="king">Kings</option>
              <option value="event">Events</option>
              <option value="artifact">Artifacts</option>
              <option value="tour">Tours</option>
              <option value="ticket">Tickets</option>
            </select>
            <select class="form-select form-select-sm" v-model="filterStatus">
              <option value="">All Status</option>
              <option value="draft">Draft</option>
              <option value="ready">Ready</option>
              <option value="published">Published</option>
            </select>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Description</th>
                <th>Author</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in filteredItems" :key="item.id">
                <td>{{ item.title }}</td>
                <td>
                  <span class="badge" :class="getTypeBadgeClass(item.type)">
                    {{ item.type }}
                  </span>
                </td>
                <td>{{ item.description || 'No description' }}</td>
                <td>{{ item.user.name }}</td>
                <td>
                  <span class="badge" :class="getStatusBadgeClass(item.status)">
                    {{ item.status }}
                  </span>
                </td>
                <td>{{ formatDate(item.created_at) }}</td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    <button
                      v-if="item.status !== 'published'"
                      @click="publishItem(item)"
                      class="btn btn-success"
                      title="Publish"
                    >
                      <i class="bi bi-box-arrow-up-right"></i>
                    </button>
                    <button
                      @click="$inertia.visit(route('admin.publishing.queue.edit', item.id))"
                      class="btn btn-outline-primary"
                      title="Edit"
                    >
                      <i class="bi bi-pencil"></i>
                    </button>
                    <button
                      @click="deleteItem(item)"
                      class="btn btn-outline-danger"
                      title="Delete"
                    >
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="filteredItems.length === 0">
                <td colspan="7" class="text-center text-muted py-5">
                  <i class="bi bi-inbox display-5 d-block mb-3"></i>
                  <p class="mb-0">No items in the publishing queue</p>
                  <button
                    @click="$inertia.visit(route('admin.publishing.queue.create'))"
                    class="btn btn-primary btn-sm mt-2"
                  >
                    <i class="bi bi-plus-circle me-1"></i> Add First Item
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer bg-white border-top">
          <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
              Showing {{ filteredItems.length }} of {{ totalItems }} items
            </small>
            <!-- Pagination would go here if needed -->
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
    AdminLayout
  },
  props: {
    publishingQueueItems: {
      type: Object,
      default: () => ({ data: [] })
    }
  },
  data() {
    return {
      filterType: '',
      filterStatus: ''
    }
  },
  computed: {
    items() {
      return this.publishingQueueItems.data || []
    },
    totalItems() {
      return this.items.length
    },
    draftItems() {
      return this.items.filter(item => item.status === 'draft').length
    },
    readyItems() {
      return this.items.filter(item => item.status === 'ready').length
    },
    publishedItems() {
      return this.items.filter(item => item.status === 'published').length
    },
    filteredItems() {
      let filtered = this.items

      if (this.filterType) {
        filtered = filtered.filter(item => item.type === this.filterType)
      }

      if (this.filterStatus) {
        filtered = filtered.filter(item => item.status === this.filterStatus)
      }

      return filtered
    }
  },
  methods: {
    route(name, params) {
      // Simple route helper for demonstration
      const routes = {
        'admin.publishing.queue.create': '/admin/publishing/queue/create',
        'admin.publishing.queue.edit': `/admin/publishing/queue/${params}/edit`
      }
      return routes[name] || '#'
    },
    formatDate(dateString) {
      if (!dateString) return ''
      const date = new Date(dateString)
      return date.toLocaleDateString()
    },
    getTypeBadgeClass(type) {
      const classes = {
        'king': 'bg-primary',
        'event': 'bg-success',
        'artifact': 'bg-warning',
        'tour': 'bg-info',
        'ticket': 'bg-secondary'
      }
      return classes[type] || 'bg-secondary'
    },
    getStatusBadgeClass(status) {
      const classes = {
        'draft': 'bg-warning',
        'ready': 'bg-info',
        'published': 'bg-success'
      }
      return classes[status] || 'bg-secondary'
    },
    publishItem(item) {
      if (confirm(`Are you sure you want to publish "${item.title}"?`)) {
        // In a real implementation, this would make an API call
        console.log('Publishing item:', item)
        alert(`Item "${item.title}" would be published in a real implementation.`)
      }
    },
    deleteItem(item) {
      if (confirm(`Are you sure you want to delete "${item.title}"? This action cannot be undone.`)) {
        // In a real implementation, this would make an API call
        console.log('Deleting item:', item)
        alert(`Item "${item.title}" would be deleted in a real implementation.`)
      }
    }
  }
}
</script>

<style scoped>
.icon-container {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.dashboard-icon {
  font-size: 24px;
}

.form-select-sm {
  max-width: 150px;
}
</style>
