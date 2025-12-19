<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>Oral History Archives</h1>
          <p class="text-muted">Manage recorded oral history archives including folktales, war stories, and personal experiences</p>
        </div>
        <div class="col-auto">
          <inertia-link :href="$route('admin.oral.history.archives.create')" class="btn btn-primary">
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
            <h5 class="mb-0">Oral History Collection</h5>
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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
            </svg>
            <h6 class="text-muted mb-2">No oral history archives found</h6>
            <p class="text-muted mb-0">Get started by adding your first oral history archive.</p>
          </div>

          <div v-else class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div v-for="archive in filteredArchives" :key="archive.id" class="col">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-primary">{{ archive.category }}</span>
                    <div>
                      <span v-if="archive.is_featured" class="badge bg-success me-1">Featured</span>
                      <span v-if="archive.audioFile || archive.audio_url" class="badge bg-success me-1">Audio</span>
                      <span v-if="archive.videoFile || archive.video_url" class="badge bg-info">Video</span>
                    </div>
                  </div>
                  <h5 class="card-title">{{ archive.title }}</h5>
                  <p class="card-text text-muted flex-grow-1">{{ archive.description }}</p>
                  <div v-if="archive.featuredMedia" class="mb-3">
                    <img
                      :src="'/storage/' + archive.featuredMedia.path"
                      :alt="archive.featuredMedia.filename"
                      class="img-fluid rounded"
                      style="max-height: 150px; object-fit: cover;"
                    >
                  </div>
                  <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                      </svg>
                      {{ archive.contributor }}
                    </small>
                    <div class="btn-group btn-group-sm" role="group">
                      <inertia-link
                        :href="$route('admin.oral.history.archives.edit', archive.id)"
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
  name: 'OralHistoryArchivesIndex',
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
        this.$inertia.delete(this.$route('admin.oral.history.archives.destroy', id));
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
        archive.category.toLowerCase().includes(searchTerm) ||
        archive.contributor.toLowerCase().includes(searchTerm)
      );
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
