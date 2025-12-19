<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>Photo Archives</h1>
          <p class="text-muted">Manage photo archives of old Ijebu photos from the 1940s-1990s</p>
        </div>
        <div class="col-auto">
          <inertia-link :href="$route('admin.photo.archives.create')" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Archive
          </inertia-link>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-white py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Photo Archive Collection</h5>
            <div class="d-flex gap-2">
              <input
                type="text"
                class="form-control form-control-sm"
                placeholder="Search archives..."
                v-model="search"
                @input="filterArchives"
              >
            </div>
          </div>
        </div>

        <div class="card-body">
          <div v-if="filteredArchives.length === 0" class="text-center py-5">
            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto text-muted mb-3">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h6 class="text-muted mb-2">No photo archives found</h6>
            <p class="text-muted mb-0">Get started by adding your first photo archive.</p>
          </div>

          <div v-else class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div v-for="archive in filteredArchives" :key="archive.id" class="col">
              <div class="card h-100 border-0 shadow-sm">
                <div class="position-relative">
                  <img
                    :src="archive.featured_image?.url || '/images/placeholder.jpg'"
                    class="card-img-top"
                    :alt="archive.title"
                    style="height: 200px; object-fit: cover;"
                  >
                  <div class="position-absolute top-0 end-0 m-2">
                    <span class="badge bg-primary">{{ archive.category }}</span>
                  </div>
                </div>
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">{{ archive.title }}</h5>
                  <p class="card-text text-muted flex-grow-1">{{ archive.description }}</p>
                  <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                      {{ formatDate(archive.date) }}
                    </small>
                    <div class="btn-group btn-group-sm" role="group">
                      <inertia-link
                        :href="$route('admin.photo.archives.edit', archive.id)"
                        class="btn btn-outline-primary"
                      >
                        Edit
                      </inertia-link>
                      <button
                        @click="destroy(archive.id)"
                        class="btn btn-outline-danger"
                      >
                        Delete
                      </button>
                    </div>
                  </div>
                </div>
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
  name: 'PhotoArchivesIndex',
  layout: AdminLayout,
  props: {
    archives: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      search: '',
      filteredArchives: this.archives
    }
  },
  methods: {
    async destroy(id) {
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
        this.$inertia.delete(this.$route('admin.photo.archives.destroy', id));
      }
    },
    filterArchives() {
      if (!this.search) {
        this.filteredArchives = this.archives;
        return;
      }

      const searchTerm = this.search.toLowerCase();
      this.filteredArchives = this.archives.filter(archive =>
        archive.title.toLowerCase().includes(searchTerm) ||
        archive.description.toLowerCase().includes(searchTerm) ||
        archive.category.toLowerCase().includes(searchTerm)
      );
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    }
  },
  watch: {
    archives: {
      handler(newArchives) {
        this.filteredArchives = newArchives;
      },
      immediate: true
    }
  }
}
</script>
