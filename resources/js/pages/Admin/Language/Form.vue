<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="mb-4">
        <inertia-link
          :href="$route('admin.language.items.index')"
          class="btn btn-link text-decoration-none"
        >
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Language Items
        </inertia-link>
        <h1 class="h3 mt-2 mb-0">
          {{ languageItem ? 'Edit Language Item' : 'Add New Language Item' }}
        </h1>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Language Item Information</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="submit">
                <div class="row g-4">
                  <div class="col-12">
                    <label for="word" class="form-label">Word/Phrase *</label>
                    <input
                      id="word"
                      v-model="form.word"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.word }"
                      required
                    >
                    <div class="invalid-feedback" v-if="form.errors.word">
                      {{ form.errors.word }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="meaning" class="form-label">Meaning</label>
                    <textarea
                      id="meaning"
                      v-model="form.meaning"
                      rows="2"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.meaning }"
                    />
                    <div class="invalid-feedback" v-if="form.errors.meaning">
                      {{ form.errors.meaning }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="pronunciation" class="form-label">Pronunciation</label>
                    <input
                      id="pronunciation"
                      v-model="form.pronunciation"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.pronunciation }"
                      placeholder="e.g., /a-bi-ku/"
                    >
                    <div class="invalid-feedback" v-if="form.errors.pronunciation">
                      {{ form.errors.pronunciation }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="part_of_speech" class="form-label">Part of Speech</label>
                    <input
                      id="part_of_speech"
                      v-model="form.part_of_speech"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.part_of_speech }"
                      placeholder="e.g., Noun, Verb, Adjective"
                    >
                    <div class="invalid-feedback" v-if="form.errors.part_of_speech">
                      {{ form.errors.part_of_speech }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="dialect" class="form-label">Dialect</label>
                    <input
                      id="dialect"
                      v-model="form.dialect"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.dialect }"
                      placeholder="e.g., Ijebu, Standard Yoruba"
                    >
                    <div class="invalid-feedback" v-if="form.errors.dialect">
                      {{ form.errors.dialect }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="example_sentence" class="form-label">Example Sentence</label>
                    <textarea
                      id="example_sentence"
                      v-model="form.example_sentence"
                      rows="2"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.example_sentence }"
                    />
                    <div class="invalid-feedback" v-if="form.errors.example_sentence">
                      {{ form.errors.example_sentence }}
                    </div>
                  </div>

                  <!-- Audio Upload Section -->
                  <div class="col-12">
                    <label class="form-label">Pronunciation Audio</label>
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
                          <div class="form-text">Supported formats: MP3, WAV, AAC. Maximum file size: 10MB.</div>
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
                    v-if="languageItem"
                    :href="$route('admin.language.items.show', languageItem.id)"
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
                    {{ languageItem ? 'Update Item' : 'Create Item' }}
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
                <input type="text" class="form-control" :value="languageItem ? formatDate(languageItem.updated_at) : 'Now'" readonly>
              </div>

              <div class="mb-0">
                <label class="form-label">Created By</label>
                <input type="text" class="form-control" :value="languageItem ? languageItem.created_by : currentUser()" readonly>
              </div>
            </div>
          </div>

          <!-- Audio Information Card -->
          <div v-if="languageItem && languageItem.audioFile" class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Current Audio</h5>
            </div>
            <div class="card-body">
              <audio :src="'/storage/' + languageItem.audioFile.path" controls class="w-100 mb-2"></audio>
              <div>
                <strong>{{ languageItem.audioFile.filename }}</strong>
                <div class="text-muted">{{ languageItem.audioFile.mime }} • {{ formatBytes(languageItem.audioFile.size) }}</div>
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
    languageItem: {
      type: Object,
      default: null,
    },
    mediaItems: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        word: this.languageItem?.word || '',
        meaning: this.languageItem?.meaning || '',
        part_of_speech: this.languageItem?.part_of_speech || '',
        example_sentence: this.languageItem?.example_sentence || '',
        pronunciation: this.languageItem?.pronunciation || '',
        dialect: this.languageItem?.dialect || '',
        is_featured: this.languageItem?.is_featured || false,
        media_id: this.languageItem?.media_id || '',
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

        // Validate file size (10MB max)
        if (file.size > 10 * 1024 * 1024) {
          this.form.errors.audio = 'File size must be less than 10MB.'
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
      formData.append('word', this.form.word)
      formData.append('meaning', this.form.meaning || '')
      formData.append('part_of_speech', this.form.part_of_speech || '')
      formData.append('example_sentence', this.form.example_sentence || '')
      formData.append('pronunciation', this.form.pronunciation || '')
      formData.append('dialect', this.form.dialect || '')
      formData.append('is_featured', this.form.is_featured ? '1' : '0')

      // Handle audio upload vs media selection
      if (this.form.audio) {
        formData.append('audio', this.form.audio)
      } else if (this.form.media_id) {
        formData.append('media_id', this.form.media_id)
      }

      if (this.languageItem) {
        this.form.post(this.$route('admin.language.items.update', this.languageItem.id), {
          data: formData,
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
      } else {
        this.form.post(this.$route('admin.language.items.store'), {
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
