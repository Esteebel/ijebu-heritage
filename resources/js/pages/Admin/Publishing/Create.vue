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
          <h1 class="h3 mt-2 mb-0">Add New Queue Item</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Queue Item Details</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="submit">
                <div class="mb-3">
                  <label for="title" class="form-label">Title *</label>
                  <input
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.title }"
                    required
                  >
                  <div class="invalid-feedback" v-if="form.errors.title">
                    {{ form.errors.title }}
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="type" class="form-label">Type *</label>
                      <select
                        id="type"
                        v-model="form.type"
                        class="form-select"
                        :class="{ 'is-invalid': form.errors.type }"
                        required
                      >
                        <option value="">Select Type</option>
                        <option value="king">King</option>
                        <option value="event">Event</option>
                        <option value="artifact">Artifact</option>
                        <option value="tour">Tour</option>
                        <option value="ticket">Ticket</option>
                      </select>
                      <div class="invalid-feedback" v-if="form.errors.type">
                        {{ form.errors.type }}
                  </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="status" class="form-label">Status *</label>
                      <select
                        id="status"
                        v-model="form.status"
                        class="form-select"
                        :class="{ 'is-invalid': form.errors.status }"
                        required
                      >
                        <option value="">Select Status</option>
                        <option value="draft">Draft</option>
                        <option value="ready">Ready for Review</option>
                        <option value="published">Published</option>
                      </select>
                      <div class="invalid-feedback" v-if="form.errors.status">
                        {{ form.errors.status }}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea
                    id="description"
                    v-model="form.description"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.description }"
                    rows="4"
                  ></textarea>
                  <div class="invalid-feedback" v-if="form.errors.description">
                    {{ form.errors.description }}
                  </div>
                </div>

                <div class="mb-3">
                  <label for="scheduled_at" class="form-label">Scheduled Publication Date</label>
                  <input
                    id="scheduled_at"
                    v-model="form.scheduled_at"
                    type="date"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.scheduled_at }"
                  >
                  <div class="invalid-feedback" v-if="form.errors.scheduled_at">
                    {{ form.errors.scheduled_at }}
                  </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                  <inertia-link
                    :href="$route('admin.publishing.queue.index')"
                    class="btn btn-outline-secondary me-2"
                  >
                    Cancel
                  </inertia-link>
                  <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing"
                  >
                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Create Item
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Information</h5>
            </div>
            <div class="card-body">
              <p class="mb-0">
                Add items to the publishing queue to manage content workflow.
                Set the appropriate status and schedule publication dates as needed.
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
  data() {
    return {
      form: this.$inertia.form({
        title: '',
        type: '',
        description: '',
        status: 'draft',
        scheduled_at: ''
      })
    }
  },
  methods: {
    submit() {
      this.form.post(this.$route('admin.publishing.queue.store'))
    }
  }
}
</script>
