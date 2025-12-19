<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>Olu's Corner</h1>
          <p class="text-muted">Manage content for Olu's Corner - your roots, journey, and vision for Ijebu future</p>
        </div>
        <div class="col-auto">
          <inertia-link :href="$route('admin.olu.corner.create')" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Entry
          </inertia-link>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-white py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Olu's Corner Entries</h5>
            <div class="d-flex gap-2">
              <input
                type="text"
                class="form-control form-control-sm"
                placeholder="Search entries..."
                v-model="search"
                @input="filterEntries"
              >
            </div>
          </div>
        </div>

        <div class="card-body">
          <div v-if="filteredEntries.length === 0" class="text-center py-5">
            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto text-muted mb-3">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <h6 class="text-muted mb-2">No entries found</h6>
            <p class="text-muted mb-0">Get started by adding your first entry to Olu's Corner.</p>
          </div>

          <div v-else class="row row-cols-1 row-cols-md-2 g-4">
            <div v-for="entry in filteredEntries" :key="entry.id" class="col">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0">{{ entry.title }}</h5>
                    <span :class="entry.is_published ? 'badge bg-success' : 'badge bg-secondary'">
                      {{ entry.is_published ? 'Published' : 'Draft' }}
                    </span>
                  </div>
                  <div v-if="entry.featuredMedia" class="mb-3">
                    <img
                      :src="'/storage/' + entry.featuredMedia.path"
                      :alt="entry.featuredMedia.filename"
                      class="img-fluid rounded"
                      style="max-height: 150px; object-fit: cover;"
                    >
                  </div>
                  <div class="card-text text-muted mb-3" v-html="excerpt(entry.content, 150)"></div>
                  <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                      {{ formatDate(entry.created_at) }}
                    </small>
                    <div class="btn-group btn-group-sm" role="group">
                      <inertia-link
                        :href="$route('admin.olu.corner.edit', entry.id)"
                        class="btn btn-outline-primary"
                      >
                        Edit
                      </inertia-link>
                      <button
                        @click="destroy(entry.id)"
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
  name: 'OluCornerIndex',
  layout: AdminLayout,
  props: {
    entries: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      search: '',
      filteredEntries: this.entries
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
        this.$inertia.delete(this.$route('admin.olu.corner.destroy', id));
      }
    },
    filterEntries() {
      if (!this.search) {
        this.filteredEntries = this.entries;
        return;
      }

      const searchTerm = this.search.toLowerCase();
      this.filteredEntries = this.entries.filter(entry =>
        entry.title.toLowerCase().includes(searchTerm) ||
        entry.content.toLowerCase().includes(searchTerm)
      );
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    excerpt(content, length) {
      if (!content) return '';
      const stripped = content.replace(/<[^>]*>/g, '');
      return stripped.length > length ? stripped.substring(0, length) + '...' : stripped;
    }
  },
  watch: {
    entries: {
      handler(newEntries) {
        this.filteredEntries = newEntries;
      },
      immediate: true
    }
  }
}
</script>
