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
                    <label for="biography" class="form-label">Biography</label>
                    <textarea
                      id="biography"
                      v-model="form.biography"
                      rows="6"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.biography }"
                    />
                    <div class="invalid-feedback" v-if="form.errors.biography">
                      {{ form.errors.biography }}
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
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Publishing</h5>
            </div>
            <div class="card-body">
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="published" checked>
                <label class="form-check-label" for="published">Publish to Live Site</label>
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
                <input type="text" class="form-control" value="Dec 12, 2023" readonly>
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
        dynasty_id: this.king?.dynasty_id || '',
        reign_start_date: this.king?.reign_start_date || '',
        reign_end_date: this.king?.reign_end_date || '',
        biography: this.king?.biography || '',
      }),
      dynastyForm: this.$inertia.form({
        name: '',
        description: '',
        start_year: null,
        end_year: null,
      })
    }
  },
  methods: {
    submit() {
      this.showLoading = true;
      if (this.king) {
        this.form.put(this.$route('admin.kings.update', this.king.id), {
          onFinish: () => {
            this.showLoading = false;
          }
        });
      } else {
        this.form.post(this.$route('admin.kings.store'), {
          onFinish: () => {
            this.showLoading = false;
          }
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
