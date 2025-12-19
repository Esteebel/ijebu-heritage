<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="mb-4">
        <inertia-link
          :href="$route('admin.diaspora.stories.index')"
          class="btn btn-link text-decoration-none"
        >
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Diaspora Stories
        </inertia-link>
        <h1 class="h3 mt-2 mb-0">
          {{ diasporaStory ? 'Edit Story' : 'Add New Story' }}
        </h1>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Diaspora Story Information</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="submit">
                <div class="row g-4">
                  <div class="col-12">
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

                  <div class="col-12">
                    <label for="story" class="form-label">Story *</label>
                    <textarea
                      id="story"
                      v-model="form.story"
                      rows="6"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.story }"
                      required
                    />
                    <div class="invalid-feedback" v-if="form.errors.story">
                      {{ form.errors.story }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="author" class="form-label">Author</label>
                    <input
                      id="author"
                      v-model="form.author"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.author }"
                      placeholder="Name of the author or contributor"
                    >
                    <div class="invalid-feedback" v-if="form.errors.author">
                      {{ form.errors.author }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="origin_location" class="form-label">Origin Location</label>
                    <input
                      id="origin_location"
                      v-model="form.origin_location"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.origin_location }"
                      placeholder="e.g., Ijebu-Ode, Ogun State"
                    >
                    <div class="invalid-feedback" v-if="form.errors.origin_location">
                      {{ form.errors.origin_location }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="settlement_location" class="form-label">Settlement Location</label>
                    <input
                      id="settlement_location"
                      v-model="form.settlement_location"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.settlement_location }"
                      placeholder="e.g., Brazil, Cuba, United States"
                    >
                    <div class="invalid-feedback" v-if="form.errors.settlement_location">
                      {{ form.errors.settlement_location }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="time_period" class="form-label">Time Period</label>
                    <input
                      id="time_period"
                      v-model="form.time_period"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.time_period }"
                      placeholder="e.g., 18th Century, 1900-1950"
                    >
                    <div class="invalid-feedback" v-if="form.errors.time_period">
                      {{ form.errors.time_period }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="family_connections" class="form-label">Family Connections</label>
                    <textarea
                      id="family_connections"
                      v-model="form.family_connections"
                      rows="3"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.family_connections }"
                      placeholder="Information about family ties and genealogy"
                    />
                    <div class="invalid-feedback" v-if="form.errors.family_connections">
                      {{ form.errors.family_connections }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="cultural_practices" class="form-label">Cultural Practices</label>
                    <textarea
                      id="cultural_practices"
                      v-model="form.cultural_practices"
                      rows="3"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.cultural_practices }"
                      placeholder="Maintained traditions and cultural adaptations"
                    />
                    <div class="invalid-feedback" v-if="form.errors.cultural_practices">
                      {{ form.errors.cultural_practices }}
                    </div>
                  </div>

                  <!-- Image Upload Section -->
                  <div class="col-12">
                    <label class="form-label">Story Image</label>
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
                    v-if="diasporaStory"
                    :href="$route('admin.diaspora.stories.show', diasporaStory.id)"
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
                    {{ diasporaStory ? 'Update Story' : 'Create Story' }}
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
                <input type="text" class="form-control" :value="diasporaStory ? formatDate(diasporaStory.updated_at) : 'Now'" readonly>
              </div>

              <div class="mb-0">
                <label class="form-label">Created By</label>
                <input type="text" class="form-control" :value="diasporaStory ? diasporaStory.created_by : currentUser()" readonly>
              </div>
            </div>
          </div>

          <!-- Image Information Card -->
          <div v-if="diasporaStory && diasporaStory.featuredImage" class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Current Image</h5>
            </div>
            <div class="card-body">
              <div class="text-center">
                <img :src="'/storage/' + diasporaStory.featuredImage.path" :alt="diasporaStory.featuredImage.filename" class="img-fluid rounded mb-3" style="max-height: 200px;">
                <div>
                  <strong>{{ diasporaStory.featuredImage.filename }}</strong>
                  <div class="text-muted">{{ diasporaStory.featuredImage.mime }} • {{ formatBytes(diasporaStory.featuredImage.size) }}</div>
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
    diasporaStory: {
      type: Object,
      default: null,
    },
    mediaItems: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        title: this.diasporaStory?.title || '',
        story: this.diasporaStory?.story || '',
        author: this.diasporaStory?.author || '',
        origin_location: this.diasporaStory?.origin_location || '',
        settlement_location: this.diasporaStory?.settlement_location || '',
        time_period: this.diasporaStory?.time_period || '',
        family_connections: this.diasporaStory?.family_connections || '',
        cultural_practices: this.diasporaStory?.cultural_practices || '',
        is_featured: this.diasporaStory?.is_featured || false,
        media_id: this.diasporaStory?.media_id || '',
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
      formData.append('title', this.form.title)
      formData.append('story', this.form.story)
      formData.append('author', this.form.author || '')
      formData.append('origin_location', this.form.origin_location || '')
      formData.append('settlement_location', this.form.settlement_location || '')
      formData.append('time_period', this.form.time_period || '')
      formData.append('family_connections', this.form.family_connections || '')
      formData.append('cultural_practices', this.form.cultural_practices || '')
      formData.append('is_featured', this.form.is_featured ? '1' : '0')

      // Handle image upload vs media selection
      if (this.form.image) {
        formData.append('image', this.form.image)
      } else if (this.form.media_id) {
        formData.append('media_id', this.form.media_id)
      }

      if (this.diasporaStory) {
        this.form.post(this.$route('admin.diaspora.stories.update', this.diasporaStory.id), {
          data: formData,
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
      } else {
        this.form.post(this.$route('admin.diaspora.stories.store'), {
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
