<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>Edit Oral History Archive</h1>
          <p class="text-muted">Update oral history archive details</p>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0">Oral History Archive Details</h5>
        </div>

        <div class="card-body">
          <form @submit.prevent="submit">
            <div class="mb-3">
              <label for="title" class="form-label">Title *</label>
              <input
                type="text"
                class="form-control"
                id="title"
                v-model="form.title"
                :class="{ 'is-invalid': errors.title }"
              >
              <div class="invalid-feedback" v-if="errors.title">{{ errors.title }}</div>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea
                class="form-control"
                id="description"
                rows="4"
                v-model="form.description"
                :class="{ 'is-invalid': errors.description }"
              ></textarea>
              <div class="invalid-feedback" v-if="errors.description">{{ errors.description }}</div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="category" class="form-label">Category *</label>
                  <select
                    class="form-select"
                    id="category"
                    v-model="form.category"
                    :class="{ 'is-invalid': errors.category }"
                  >
                    <option value="">Select a category</option>
                    <option value="Folktales">Folktales</option>
                    <option value="War Stories">War Stories</option>
                    <option value="Childhood Memories">Childhood Memories</option>
                    <option value="Myths">Myths</option>
                    <option value="Personal Experiences">Personal Experiences</option>
                    <option value="Recordings of Elders">Recordings of Elders</option>
                    <option value="Other">Other</option>
                  </select>
                  <div class="invalid-feedback" v-if="errors.category">{{ errors.category }}</div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="contributor" class="form-label">Contributor *</label>
                  <input
                    type="text"
                    class="form-control"
                    id="contributor"
                    v-model="form.contributor"
                    :class="{ 'is-invalid': errors.contributor }"
                  >
                  <div class="invalid-feedback" v-if="errors.contributor">{{ errors.contributor }}</div>
                </div>
              </div>
            </div>

            <!-- Audio Section -->
            <div class="mb-3">
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
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="link-audio-tab" data-bs-toggle="tab" data-bs-target="#link-audio" type="button" role="tab">
                    Audio Link
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
                      :class="{ 'is-invalid': errors.audio }"
                      accept="audio/*"
                      @change="handleAudioUpload"
                    >
                    <div class="form-text">Supported formats: MP3, WAV, AAC. Maximum file size: 20MB.</div>
                    <div class="invalid-feedback" v-if="errors.audio">
                      {{ errors.audio }}
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
                    <label for="audio_file_id" class="form-label">Select from Media Library</label>
                    <select
                      id="audio_file_id"
                      v-model="form.audio_file_id"
                      class="form-select"
                      :class="{ 'is-invalid': errors.audio_file_id }"
                    >
                      <option value="">Select Audio</option>
                      <option
                        v-for="media in audioMediaItems"
                        :key="media.id"
                        :value="media.id"
                      >
                        {{ media.filename }} ({{ media.mime }})
                      </option>
                    </select>
                    <div class="form-text">Choose from existing audio files in the library.</div>
                    <div class="invalid-feedback" v-if="errors.audio_file_id">
                      {{ errors.audio_file_id }}
                    </div>
                  </div>

                  <!-- Selected Audio Preview -->
                  <div v-if="form.audio_file_id && selectedAudioMedia" class="mt-3">
                    <label class="form-label">Selected Audio Preview</label>
                    <audio :src="'/storage/' + selectedAudioMedia.path" controls class="w-100"></audio>
                    <div class="mt-2">
                      <strong>{{ selectedAudioMedia.filename }}</strong>
                      <div class="text-muted">{{ selectedAudioMedia.mime }} • {{ formatBytes(selectedAudioMedia.size) }}</div>
                    </div>
                  </div>
                </div>

                <!-- Audio Link Tab -->
                <div class="tab-pane fade" id="link-audio" role="tabpanel">
                  <div class="mb-3">
                    <label for="audio_url" class="form-label">Audio URL</label>
                    <input
                      type="text"
                      class="form-control"
                      id="audio_url"
                      v-model="form.audio_url"
                      :class="{ 'is-invalid': errors.audio_url }"
                      placeholder="https://example.com/audio.mp3"
                    >
                    <div class="form-text">Enter a direct link to an audio file.</div>
                    <div class="invalid-feedback" v-if="errors.audio_url">{{ errors.audio_url }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Video Section -->
            <div class="mb-3">
              <label class="form-label">Video Recording</label>
              <ul class="nav nav-tabs" id="videoTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="upload-video-tab" data-bs-toggle="tab" data-bs-target="#upload-video" type="button" role="tab">
                    Upload New Video
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="select-video-tab" data-bs-toggle="tab" data-bs-target="#select-video" type="button" role="tab">
                    Select Existing Media
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="link-video-tab" data-bs-toggle="tab" data-bs-target="#link-video" type="button" role="tab">
                    Video Link
                  </button>
                </li>
              </ul>
              <div class="tab-content border border-top-0 p-3" id="videoTabContent">
                <!-- Upload New Video Tab -->
                <div class="tab-pane fade show active" id="upload-video" role="tabpanel">
                  <div class="mb-3">
                    <label for="video" class="form-label">Choose Video File</label>
                    <input
                      id="video"
                      ref="videoInput"
                      type="file"
                      class="form-control"
                      :class="{ 'is-invalid': errors.video }"
                      accept="video/*"
                      @change="handleVideoUpload"
                    >
                    <div class="form-text">Supported formats: MP4, MOV, AVI, WMV. Maximum file size: 100MB.</div>
                    <div class="invalid-feedback" v-if="errors.video">
                      {{ errors.video }}
                    </div>
                  </div>

                  <!-- Video Preview -->
                  <div v-if="form.videoPreview" class="mt-3">
                    <label class="form-label">Video Preview</label>
                    <video :src="form.videoPreview" controls class="w-100" style="max-height: 300px;"></video>
                  </div>
                </div>

                <!-- Select Existing Media Tab -->
                <div class="tab-pane fade" id="select-video" role="tabpanel">
                  <div class="mb-3">
                    <label for="video_file_id" class="form-label">Select from Media Library</label>
                    <select
                      id="video_file_id"
                      v-model="form.video_file_id"
                      class="form-select"
                      :class="{ 'is-invalid': errors.video_file_id }"
                    >
                      <option value="">Select Video</option>
                      <option
                        v-for="media in videoMediaItems"
                        :key="media.id"
                        :value="media.id"
                      >
                        {{ media.filename }} ({{ media.mime }})
                      </option>
                    </select>
                    <div class="form-text">Choose from existing video files in the library.</div>
                    <div class="invalid-feedback" v-if="errors.video_file_id">
                      {{ errors.video_file_id }}
                    </div>
                  </div>

                  <!-- Selected Video Preview -->
                  <div v-if="form.video_file_id && selectedVideoMedia" class="mt-3">
                    <label class="form-label">Selected Video Preview</label>
                    <video :src="'/storage/' + selectedVideoMedia.path" controls class="w-100" style="max-height: 300px;"></video>
                    <div class="mt-2">
                      <strong>{{ selectedVideoMedia.filename }}</strong>
                      <div class="text-muted">{{ selectedVideoMedia.mime }} • {{ formatBytes(selectedVideoMedia.size) }}</div>
                    </div>
                  </div>
                </div>

                <!-- Video Link Tab -->
                <div class="tab-pane fade" id="link-video" role="tabpanel">
                  <div class="mb-3">
                    <label for="video_url" class="form-label">Video URL</label>
                    <input
                      type="text"
                      class="form-control"
                      id="video_url"
                      v-model="form.video_url"
                      :class="{ 'is-invalid': errors.video_url }"
                      placeholder="https://example.com/video.mp4"
                    >
                    <div class="form-text">Enter a direct link to a video file.</div>
                    <div class="invalid-feedback" v-if="errors.video_url">{{ errors.video_url }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Featured Image Section -->
            <div class="mb-3">
              <label class="form-label">Featured Image</label>
              <ul class="nav nav-tabs" id="imageTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="upload-image-tab" data-bs-toggle="tab" data-bs-target="#upload-image" type="button" role="tab">
                    Upload New Image
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="select-image-tab" data-bs-toggle="tab" data-bs-target="#select-image" type="button" role="tab">
                    Select Existing Media
                  </button>
                </li>
              </ul>
              <div class="tab-content border border-top-0 p-3" id="imageTabContent">
                <!-- Upload New Image Tab -->
                <div class="tab-pane fade show active" id="upload-image" role="tabpanel">
                  <div class="mb-3">
                    <label for="featured_image" class="form-label">Choose Image File</label>
                    <input
                      id="featured_image"
                      ref="imageInput"
                      type="file"
                      class="form-control"
                      :class="{ 'is-invalid': errors.featured_image }"
                      accept="image/*"
                      @change="handleImageUpload"
                    >
                    <div class="form-text">Supported formats: JPG, PNG, GIF, WEBP. Maximum file size: 5MB.</div>
                    <div class="invalid-feedback" v-if="errors.featured_image">
                      {{ errors.featured_image }}
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
                <div class="tab-pane fade" id="select-image" role="tabpanel">
                  <div class="mb-3">
                    <label for="featured_media_id" class="form-label">Select from Media Library</label>
                    <select
                      id="featured_media_id"
                      v-model="form.featured_media_id"
                      class="form-select"
                      :class="{ 'is-invalid': errors.featured_media_id }"
                    >
                      <option value="">Select Media</option>
                      <option
                        v-for="media in imageMediaItems"
                        :key="media.id"
                        :value="media.id"
                      >
                        {{ media.filename }} ({{ media.mime }})
                      </option>
                    </select>
                    <div class="form-text">Choose from existing images in the library.</div>
                    <div class="invalid-feedback" v-if="errors.featured_media_id">
                      {{ errors.featured_media_id }}
                    </div>
                  </div>

                  <!-- Selected Media Preview -->
                  <div v-if="form.featured_media_id && selectedImageMedia" class="mt-3">
                    <label class="form-label">Selected Media Preview</label>
                    <div class="border rounded p-2">
                      <img :src="'/storage/' + selectedImageMedia.path" :alt="selectedImageMedia.filename" class="img-fluid rounded" style="max-height: 200px;">
                      <div class="mt-2">
                        <strong>{{ selectedImageMedia.filename }}</strong>
                        <div class="text-muted">{{ selectedImageMedia.mime }} • {{ formatBytes(selectedImageMedia.size) }}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Publish Toggle -->
            <div class="mb-3">
              <div class="form-check form-switch">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="is_featured"
                  v-model="form.is_featured"
                >
                <label class="form-check-label" for="is_featured">
                  Feature this archive
                </label>
              </div>
            </div>

            <div class="d-flex gap-2">
              <inertia-link :href="$route('admin.oral.history.archives.index')" class="btn btn-secondary">
                Cancel
              </inertia-link>
              <button type="submit" class="btn btn-primary" :disabled="processing">
                <span v-if="processing">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Updating...
                </span>
                <span v-else>Update Oral History Archive</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '../../../layouts/AdminLayout.vue'

export default {
  name: 'OralHistoryArchivesEdit',
  layout: AdminLayout,
  props: {
    archive: {
      type: Object,
      required: true
    },
    mediaItems: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      processing: false,
      form: {
        title: this.archive.title,
        description: this.archive.description,
        category: this.archive.category,
        contributor: this.archive.contributor,
        is_featured: this.archive.is_featured || false,
        audio_file_id: this.archive.audio_file_id || null,
        video_file_id: this.archive.video_file_id || null,
        featured_media_id: this.archive.featured_media_id || null,
        audio: null,
        video: null,
        audioPreview: null,
        videoPreview: null,
        audio_url: this.archive.audio_url || '',
        video_url: this.archive.video_url || ''
      },
      errors: {}
    }
  },
  computed: {
    audioMediaItems() {
      return this.mediaItems.filter(media => media.type === 'audio');
    },
    videoMediaItems() {
      return this.mediaItems.filter(media => media.type === 'video');
    },
    imageMediaItems() {
      return this.mediaItems.filter(media => media.type === 'image');
    },
    selectedAudioMedia() {
      if (!this.form.audio_file_id) return null;
      return this.audioMediaItems.find(media => media.id === this.form.audio_file_id);
    },
    selectedVideoMedia() {
      if (!this.form.video_file_id) return null;
      return this.videoMediaItems.find(media => media.id === this.form.video_file_id);
    },
    selectedImageMedia() {
      if (!this.form.featured_media_id) return null;
      return this.imageMediaItems.find(media => media.id === this.form.featured_media_id);
    }
  },
  methods: {
    handleAudioUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.audio = file;
        this.form.audio_file_id = null; // Clear selected media
        this.form.audio_url = ''; // Clear URL

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
          this.form.audioPreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    handleVideoUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.video = file;
        this.form.video_file_id = null; // Clear selected media
        this.form.video_url = ''; // Clear URL

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
          this.form.videoPreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.featured_image = file;
        this.form.featured_media_id = null; // Clear selected media

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
          this.form.imagePreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    formatBytes(bytes, decimals = 2) {
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const dm = decimals < 0 ? 0 : decimals;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    },
    async submit() {
      this.processing = true;
      this.errors = {};

      // Prepare form data
      const formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('title', this.form.title);
      formData.append('description', this.form.description);
      formData.append('category', this.form.category);
      formData.append('contributor', this.form.contributor);
      formData.append('is_featured', this.form.is_featured ? '1' : '0');

      // Audio handling
      if (this.form.audio) {
        formData.append('audio', this.form.audio);
      } else if (this.form.audio_file_id) {
        formData.append('audio_file_id', this.form.audio_file_id);
      } else if (this.form.audio_url) {
        formData.append('audio_url', this.form.audio_url);
      }

      // Video handling
      if (this.form.video) {
        formData.append('video', this.form.video);
      } else if (this.form.video_file_id) {
        formData.append('video_file_id', this.form.video_file_id);
      } else if (this.form.video_url) {
        formData.append('video_url', this.form.video_url);
      }

      // Featured image handling
      if (this.form.featured_image) {
        formData.append('featured_image', this.form.featured_image);
      } else if (this.form.featured_media_id) {
        formData.append('featured_media_id', this.form.featured_media_id);
      }

      try {
        await this.$inertia.post(this.$route('admin.oral.history.archives.update', this.archive.id), formData, {
          onSuccess: () => {
            this.processing = false;
          },
          onError: (errors) => {
            this.errors = errors;
            this.processing = false;
          }
        });
      } catch (error) {
        this.processing = false;
        console.error('Error updating oral history archive:', error);
      }
    }
  }
}
</script>
