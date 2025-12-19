<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>{{ archive.title }}</h1>
          <p class="text-muted">View photo archive details</p>
        </div>
        <div class="col-auto">
          <div class="btn-group" role="group">
            <inertia-link :href="$route('admin.photo.archives.edit', archive.id)" class="btn btn-primary">
              Edit
            </inertia-link>
            <button @click="destroy" class="btn btn-danger">
              Delete
            </button>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0">Archive Details</h5>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <p><strong>Date:</strong> {{ formatDate(archive.date) }}</p>
                </div>
                <div class="col-md-6">
                  <p><strong>Category:</strong> <span class="badge bg-primary">{{ archive.category }}</span></p>
                </div>
              </div>

              <div class="mb-3">
                <p><strong>Description:</strong></p>
                <p>{{ archive.description || 'No description provided' }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0">Featured Image</h5>
            </div>

            <div class="card-body">
              <img
                :src="archive.featured_image?.url || '/images/placeholder.jpg'"
                class="img-fluid rounded"
                :alt="archive.title"
              >
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
  name: 'PhotoArchivesShow',
  layout: AdminLayout,
  props: {
    archive: {
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
        this.$inertia.delete(this.$route('admin.photo.archives.destroy', this.archive.id));
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    }
  }
}
</script>
