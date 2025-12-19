<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="mb-4">
        <inertia-link
          :href="$route('admin.festivals.index')"
          class="btn btn-link text-decoration-none"
        >
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Festivals
        </inertia-link>
        <h1 class="h3 mt-2 mb-0">
          {{ festival ? 'Edit Festival' : 'Add New Festival' }}
        </h1>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Festival Information</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="submit">
                <div class="row g-4">
                  <div class="col-12">
                    <label for="name" class="form-label">Festival Name *</label>
                    <input
                      id="name"
                      v-model="form.name"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.name }"
                      required
                    >
                    <div class="invalid-feedback" v-if="form.errors.name">
                      {{ form.errors.name }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                      id="description"
                      v-model="form.description"
                      rows="4"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.description }"
                    />
                    <div class="invalid-feedback" v-if="form.errors.description">
                      {{ form.errors.description }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="origin_story" class="form-label">Origin Story</label>
                    <textarea
                      id="origin_story"
                      v-model="form.origin_story"
                      rows="3"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.origin_story }"
                    />
                    <div class="invalid-feedback" v-if="form.errors.origin_story">
                      {{ form.errors.origin_story }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="dates" class="form-label">Dates</label>
                    <input
                      id="dates"
                      v-model="form.dates"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.dates }"
                      placeholder="e.g., Annual, June 15th, etc."
                    >
                    <div class="invalid-feedback" v-if="form.errors.dates">
                      {{ form.errors.dates }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="regberegbe_groups" class="form-label">Regberegbe Groups</label>
                    <textarea
                      id="regberegbe_groups"
                      v-model="form.regberegbe_groups"
                      rows="2"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.regberegbe_groups }"
                      placeholder="List the traditional groups involved in the festival"
                    />
                    <div class="invalid-feedback" v-if="form.errors.regberegbe_groups">
                      {{ form.errors.regberegbe_groups }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="horsemen_info" class="form-label">Horsemen Information</label>
                    <textarea
                      id="horsemen_info"
                      v-model="form.horsemen_info"
                      rows="2"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.horsemen_info }"
                      placeholder="Details about the traditional horsemen participation"
                    />
                    <div class="invalid-feedback" v-if="form.errors.horsemen_info">
                      {{ form.errors.horsemen_info }}
                    </div>
                  </div>

                  <!-- Image Upload Section -->
                  <div class="col-12">
                    <label class="form-label">Festival Image</label>
                    <ul class="nav nav-tabs" id="imageTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">
                          Upload New Image
                        </button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="select-tab" data-bs-toggle="tab" data-bs-target="#select" type="button" role="tab">
                          Select Existing Media
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content border border-top-0 p-3" id="imageTabContent">
                      <!-- Upload New Image Tab -->
                      <div class="tab-pane fade show active" id="upload" role="tabpanel">
                        <div class="mb-3">
                          <label for="image" class="form-label">Choose Image File</label>
                          <input
                            id="image"
                            ref="imageInput"
                            type="file"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.image || form.errors.media_id }"
                            accept="image/*"
                            @change="handleImageUpload"
                          >
                          <div class="form-text">Supported formats: JPG, PNG, GIF. Maximum file size: 5MB.</div>
                          <div class="invalid-feedback" v-if="form.errors.image">
                            {{ form.errors.image }}
                          </div>
                          <div class="invalid-feedback" v-if="form.errors.media_id">
                            {{ form.errors.media_id }}
                          </div>
                        </div>

                        <!-- Image Preview -->
                        <div v-if="form.imagePreview" class="mt-3">
                          <label class="form-label">Image Preview</label>
                          <div class="border rounded p-2">
                            <img :src="form.imagePreview" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                          </div>
                        </div>
                      </div>

                      <!-- Select Existing Media Tab -->
                      <div class="tab-pane fade" id="select" role="tabpanel">
                        <div class="mb-3">
                          <label for="media_id" class="form-label">Select from Media Library</label>
                          <select
                            id="media_id"
                            v-model="form.media_id"
                            class="form-select"
                            :class="{ 'is-invalid': form.errors.media_id }"
                          >
                            <option value="">Select Media</option>
                            <option
                              v-for="media in mediaItems"
                              :key="media.id"
                              :value="media.id"
                            >
                              {{ media.filename }} ({{ media.mime }})
                            </option>
                          </select>
                          <div class="form-text">Choose from existing media in the library.</div>
                          <div class="invalid-feedback" v-if="form.errors.media_id">
                            {{ form.errors.media_id }}
                          </div>
                        </div>

                        <!-- Selected Media Preview -->
                        <div v-if="form.media_id && selectedMedia" class="mt-3">
                          <label class="form-label">Selected Media Preview</label>
                          <div class="border rounded p-2">
                            <img :src="'/storage/' + selectedMedia.path" :alt="selectedMedia.filename" class="img-fluid rounded" style="max-height: 200px;">
                            <div class="mt-2">
                              <strong>{{ selectedMedia.filename }}</strong>
                              <div class="text-muted">{{ selectedMedia.mime }} • {{ formatBytes(selectedMedia.size) }}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                  <inertia-link
                    v-if="festival"
                    :href="$route('admin.festivals.show', festival.id)"
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
                    {{ festival ? 'Update Festival' : 'Create Festival' }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Publishing</h5>
            </div>
            <div class="card-body">
              <div class="form-check form-switch mb-3">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="is_featured"
                  v-model="form.is_featured"
                >
                <label class="form-check-label" for="is_featured">Feature on Homepage</label>
              </div>

              <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-select">
                  <option>Draft</option>
                  <option selected>Ready for Review</option>
                  <option>Published</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Last Updated</label>
                <input type="text" class="form-control" :value="festival ? formatDate(festival.updated_at) : 'Now'" readonly>
              </div>

              <div class="mb-0">
                <label class="form-label">Created By</label>
                <input type="text" class="form-control" :value="festival ? festival.created_by : currentUser()" readonly>
              </div>
            </div>
          </div>

          <!-- Image Information Card -->
          <div v-if="festival && festival.featuredImage" class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Current Image</h5>
            </div>
            <div class="card-body">
              <div class="text-center">
                <img :src="'/storage/' + festival.featuredImage.path" :alt="festival.featuredImage.filename" class="img-fluid rounded mb-3" style="max-height: 200px;">
                <div>
                  <strong>{{ festival.featuredImage.filename }}</strong>
                  <div class="text-muted">{{ festival.featuredImage.mime }} • {{ formatBytes(festival.featuredImage.size) }}</div>
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
    festival: {
      type: Object,
      default: null,
    },
    mediaItems: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.festival?.name || '',
        description: this.festival?.description || '',
        origin_story: this.festival?.origin_story || '',
        regberegbe_groups: this.festival?.regberegbe_groups || '',
        horsemen_info: this.festival?.horsemen_info || '',
        dates: this.festival?.dates || '',
        is_featured: this.festival?.is_featured || false,
        media_id: this.festival?.media_id || '',
        image: null,
        imagePreview: null
      })
    }
  },
  computed: {
    selectedMedia() {
      if (!this.form.media_id) return null
      return this.mediaItems.find(media => media.id == this.form.media_id)
    }
  },
  methods: {
    handleImageUpload(event) {
      const file = event.target.files[0]
      if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
          this.form.errors.image = 'Please select a valid image file (JPG, PNG, GIF).'
          return
        }

        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
          this.form.errors.image = 'File size must be less than 5MB.'
          return
        }

        this.form.image = file
        this.form.media_id = '' // Clear media selection if uploading new image

        // Create preview
        const reader = new FileReader()
        reader.onload = (e) => {
          this.form.imagePreview = e.target.result
        }
        reader.readAsDataURL(file)
      } else {
        this.form.image = null
        this.form.imagePreview = null
      }
    },
    formatBytes(bytes, decimals = 2) {
      if (bytes === 0) return '0 Bytes'
      const k = 1024
      const dm = decimals < 0 ? 0 : decimals
      const sizes = ['Bytes', 'KB', 'MB', 'GB']
      const i = Math.floor(Math.log(bytes) / Math.log(k))
      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i]
    },
    formatDate(dateString) {
      if (!dateString) return 'N/A'
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    },
    currentUser() {
      // In a real app, this would come from the authenticated user
      return 'Admin User'
    },
    submit() {
      // Clear previous errors
      this.form.errors = {}

      // Prepare form data
      const formData = new FormData()
      formData.append('name', this.form.name)
      formData.append('description', this.form.description || '')
      formData.append('origin_story', this.form.origin_story || '')
      formData.append('regberegbe_groups', this.form.regberegbe_groups || '')
      formData.append('horsemen_info', this.form.horsemen_info || '')
      formData.append('dates', this.form.dates || '')
      formData.append('is_featured', this.form.is_featured ? '1' : '0')

      // Handle image upload vs media selection
      if (this.form.image) {
        formData.append('image', this.form.image)
      } else if (this.form.media_id) {
        formData.append('media_id', this.form.media_id)
      }

      if (this.festival) {
        this.form.post(this.$route('admin.festivals.update', this.festival.id), {
          data: formData,
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
      } else {
        this.form.post(this.$route('admin.festivals.store'), {
          data: formData,
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
      }
    }
  }
}
</script>
