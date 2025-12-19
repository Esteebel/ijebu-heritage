<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>Add New Virtual Tour</h1>
          <p class="text-muted">Create a new virtual tour experience</p>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0">Tour Details</h5>
        </div>

        <div class="card-body">
          <form @submit.prevent="submit">
            <div class="row">
              <div class="col-md-8">
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
                      <label for="duration" class="form-label">Duration *</label>
                      <input
                        type="text"
                        class="form-control"
                        id="duration"
                        v-model="form.duration"
                        :class="{ 'is-invalid': errors.duration }"
                        placeholder="e.g., 2 hours, Half day"
                      >
                      <div class="invalid-feedback" v-if="errors.duration">{{ errors.duration }}</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="difficulty" class="form-label">Difficulty *</label>
                      <select
                        class="form-select"
                        id="difficulty"
                        v-model="form.difficulty"
                        :class="{ 'is-invalid': errors.difficulty }"
                      >
                        <option value="easy">Easy</option>
                        <option value="moderate">Moderate</option>
                        <option value="difficult">Difficult</option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.difficulty">{{ errors.difficulty }}</div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="max_participants" class="form-label">Maximum Participants *</label>
                      <input
                        type="number"
                        class="form-control"
                        id="max_participants"
                        v-model="form.max_participants"
                        :class="{ 'is-invalid': errors.max_participants }"
                        min="1"
                      >
                      <div class="invalid-feedback" v-if="errors.max_participants">{{ errors.max_participants }}</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="price" class="form-label">Price (₦) *</label>
                      <input
                        type="number"
                        class="form-control"
                        id="price"
                        v-model="form.price"
                        :class="{ 'is-invalid': errors.price }"
                        step="0.01"
                        min="0"
                      >
                      <div class="invalid-feedback" v-if="errors.price">{{ errors.price }}</div>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="is_published"
                      v-model="form.is_published"
                    >
                    <label class="form-check-label" for="is_published">
                      Published
                    </label>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
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
                        <div class="form-text">Supported formats: JPG, PNG, GIF. Maximum file size: 5MB.</div>
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
                        <label for="featured_image_id" class="form-label">Select from Media Library</label>
                        <select
                          id="featured_image_id"
                          v-model="form.featured_image_id"
                          class="form-select"
                          :class="{ 'is-invalid': errors.featured_image_id }"
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
                        <div class="invalid-feedback" v-if="errors.featured_image_id">
                          {{ errors.featured_image_id }}
                        </div>
                      </div>

                      <!-- Selected Media Preview -->
                      <div v-if="form.featured_image_id && selectedMedia" class="mt-3">
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
            </div>

            <div class="d-flex gap-2">
              <inertia-link :href="$route('admin.tours.index')" class="btn btn-secondary">
                Cancel
              </inertia-link>
              <button type="submit" class="btn btn-primary" :disabled="processing">
                <span v-if="processing">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Saving...
                </span>
                <span v-else>Save Tour</span>
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
  name: 'ToursCreate',
  layout: AdminLayout,
  inject: ['$http'],
  data() {
    return {
      processing: false,
      form: {
        title: '',
        description: '',
        duration: '',
        difficulty: 'moderate',
        max_participants: '',
        price: '',
        featured_image_id: null,
        is_published: false,
        image: null,
        imagePreview: null
      },
      errors: {},
      mediaItems: []
    }
  },
  methods: {
    async loadMedia() {
      try {
        const response = await axios.get(this.$route('admin.media.index'));
        this.mediaItems = response.data;
      } catch (error) {
        console.error('Error loading media:', error);
      }
    },
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.image = file;
        this.form.featured_image_id = null; // Clear selected media

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
      formData.append('description', this.form.description);
      formData.append('duration', this.form.duration);
      formData.append('difficulty', this.form.difficulty);
      formData.append('max_participants', this.form.max_participants);
      formData.append('price', this.form.price);
      formData.append('is_published', this.form.is_published ? '1' : '0');

      if (this.form.image) {
        formData.append('image', this.form.image);
      } else if (this.form.featured_image_id) {
        formData.append('featured_image_id', this.form.featured_image_id);
      }

      try {
        await this.$inertia.post(this.$route('admin.tours.store'), formData, {
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
        console.error('Error saving tour:', error);
      }
    }
  },
  mounted() {
    this.loadMedia();
  }
}
</script>
