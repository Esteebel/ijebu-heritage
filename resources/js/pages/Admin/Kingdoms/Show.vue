<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">{{ kingdom.name }}</h1>
        <div>
          <inertia-link
            :href="$route('kingdoms.show', kingdom.id)"
            class="btn btn-primary me-2"
          >
            View Public
          </inertia-link>
          <inertia-link
            :href="$route('admin.dynasties.edit', kingdom.id)"
            class="btn btn-primary me-2"
          >
            <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit
          </inertia-link>
          <button
            v-if="isAdmin"
            @click="destroy"
            class="btn btn-danger"
          >
            <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Delete
          </button>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Kingdom Information</h5>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Name</strong>
                </div>
                <div class="col-sm-9">
                  {{ kingdom.name }}
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Period</strong>
                </div>
                <div class="col-sm-9">
                  {{ kingdom.start_year }} - {{ kingdom.end_year }}
                </div>
              </div>

              <div class="row">
                <div class="col-sm-3">
                  <strong>Description</strong>
                </div>
                <div class="col-sm-9">
                  {{ kingdom.description || 'No description provided' }}
                </div>
              </div>
            </div>
          </div>

          <div class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Associated Kings</h5>
            </div>
            <div class="card-body">
              <div v-if="kingdom.kings && kingdom.kings.length > 0">
                <div class="row">
                  <div v-for="king in kingdom.kings" :key="king.id" class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                      <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <span class="fw-bold">{{ king.name.charAt(0) }}</span>
                      </div>
                      <div>
                        <strong>{{ king.name }}</strong>
                        <div class="small text-muted">Reign: {{ king.reign_start_date }} - {{ king.reign_end_date }}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else>
                <p class="mb-0 text-muted">No kings associated with this kingdom.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Details</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Kings Count</label>
                <input type="text" class="form-control" :value="kingdom.kings_count" readonly>
              </div>

              <div class="mb-3">
                <label class="form-label">Created At</label>
                <input type="text" class="form-control" :value="kingdom.created_at" readonly>
              </div>

              <div class="mb-0">
                <label class="form-label">Last Updated</label>
                <input type="text" class="form-control" :value="kingdom.updated_at" readonly>
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
    kingdom: Object,
  },
  computed: {
    isAdmin() {
      return this.$page.props.auth &&
             this.$page.props.auth.user &&
             this.$page.props.auth.user.role === 'admin';
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
        this.$inertia.delete(this.$route('admin.dynasties.destroy', this.kingdom.id));
      }
    }
  }
}
</script>

<style scoped>
.card-title {
  font-size: 1.1rem;
}

.row {
  margin-bottom: 1rem;
}

.row:last-child {
  margin-bottom: 0;
}
</style>
