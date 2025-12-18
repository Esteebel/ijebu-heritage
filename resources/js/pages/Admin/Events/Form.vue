<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">{{ formMode }} Event</h1>
        <inertia-link
          :href="$route('admin.events.index')"
          class="btn btn-outline-secondary"
        >
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Events
        </inertia-link>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Event Details</h5>
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
                    :class="{ 'is-invalid': errors.title }"
                    required
                  >
                  <div v-if="errors.title" class="invalid-feedback">
                    {{ errors.title }}
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="start_datetime" class="form-label">Start Date & Time *</label>
                      <input
                        id="start_datetime"
                        v-model="form.start_datetime"
                        type="datetime-local"
                        class="form-control"
                        :class="{ 'is-invalid': errors.start_datetime }"
                        required
                      >
                      <div v-if="errors.start_datetime" class="invalid-feedback">
                        {{ errors.start_datetime }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="end_datetime" class="form-label">End Date & Time *</label>
                      <input
                        id="end_datetime"
                        v-model="form.end_datetime"
                        type="datetime-local"
                        class="form-control"
                        :class="{ 'is-invalid': errors.end_datetime }"
                        required
                      >
                      <div v-if="errors.end_datetime" class="invalid-feedback">
                        {{ errors.end_datetime }}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="location" class="form-label">Location</label>
                  <input
                    id="location"
                    v-model="form.location"
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': errors.location }"
                  >
                  <div v-if="errors.location" class="invalid-feedback">
                    {{ errors.location }}
                  </div>
                </div>

                <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea
                    id="description"
                    v-model="form.description"
                    rows="5"
                    class="form-control"
                    :class="{ 'is-invalid': errors.description }"
                  ></textarea>
                  <div v-if="errors.description" class="invalid-feedback">
                    {{ errors.description }}
                  </div>
                </div>

                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary" :disabled="processing">
                    <span v-if="processing" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    {{ formMode }} Event
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Media</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label for="featured_media_id" class="form-label">Featured Image</label>
                <select
                  id="featured_media_id"
                  v-model="form.featured_media_id"
                  class="form-select"
                  :class="{ 'is-invalid': errors.featured_media_id }"
                >
                  <option value="">Select featured image</option>
                  <option v-for="medium in media" :key="medium.id" :value="medium.id">
                    {{ medium.filename }}
                  </option>
                </select>
                <div v-if="errors.featured_media_id" class="invalid-feedback">
                  {{ errors.featured_media_id }}
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Or Upload New Image</label>
                <input
                  type="file"
                  class="form-control"
                  accept="image/*"
                  @change="handleImageUpload"
                >
                <div class="form-text">Upload a new featured image for this event</div>
              </div>

              <div v-if="form.featured_media_id" class="mt-3">
                <img
                  :src="getMediaUrl(form.featured_media_id)"
                  alt="Featured"
                  class="img-fluid rounded"
                >
              </div>
            </div>
          </div>

          <div class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Publish Options</h5>
            </div>
            <div class="card-body">
              <div class="form-check form-switch mb-3">
                <input
                  id="published"
                  v-model="form.published"
                  class="form-check-input"
                  type="checkbox"
                  role="switch"
                >
                <label class="form-check-label" for="published">Published</label>
              </div>

              <div class="alert alert-info" role="alert">
                <strong>Heads up!</strong> Published events will be visible to visitors on the website.
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
    event: {
      type: Object,
      default: null
    },
    media: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      form: {
        title: this.event?.title || '',
        description: this.event?.description || '',
        start_datetime: this.event?.start_datetime || '',
        end_datetime: this.event?.end_datetime || '',
        location: this.event?.location || '',
        featured_media_id: this.event?.featured_media_id || '',
        featured_image: null, // For direct uploads
        published: this.event?.published || false
      },
      errors: {},
      processing: false
    }
  },
  computed: {
    formMode() {
      return this.event ? 'Edit' : 'Create'
    }
  },
  methods: {
    submit() {
      this.processing = true
      this.errors = {}

      const url = this.event
        ? this.$route('admin.events.update', this.event.id)
        : this.$route('admin.events.store')

      const method = this.event ? 'put' : 'post'

      // Use FormData for file uploads
      const formData = new FormData();

      // Add all form fields
      Object.keys(this.form).forEach(key => {
        if (key !== 'featured_image') {
          formData.append(key, this.form[key]);
        }
      });

      // Add featured image if present
      if (this.form.featured_image) {
        formData.append('featured_image', this.form.featured_image);
      }

      // Add _method for PUT requests
      if (this.event) {
        formData.append('_method', 'PUT');
      }

      this.$inertia.post(url, formData, {
        onSuccess: () => {
          this.processing = false
        },
        onError: (errors) => {
          this.errors = errors
          this.processing = false
        }
      })
    },
    getMediaUrl(mediaId) {
      const mediaItem = this.media.find(m => m.id == mediaId)
      return mediaItem ? `/storage/${mediaItem.file_path}` : ''
    },
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.featured_image = file;
        // Clear the selected media ID since we're uploading a new image
        this.form.featured_media_id = '';
      }
    }
  }
}
</script>

<style scoped>
.form-label {
  font-weight: 500;
}

.alert-info {
  border-radius: 0.5rem;
}
</style>
