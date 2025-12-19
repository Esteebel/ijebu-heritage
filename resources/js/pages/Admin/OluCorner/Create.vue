<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>Add Olu's Corner Entry</h1>
          <p class="text-muted">Share your roots, journey, and vision for Ijebu future</p>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0">Entry Details</h5>
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
              <label for="content" class="form-label">Content *</label>
              <textarea
                class="form-control"
                id="content"
                rows="10"
                v-model="form.content"
                :class="{ 'is-invalid': errors.content }"
              ></textarea>
              <div class="invalid-feedback" v-if="errors.content">{{ errors.content }}</div>
            </div>

            <!-- Featured Image Section -->
            <div class="mb-3">
              <label class="form-label">Featured Image</label>
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
                      :class="{ 'is-invalid': errors.image }"
                      accept="image/*"
                      @change="handleImageUpload"
                    >
                    <div class="form-text">Supported formats: JPG, PNG, GIF, WEBP. Maximum file size: 5MB.</div>
                    <div class="invalid-feedback" v-if="errors.image">
                      {{ errors.image }}
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
                    <label for="featured_media_id" class="form-label">Select from Media Library</label>
                    <select
                      id="featured_media_id"
                      v-model="form.featured_media_id"
                      class="form-select"
                      :class="{ 'is-invalid': errors.featured_media_id }"
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
                    <div class="invalid-feedback" v-if="errors.featured_media_id">
                      {{ errors.featured_media_id }}
                    </div>
                  </div>

                  <!-- Selected Media Preview -->
                  <div v-if="form.featured_media_id && selectedMedia" class="mt-3">
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

            <!-- Publish Toggle -->
            <div class="mb-3">
              <div class="form-check form-switch">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="is_published"
                  v-model="form.is_published"
                >
                <label class="form-check-label" for="is_published">
                  Publish Entry
                </label>
              </div>
            </div>

            <div class="d-flex gap-2">
              <inertia-link :href="$route('admin.olu.corner.index')" class="btn btn-secondary">
                Cancel
              </inertia-link>
              <button type="submit" class="btn btn-primary" :disabled="processing">
                <span v-if="processing">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Saving...
                </span>
                <span v-else>Save Entry</span>
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
  name: 'OluCornerCreate',
  layout: AdminLayout,
  props: {
    mediaItems: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      processing: false,
      form: {
        title: '',
        content: '',
        is_published: false,
        featured_media_id: null,
        image: null,
        imagePreview: null
      },
      errors: {}
    }
  },
  computed: {
    selectedMedia() {
      if (!this.form.featured_media_id) return null;
      return this.mediaItems.find(media => media.id === this.form.featured_media_id);
    }
  },
  methods: {
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.image = file;
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
      formData.append('title', this.form.title);
      formData.append('content', this.form.content);
      formData.append('is_published', this.form.is_published ? '1' : '0');

      if (this.form.image) {
        formData.append('image', this.form.image);
      } else if (this.form.featured_media_id) {
        formData.append('featured_media_id', this.form.featured_media_id);
      }

      try {
        await this.$inertia.post(this.$route('admin.olu.corner.store'), formData, {
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
        console.error('Error saving entry:', error);
      }
    }
  }
}
</script>
