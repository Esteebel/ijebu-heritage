<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">{{ king.name }}</h1>
        <div>
          <inertia-link
            :href="$route('admin.kings.edit', king.id)"
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
              <h5 class="card-title mb-0">King Information</h5>
            </div>
            <div class="card-body">
              <div class="row mb-4">
                <div class="col-12">
                  <div class="bg-light rounded d-flex align-items-center justify-content-center overflow-hidden mx-auto" style="height: 300px; max-width: 300px;">
                    <img
                      v-if="king.portraitMedia"
                      :src="'/storage/' + king.portraitMedia.path"
                      class="img-fluid w-100 h-100 object-fit-cover"
                      :alt="king.name"
                      style="object-fit: cover;"
                    >
                    <div v-else class="text-center p-4">
                      <i class="bi bi-person-circle text-muted" style="font-size: 6rem;"></i>
                      <p class="text-muted mt-3 mb-0">No Image Available</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Name</strong>
                </div>
                <div class="col-sm-9">
                  {{ king.name }}
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Regnal Name</strong>
                </div>
                <div class="col-sm-9">
                  {{ king.regnal_name || 'Not specified' }}
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Dynasty</strong>
                </div>
                <div class="col-sm-9">
                  {{ king.dynasty ? king.dynasty.name : 'Not specified' }}
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Birth Year</strong>
                </div>
                <div class="col-sm-9">
                  {{ king.birth_year || 'Not specified' }}
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Death Year</strong>
                </div>
                <div class="col-sm-9">
                  {{ king.death_year || 'Not specified' }}
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Reign Start Date</strong>
                </div>
                <div class="col-sm-9">
                  {{ formatDate(king.reign_start_date) }}
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Reign End Date</strong>
                </div>
                <div class="col-sm-9">
                  {{ formatDate(king.reign_end_date) }}
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Short Biography</strong>
                </div>
                <div class="col-sm-9">
                  {{ king.short_bio || 'Not provided' }}
                </div>
              </div>

              <div class="row">
                <div class="col-sm-3">
                  <strong>Full Biography</strong>
                </div>
                <div class="col-sm-9">
                  {{ king.full_bio || 'Not provided' }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Publishing Status</h5>
            </div>
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="p-2 rounded-circle bg-success bg-opacity-10 me-3">
                  <svg class="text-success" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <div>
                  <h6 class="mb-0">Published</h6>
                  <small class="text-muted">Visible to visitors</small>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Last Updated</label>
                <input type="text" class="form-control" :value="formatDate(king.updated_at)" readonly>
              </div>

              <div class="mb-0">
                <label class="form-label">Created By</label>
                <input type="text" class="form-control" value="Editor John" readonly>
              </div>
            </div>
          </div>

          <div class="card shadow-sm" v-if="king.media && king.media.length > 0">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Gallery Images</h5>
            </div>
            <div class="card-body">
              <div class="row g-2">
                <div
                  v-for="image in king.media"
                  :key="image.id"
                  class="col-6"
                >
                  <div class="rounded overflow-hidden">
                    <img
                      :src="'/storage/' + image.path"
                      class="img-fluid"
                      :alt="image.caption || 'Gallery image'"
                      style="aspect-ratio: 1/1; object-fit: cover;"
                    >
                  </div>
                </div>
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
    king: Object,
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
      if (!dateString) return 'Not specified';
      return new Date(dateString).toLocaleDateString();
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
        this.$inertia.delete(this.$route('admin.kings.destroy', this.king.id));
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

.object-fit-cover {
  object-fit: cover;
}
</style>
