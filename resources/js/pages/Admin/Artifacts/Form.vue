<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="mb-4">
        <inertia-link
          :href="$route('artifacts.index')"
          class="btn btn-link text-decoration-none"
        >
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Gallery
        </inertia-link>
        <h1 class="h3 mt-2 mb-0">
          {{ artifact ? 'Edit Artifact' : 'Add New Artifact' }}
        </h1>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Artifact Information</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="submit">
                <div class="row g-4">
                  <div class="col-12">
                    <label for="title" class="form-label">Title</label>
                    <input
                      id="title"
                      v-model="form.title"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.title }"
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
                      rows="4"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.description }"
                    />
                    <div class="invalid-feedback" v-if="form.errors.description">
                      {{ form.errors.description }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="era" class="form-label">Era</label>
                    <input
                      id="era"
                      v-model="form.era"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.era }"
                    >
                    <div class="invalid-feedback" v-if="form.errors.era">
                      {{ form.errors.era }}
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
                    >
                    <div class="invalid-feedback" v-if="form.errors.origin_location">
                      {{ form.errors.origin_location }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="media_id" class="form-label">Media</label>
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
                        {{ media.name }}
                      </option>
                    </select>
                    <div class="invalid-feedback" v-if="form.errors.media_id">
                      {{ form.errors.media_id }}
                    </div>
                  </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                  <inertia-link
                    v-if="artifact"
                    :href="$route('artifacts.show', artifact.id)"
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
                    {{ artifact ? 'Update Artifact' : 'Create Artifact' }}
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
  </admin-layout>
</template>

<script>
import AdminLayout from '../../../layouts/AdminLayout.vue'

export default {
  components: {
    AdminLayout,
  },
  props: {
    artifact: {
      type: Object,
      default: null,
    },
    mediaItems: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        title: this.artifact?.title || '',
        description: this.artifact?.description || '',
        era: this.artifact?.era || '',
        origin_location: this.artifact?.origin_location || '',
        media_id: this.artifact?.media_id || '',
      })
    }
  },
  methods: {
    submit() {
      if (this.artifact) {
        this.form.put(this.$route('artifacts.update', this.artifact.id))
      } else {
        this.form.post(this.$route('artifacts.store'))
      }
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
</style>
