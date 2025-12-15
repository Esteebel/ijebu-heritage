<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Publishing Queue</h1>
        <button class="btn btn-primary" v-if="isAdmin">
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          Bulk Publish
        </button>
      </div>

      <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Content Waiting to Go Live</h5>
            <div class="d-flex">
              <select class="form-select form-select-sm me-2" v-model="filters.module">
                <option value="">All Modules</option>
                <option value="kings">Kings</option>
                <option value="events">Events</option>
                <option value="artifacts">Gallery</option>
                <option value="timeline">Timeline</option>
              </select>
              <select class="form-select form-select-sm me-2" v-model="filters.author">
                <option value="">All Authors</option>
                <option value="me">My Content</option>
              </select>
              <input type="date" class="form-control form-control-sm" v-model="filters.date">
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Title/Name</th>
                <th>Type</th>
                <th>Author</th>
                <th>Status</th>
                <th>Last Updated</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in filteredItems" :key="item.id">
                <td>
                  <strong>{{ item.title }}</strong>
                </td>
                <td>{{ item.type }}</td>
                <td>{{ item.author }}</td>
                <td>
                  <span
                    :class="[
                      'badge',
                      item.status === 'draft' ? 'bg-secondary' :
                      item.status === 'ready' ? 'bg-primary' :
                      'bg-success'
                    ]"
                  >
                    {{ item.status }}
                  </span>
                </td>
                <td>{{ item.lastUpdated }}</td>
                <td>
                  <button
                    v-if="canPublish(item)"
                    @click="publishItem(item)"
                    class="btn btn-sm btn-success"
                  >
                    Set Live
                  </button>
                  <span v-else>-</span>
                </td>
              </tr>
              <tr v-if="filteredItems.length === 0">
                <td colspan="6" class="text-center py-5 text-muted">
                  <svg class="d-block mx-auto mb-2" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                  No content in the publishing queue
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer bg-white border-top">
          <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
              Showing {{ filteredItems.length }} of {{ publishingQueue.length }} items
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
                  <a class="page-link" href="#">2</a>
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
    AdminLayout
  },
  data() {
    return {
      filters: {
        module: '',
        author: '',
        date: ''
      },
      publishingQueue: [
        {
          id: 1,
          title: 'Ancient Artifacts Exhibition',
          type: 'Event',
          author: 'Editor John',
          authorId: 2,
          status: 'ready',
          lastUpdated: '2 hours ago'
        },
        {
          id: 2,
          title: 'Kingdom Timeline Update',
          type: 'Timeline',
          author: 'Editor Sarah',
          authorId: 3,
          status: 'draft',
          lastUpdated: '1 day ago'
        },
        {
          id: 3,
          title: 'Royal Ceremonies Gallery',
          type: 'Gallery',
          author: 'Admin User',
          authorId: 1,
          status: 'ready',
          lastUpdated: '3 days ago'
        },
        {
          id: 4,
          title: 'King Ogunmola Biography',
          type: 'King',
          author: 'Editor John',
          authorId: 2,
          status: 'ready',
          lastUpdated: '5 days ago'
        }
      ]
    }
  },
  computed: {
    isAdmin() {
      return this.$page.props.auth &&
             this.$page.props.auth.user &&
             this.$page.props.auth.user.role === 'admin';
    },
    filteredItems() {
      let items = this.publishingQueue;

      if (this.filters.module) {
        items = items.filter(item => item.type.toLowerCase().includes(this.filters.module));
      }

      if (this.filters.author === 'me') {
        const userId = this.$page.props.auth.user.id;
        items = items.filter(item => item.authorId === userId);
      }

      if (this.filters.date) {
        // In a real implementation, this would filter by date
      }

      return items;
    }
  },
  methods: {
    canPublish(item) {
      // Admins can publish anything, editors can only publish their own content
      if (this.isAdmin) return true;
      return item.authorId === this.$page.props.auth.user.id;
    },
    publishItem(item) {
      // Show confirmation modal before publishing
      if (confirm('This action will make this content visible to the public. Are you sure?')) {
        // In a real implementation, this would make an API call to publish the item
        alert(`Publishing "${item.title}"...`);
        // Refresh the page or update the UI accordingly
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
