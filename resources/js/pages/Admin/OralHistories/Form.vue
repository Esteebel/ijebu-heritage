<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="mb-4">
        <inertia-link
          :href="$route('admin.oral.histories.index')"
          class="btn btn-link text-decoration-none"
        >
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Oral Histories
        </inertia-link>
        <h1 class="h3 mt-2 mb-0">
          {{ oralHistory ? 'Edit Oral History' : 'Add New Oral History' }}
        </h1>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Oral History Information</h5>
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
                    <label for="description" class="form-label">Description</label>
                    <textarea
                      id="description"
                      v-model="form.description"
                      rows="3"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.description }"
                    />
                    <div class="invalid-feedback" v-if="form.errors.description">
                      {{ form.errors.description }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="narrator" class="form-label">Narrator</label>
                    <input
                      id="narrator"
                      v-model="form.narrator"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.narrator }"
                      placeholder="Name of the storyteller"
                    >
                    <div class="invalid-feedback" v-if="form.errors.narrator">
                      {{ form.errors.narrator }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="recorded_date" class="form-label">Date Recorded</label>
                    <input
                      id="recorded_date"
                      v-model="form.recorded_date"
                      type="date"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.recorded_date }"
                    >
                    <div class="invalid-feedback" v-if="form.errors.recorded_date">
                      {{ form.errors.recorded_date }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="location" class="form-label">Location</label>
                    <input
                      id="location"
                      v-model="form.location"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.location }"
                      placeholder="Where the story was recorded"
                    >
                    <div class="invalid-feedback" v-if="form.errors.location">
                      {{ form.errors.location }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="themes" class="form-label">Themes</label>
                    <input
                      id="themes"
                      v-model="form.themes"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.themes }"
                      placeholder="e.g., Migration, War, Creation"
                    >
                    <div class="invalid-feedback" v-if="form.errors.themes">
                      {{ form.errors.themes }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="cultural_context" class="form-label">Cultural Context</label>
                    <textarea
                      id="cultural_context"
                      v-model="form.cultural_context"
                      rows="3"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.cultural_context }"
                      placeholder="Cultural background and significance"
                    />
                    <div class="invalid-feedback" v-if="form.errors.cultural_context">
                      {{ form.errors.cultural_context }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="transcript" class="form-label">Transcript</label>
                    <textarea
                      id="transcript"
                      v-model="form.transcript"
                      rows="5"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.transcript }"
                      placeholder="Full transcript of the oral history"
                    />
                    <div class="invalid-feedback" v-if="form.errors.transcript">
                      {{ form.errors.transcript }}
                    </div>
                  </div>

                  <!-- Audio Upload Section -->
                  <div class="col-12">
                    <label class="form-label">Audio Recording</label>
                    <ul class="nav nav-tabs" id="audioTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="upload-audio-tab" data-bs-toggle="tab" data-bs-target="#upload-audio" type="button" role="tab">
                          Upload New Audio
                        </button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="select-audio-tab" data-bs-toggle="tab" data-bs-target="#select-audio" type="button" role="tab">
                          Select Existing Media
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content border border-top-0 p-3" id="audioTabContent">
                      <!-- Upload New Audio Tab -->
                      <div class="tab-pane fade show active" id="upload-audio" role="tabpanel">
                        <div class="mb-3">
                          <label for="audio" class="form-label">Choose Audio File</label>
                          <input
                            id="audio"
                            ref="audioInput"
                            type="file"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.audio || form.errors.media_id }"
                            accept="audio/*"
                            @change="handleAudioUpload"
                          >
                          <div class="form-text">Supported formats: MP3, WAV, AAC. Maximum file size: 20MB.</div>
                          <div class="invalid-feedback" v-if="form.errors.audio">
                            {{ form.errors.audio }}
                          </div>
                          <div class="invalid-feedback" v-if="form.errors.media_id">
                            {{ form.errors.media_id }}
                          </div>
                        </div>

                        <!-- Audio Preview -->
                        <div v-if="form.audioPreview" class="mt-3">
                          <label class="form-label">Audio Preview</label>
                          <audio :src="form.audioPreview" controls class="w-100"></audio>
                        </div>
                      </div>

                      <!-- Select Existing Media Tab -->
                      <div class="tab-pane fade" id="select-audio" role="tabpanel">
                        <div class="mb-3">
                          <label for="media_id" class="form-label">Select from Media Library</label>
                          <select
                            id="media_id"
                            v-model="form.media_id"
                            class="form-select"
                            :class="{ 'is-invalid': form.errors.media_id }"
                          >
                            <option value="">Select Audio</option>
                            <option
                              v-for="media in mediaItems"
                              :key="media.id"
                              :value="media.id"
                            >
                              {{ media.filename }} ({{ media.mime }})
                            </option>
                          </select>
                          <div class="form-text">Choose from existing audio files in the library.</div>
                          <div class="invalid-feedback" v-if="form.errors.media_id">
                            {{ form.errors.media_id }}
                          </div>
                        </div>

                        <!-- Selected Media Preview -->
                        <div v-if="form.media_id && selectedMedia" class="mt-3">
                          <label class="form-label">Selected Audio Preview</label>
                          <audio :src="'/storage/' + selectedMedia.path" controls class="w-100 mb-2"></audio>
                          <div>
                            <strong>{{ selectedMedia.filename }}</strong>
                            <div class="text-muted">{{ selectedMedia.mime }} • {{ formatBytes(selectedMedia.size) }}</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                  <inertia-link
                    v-if="oralHistory"
                    :href="$route('admin.oral.histories.show', oralHistory.id)"
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
                    {{ oralHistory ? 'Update History' : 'Create History' }}
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
                <input type="text" class="form-control" :value="oralHistory ? formatDate(oralHistory.updated_at) : 'Now'" readonly>
              </div>

              <div class="mb-0">
                <label class="form-label">Created By</label>
                <input type="text" class="form-control" :value="oralHistory ? oralHistory.created_by : currentUser()" readonly>
              </div>
            </div>
          </div>

          <!-- Audio Information Card -->
          <div v-if="oralHistory && oralHistory.audioFile" class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Current Audio</h5>
            </div>
            <div class="card-body">
              <audio :src="'/storage/' + oralHistory.audioFile.path" controls class="w-100 mb-2"></audio>
              <div>
                <strong>{{ oralHistory.audioFile.filename }}</strong>
                <div class="text-muted">{{ oralHistory.audioFile.mime }} • {{ formatBytes(oralHistory.audioFile.size) }}</div>
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
    oralHistory: {
      type: Object,
      default: null,
    },
    mediaItems: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        title: this.oralHistory?.title || '',
        description: this.oralHistory?.description || '',
        narrator: this.oralHistory?.narrator || '',
        recorded_date: this.oralHistory?.recorded_date || null,
        location: this.oralHistory?.location || '',
        transcript: this.oralHistory?.transcript || '',
        cultural_context: this.oralHistory?.cultural_context || '',
        themes: this.oralHistory?.themes || '',
        is_featured: this.oralHistory?.is_featured || false,
        media_id: this.oralHistory?.media_id || '',
        audio: null,
        audioPreview: null
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
    handleAudioUpload(event) {
      const file = event.target.files[0]
      if (file) {
        // Validate file type
        if (!file.type.startsWith('audio/')) {
          this.form.errors.audio = 'Please select a valid audio file (MP3, WAV, AAC).'
          return
        }

        // Validate file size (20MB max)
        if (file.size > 20 * 1024 * 1024) {
          this.form.errors.audio = 'File size must be less than 20MB.'
          return
        }

        this.form.audio = file
        this.form.media_id = '' // Clear media selection if uploading new audio

        // Create preview
        const reader = new FileReader()
        reader.onload = (e) => {
          this.form.audioPreview = e.target.result
        }
        reader.readAsDataURL(file)
      } else {
        this.form.audio = null
        this.form.audioPreview = null
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
      formData.append('description', this.form.description || '')
      formData.append('narrator', this.form.narrator || '')
      formData.append('recorded_date', this.form.recorded_date || '')
      formData.append('location', this.form.location || '')
      formData.append('transcript', this.form.transcript || '')
      formData.append('cultural_context', this.form.cultural_context || '')
      formData.append('themes', this.form.themes || '')
      formData.append('is_featured', this.form.is_featured ? '1' : '0')

      // Handle audio upload vs media selection
      if (this.form.audio) {
        formData.append('audio', this.form.audio)
      } else if (this.form.media_id) {
        formData.append('media_id', this.form.media_id)
      }

      if (this.oralHistory) {
        this.form.post(this.$route('admin.oral.histories.update', this.oralHistory.id), {
          data: formData,
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
      } else {
        this.form.post(this.$route('admin.oral.histories.store'), {
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
