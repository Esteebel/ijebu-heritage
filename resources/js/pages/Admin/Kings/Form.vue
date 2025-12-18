<template>
  <admin-layout>
    <loading-spinner :loading="showLoading"></loading-spinner>

    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
          {{ king ? 'Edit King' : 'Create King' }}
        </h1>
        <inertia-link
          v-if="king"
          :href="$route('admin.kings.show', king.id)"
          class="btn btn-outline-secondary"
        >
          Cancel
        </inertia-link>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">King Information</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="submit">
                <div class="row g-4">
                  <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input
                      id="name"
                      v-model="form.name"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.name }"
                    >
                    <div class="invalid-feedback" v-if="form.errors.name">
                      {{ form.errors.name }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="regnal_name" class="form-label">Regnal Name</label>
                    <input
                      id="regnal_name"
                      v-model="form.regnal_name"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.regnal_name }"
                    >
                    <div class="invalid-feedback" v-if="form.errors.regnal_name">
                      {{ form.errors.regnal_name }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="birth_date" class="form-label">Birth Date</label>
                    <input
                      id="birth_date"
                      v-model="form.birth_date"
                      type="date"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.birth_date }"
                    >
                    <div class="invalid-feedback" v-if="form.errors.birth_date">
                      {{ form.errors.birth_date }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="death_year" class="form-label">Death Year</label>
                    <input
                      id="death_year"
                      v-model="form.death_year"
                      type="number"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.death_year }"
                    >
                    <div class="invalid-feedback" v-if="form.errors.death_year">
                      {{ form.errors.death_year }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="dynasty_id" class="form-label">Dynasty</label>
                    <div class="input-group">
                      <select
                        id="dynasty_id"
                        v-model="form.dynasty_id"
                        class="form-select"
                        :class="{ 'is-invalid': form.errors.dynasty_id }"
                      >
                        <option value="">Select Dynasty</option>
                        <option
                          v-for="dynasty in dynasties"
                          :key="dynasty.id"
                          :value="dynasty.id"
                        >
                          {{ dynasty.name }}
                        </option>
                      </select>
                      <button
                        type="button"
                        class="btn btn-outline-primary"
                        @click="showCreateDynastyModal = true"
                      >
                        +
                      </button>
                    </div>
                    <div class="invalid-feedback" v-if="form.errors.dynasty_id">
                      {{ form.errors.dynasty_id }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="reign_start_date" class="form-label">Reign Start Date</label>
                    <input
                      id="reign_start_date"
                      v-model="form.reign_start_date"
                      type="date"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.reign_start_date }"
                    >
                    <div class="invalid-feedback" v-if="form.errors.reign_start_date">
                      {{ form.errors.reign_start_date }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="reign_end_date" class="form-label">Reign End Date</label>
                    <input
                      id="reign_end_date"
                      v-model="form.reign_end_date"
                      type="date"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.reign_end_date }"
                    >
                    <div class="invalid-feedback" v-if="form.errors.reign_end_date">
                      {{ form.errors.reign_end_date }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="short_bio" class="form-label">Short Biography</label>
                    <textarea
                      id="short_bio"
                      v-model="form.short_bio"
                      rows="3"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.short_bio }"
                    />
                    <div class="invalid-feedback" v-if="form.errors.short_bio">
                      {{ form.errors.short_bio }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="full_bio" class="form-label">Full Biography</label>
                    <textarea
                      id="full_bio"
                      v-model="form.full_bio"
                      rows="6"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.full_bio }"
                    />
                    <div class="invalid-feedback" v-if="form.errors.full_bio">
                      {{ form.errors.full_bio }}
                    </div>
                  </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing"
                  >
                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    {{ king ? 'Update King' : 'Create King' }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="row g-4">
            <!-- Portrait Image -->
            <div class="col-12">
              <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                  <h5 class="card-title mb-0">Portrait Image</h5>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <div class="border rounded p-3 text-center" style="min-height: 200px;">
                      <template v-if="form.portrait_preview">
                        <img :src="form.portrait_preview" class="img-fluid" style="max-height: 180px;" alt="Portrait preview">
                      </template>
                      <template v-else-if="king && king.portraitMedia">
                        <img :src="'/storage/' + king.portraitMedia.path" class="img-fluid" style="max-height: 180px;" :alt="king.portraitMedia.caption || 'Portrait'">
                      </template>
                      <template v-else>
                        <div class="text-muted py-5">
                          <i class="bi bi-image display-5 d-block mb-2"></i>
                          <p class="mb-0">No portrait image selected</p>
                        </div>
                      </template>
                    </div>
                  </div>

                  <div class="d-grid gap-2">
                    <input
                      type="file"
                      ref="portraitInput"
                      class="d-none"
                      accept="image/*"
                      @change="handlePortraitChange"
                    >
                    <button
                      type="button"
                      class="btn btn-outline-primary"
                      @click="$refs.portraitInput.click()"
                    >
                      {{ king && (form.portrait_preview || king.portraitMedia) ? 'Change Portrait' : 'Select Portrait' }}
                    </button>

                    <button
                      v-if="king && (form.portrait_preview || king.portraitMedia)"
                      type="button"
                      class="btn btn-outline-danger"
                      @click="removePortrait"
                    >
                      Remove Portrait
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Additional Images -->
            <div class="col-12">
              <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                  <h5 class="card-title mb-0">Additional Images</h5>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <div class="border rounded p-3">
                      <div class="row g-2">
                        <!-- Existing additional images -->
                        <div
                          v-for="(image, index) in additionalImages"
                          :key="image.id"
                          class="col-6 col-md-4"
                        >
                          <div class="position-relative">
                            <img
                              :src="'/storage/' + image.path"
                              class="img-fluid rounded"
                              style="aspect-ratio: 1/1; object-fit: cover;"
                              :alt="image.caption || 'Image'"
                            >
                            <button
                              type="button"
                              class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                              @click="removeAdditionalImage(image.id)"
                            >
                              <i class="bi bi-x"></i>
                            </button>
                          </div>
                        </div>

                        <!-- New images preview -->
                        <div
                          v-for="(preview, index) in form.additional_image_previews"
                          :key="'preview-' + index"
                          class="col-6 col-md-4"
                        >
                          <div class="position-relative">
                            <img
                              :src="preview"
                              class="img-fluid rounded"
                              style="aspect-ratio: 1/1; object-fit: cover;"
                            >
                            <button
                              type="button"
                              class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                              @click="removeNewImagePreview(index)"
                            >
                              <i class="bi bi-x"></i>
                            </button>
                          </div>
                        </div>

                        <!-- Add image button -->
                        <div class="col-6 col-md-4">
                          <div class="border rounded d-flex align-items-center justify-content-center"
                               style="aspect-ratio: 1/1; cursor: pointer;"
                               @click="$refs.additionalImagesInput.click()">
                            <div class="text-center text-muted">
                              <i class="bi bi-plus-circle display-6"></i>
                              <p class="mb-0 small mt-1">Add Image</p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <input
                        type="file"
                        ref="additionalImagesInput"
                        class="d-none"
                        accept="image/*"
                        multiple
                        @change="handleAdditionalImagesChange"
                      >
                    </div>
                  </div>

                  <div class="alert alert-info small mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    You can upload multiple images for this king. These will appear in the gallery section of their profile.
                  </div>
                </div>
              </div>
            </div>

            <!-- Publishing -->
            <div class="col-12">
              <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                  <h5 class="card-title mb-0">Publishing</h5>
                </div>
                <div class="card-body">
                  <div class="form-check form-switch mb-3">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="featured"
                      v-model="form.featured"
                    >
                    <label class="form-check-label" for="featured">Feature on Homepage</label>
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
                    <input type="text" class="form-control" :value="king?.updated_at ? new Date(king.updated_at).toLocaleDateString() : 'N/A'" readonly>
                  </div>

                  <div class="mb-0">
                    <label class="form-label">Created By</label>
                    <input type="text" class="form-control" value="Editor John" readonly>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create Dynasty Modal -->
    <div class="modal fade" :class="{ 'show d-block': showCreateDynastyModal }" tabindex="-1" v-if="showCreateDynastyModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create New Dynasty</h5>
            <button type="button" class="btn-close" @click="showCreateDynastyModal = false"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createDynasty">
              <div class="mb-3">
                <label for="new_dynasty_name" class="form-label">Name *</label>
                <input
                  id="new_dynasty_name"
                  v-model="dynastyForm.name"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': dynastyForm.errors.name }"
                  placeholder="Enter dynasty name"
                >
                <div class="invalid-feedback" v-if="dynastyForm.errors.name">
                  {{ dynastyForm.errors.name }}
                </div>
              </div>

              <div class="mb-3">
                <label for="new_dynasty_description" class="form-label">Description</label>
                <textarea
                  id="new_dynasty_description"
                  v-model="dynastyForm.description"
                  rows="3"
                  class="form-control"
                  :class="{ 'is-invalid': dynastyForm.errors.description }"
                  placeholder="Enter dynasty description"
                />
                <div class="invalid-feedback" v-if="dynastyForm.errors.description">
                  {{ dynastyForm.errors.description }}
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="new_dynasty_start_year" class="form-label">Start Year</label>
                  <input
                    id="new_dynasty_start_year"
                    v-model="dynastyForm.start_year"
                    type="number"
                    class="form-control"
                    :class="{ 'is-invalid': dynastyForm.errors.start_year }"
                    placeholder="Enter start year"
                  >
                  <div class="invalid-feedback" v-if="dynastyForm.errors.start_year">
                    {{ dynastyForm.errors.start_year }}
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="new_dynasty_end_year" class="form-label">End Year</label>
                  <input
                    id="new_dynasty_end_year"
                    v-model="dynastyForm.end_year"
                    type="number"
                    class="form-control"
                    :class="{ 'is-invalid': dynastyForm.errors.end_year }"
                    placeholder="Enter end year"
                  >
                  <div class="invalid-feedback" v-if="dynastyForm.errors.end_year">
                    {{ dynastyForm.errors.end_year }}
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="showCreateDynastyModal = false">Cancel</button>
            <button type="button" class="btn btn-primary" @click="createDynasty" :disabled="dynastyForm.processing">
              <span v-if="dynastyForm.processing" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
              Create Dynasty
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade" :class="{ 'show': showCreateDynastyModal }" v-if="showCreateDynastyModal"></div>
  </admin-layout>
</template>

<script>
import AdminLayout from '../../../layouts/AdminLayout.vue'

export default {
  components: {
    AdminLayout,
  },
  props: {
    king: {
      type: Object,
      default: null,
    },
    dynasties: Array,
  },
  data() {
    return {
      showCreateDynastyModal: false,
      showLoading: false,
      form: this.$inertia.form({
        name: this.king?.name || '',
        regnal_name: this.king?.regnal_name || '',
        birth_year: this.king?.birth_year || null,
        death_year: this.king?.death_year || null,
        dynasty_id: this.king?.dynasty_id || '',
        reign_start_date: this.king?.reign_start_date || '',
        reign_end_date: this.king?.reign_end_date || '',
        short_bio: this.king?.short_bio || '',
        full_bio: this.king?.full_bio || '',
        featured: this.king?.featured ? true : false,
        portrait: null,
        portrait_preview: null,
        additional_images: [],
        additional_image_previews: [],
        removed_additional_images: []
      }),
      dynastyForm: this.$inertia.form({
        name: '',
        description: '',
        start_year: null,
        end_year: null,
      })
    }
  },
  computed: {
    additionalImages() {
      if (!this.king || !this.king.media) return [];
      // Filter out images that have been marked for removal
      return this.king.media.filter(image =>
        !this.form.removed_additional_images.includes(image.id)
      );
    }
  },
  methods: {
    handlePortraitChange(e) {
      const file = e.target.files[0];
      if (file) {
        this.form.portrait = file;
        this.form.portrait_preview = URL.createObjectURL(file);
      }
    },
    removePortrait() {
      this.form.portrait = null;
      this.form.portrait_preview = null;
      this.$refs.portraitInput.value = '';
    },
    handleAdditionalImagesChange(e) {
      const files = Array.from(e.target.files);
      if (files.length) {
        // Add files to form
        this.form.additional_images.push(...files);

        // Create previews
        files.forEach(file => {
          this.form.additional_image_previews.push(URL.createObjectURL(file));
        });
      }
    },
    removeNewImagePreview(index) {
      // Remove from previews
      this.form.additional_image_previews.splice(index, 1);

      // Remove from files (we need to recreate the array without the file at this index)
      const newFiles = [];
      let currentIndex = 0;

      for (let i = 0; i < this.form.additional_images.length; i++) {
        if (currentIndex !== index) {
          newFiles.push(this.form.additional_images[i]);
        }
        currentIndex++;
      }

      this.form.additional_images = newFiles;
    },
    removeAdditionalImage(imageId) {
      // Mark image for removal
      this.form.removed_additional_images.push(imageId);
    },
    submit() {
      this.showLoading = true;

      if (this.king) {
        // For updates, we need to use a POST request with _method=PUT for file uploads
        const formData = new FormData();
        formData.append('_method', 'PUT');

        // Add all form fields
        Object.keys(this.form.data()).forEach(key => {
          // Skip file-related fields as they need special handling
          if (!['portrait', 'additional_images', 'portrait_preview', 'additional_image_previews'].includes(key)) {
            if (key === 'removed_additional_images') {
              // Handle array of removed images
              this.form[key].forEach((id, index) => {
                formData.append(`removed_additional_images[${index}]`, id);
              });
            } else if (key === 'featured') {
              // Ensure featured is sent as proper boolean string
              formData.append(key, this.form[key] ? '1' : '0');
            } else {
              // Handle empty values for nullable integer fields
              if ((key === 'death_year' || key === 'dynasty_id') && (this.form[key] === '' || this.form[key] === null)) {
                // Skip empty values for nullable integer fields
                // They will be treated as null on the server side
              } else {
                formData.append(key, this.form[key]);
              }
            }
          }
        });

        // Add portrait if present
        if (this.form.portrait) {
          formData.append('portrait', this.form.portrait);
        }

        // Add additional images if present
        if (this.form.additional_images.length) {
          this.form.additional_images.forEach((file, index) => {
            formData.append(`additional_images[${index}]`, file);
          });
        }

        // Submit via axios for file upload support
        axios.post(this.$route('admin.kings.update', this.king.id), formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(response => {
          window.location = this.$route('admin.kings.index');
        }).catch(error => {
          this.showLoading = false;
          console.error('Error updating king:', error);
        });
      } else {
        // For creates, we need to use a POST request for file uploads
        const formData = new FormData();

        // Add all form fields
        Object.keys(this.form.data()).forEach(key => {
          // Skip file-related fields as they need special handling
          if (!['portrait', 'additional_images', 'portrait_preview', 'additional_image_previews'].includes(key)) {
            if (key === 'featured') {
              // Ensure featured is sent as proper boolean string
              formData.append(key, this.form[key] ? '1' : '0');
            } else {
              // Handle empty values for nullable integer fields
              if ((key === 'death_year' || key === 'dynasty_id') && (this.form[key] === '' || this.form[key] === null)) {
                // Skip empty values for nullable integer fields
                // They will be treated as null on the server side
              } else {
                formData.append(key, this.form[key]);
              }
            }
          }
        });

        // Add portrait if present
        if (this.form.portrait) {
          formData.append('portrait', this.form.portrait);
        }

        // Add additional images if present
        if (this.form.additional_images.length) {
          this.form.additional_images.forEach((file, index) => {
            formData.append(`additional_images[${index}]`, file);
          });
        }

        // Submit via axios for file upload support
        axios.post(this.$route('admin.kings.store'), formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(response => {
          window.location = this.$route('admin.kings.index');
        }).catch(error => {
          this.showLoading = false;
          console.error('Error creating king:', error);
        });
      }
    },
    async createDynasty() {
      this.dynastyForm.post(this.$route('admin.dynasties.store'), {
        onSuccess: () => {
          // Close the modal
          this.showCreateDynastyModal = false;

          // Show success message
          this.$swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Dynasty created successfully!',
            timer: 2000,
            showConfirmButton: false
          });

          // Reload the page to get the updated list of dynasties
          window.location.reload();
        },
        onError: () => {
          // Show error message
          this.$swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to create dynasty. Please check the form and try again.'
          });
        }
      });
    }
  }
}
</script>

<style scoped>
.card-title {
  font-size: 1.1rem;
}

.form-label {
  font-weight: 500;
}

.modal {
  background-color: rgba(0, 0, 0, 0.5);
}
</style>
