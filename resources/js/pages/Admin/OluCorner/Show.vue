<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>{{ entry.title }}</h1>
          <p class="text-muted">View Olu's Corner entry</p>
        </div>
        <div class="col-auto">
          <div class="btn-group" role="group">
            <inertia-link :href="$route('admin.olu.corner.edit', entry.id)" class="btn btn-primary">
              Edit
            </inertia-link>
            <button @click="destroy" class="btn btn-danger">
              Delete
            </button>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-white py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Entry Content</h5>
            <span :class="entry.is_published ? 'badge bg-success' : 'badge bg-secondary'">
              {{ entry.is_published ? 'Published' : 'Draft' }}
            </span>
          </div>
        </div>

        <div class="card-body">
          <div v-if="entry.featuredMedia" class="mb-4">
            <img
              :src="'/storage/' + entry.featuredMedia.path"
              :alt="entry.featuredMedia.filename"
              class="img-fluid rounded"
              style="max-height: 300px;"
            >
            <div class="mt-2 text-muted">
              <small>{{ entry.featuredMedia.filename }}</small>
            </div>
          </div>
          <div v-html="entry.content"></div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '../../../layouts/AdminLayout.vue'

export default {
  name: 'OluCornerShow',
  layout: AdminLayout,
  props: {
    entry: {
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
        this.$inertia.delete(this.$route('admin.olu.corner.destroy', this.entry.id));
      }
    }
  }
}
</script>
