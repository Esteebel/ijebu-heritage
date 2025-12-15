<template>
  <admin-layout>
    <loading-spinner :loading="showLoading"></loading-spinner>

    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
          {{ dynasty ? 'Edit Dynasty' : 'Create Dynasty' }}
        </h1>
        <inertia-link
          v-if="dynasty"
          :href="$route('admin.dynasties.show', dynasty.id)"
          class="btn btn-outline-secondary"
        >
          Cancel
        </inertia-link>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Dynasty Information</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="submit">
                <div class="row g-4">
                  <div class="col-md-12">
                    <label for="name" class="form-label">Name *</label>
                    <input
                      id="name"
                      v-model="form.name"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.name }"
                      placeholder="Enter dynasty name"
                    >
                    <div class="invalid-feedback" v-if="form.errors.name">
                      {{ form.errors.name }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="start_year" class="form-label">Start Year</label>
                    <input
                      id="start_year"
                      v-model="form.start_year"
                      type="number"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.start_year }"
                      placeholder="Enter start year"
                    >
                    <div class="invalid-feedback" v-if="form.errors.start_year">
                      {{ form.errors.start_year }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="end_year" class="form-label">End Year</label>
                    <input
                      id="end_year"
                      v-model="form.end_year"
                      type="number"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.end_year }"
                      placeholder="Enter end year"
                    >
                    <div class="invalid-feedback" v-if="form.errors.end_year">
                      {{ form.errors.end_year }}
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
                      placeholder="Enter dynasty description"
                    />
                    <div class="invalid-feedback" v-if="form.errors.description">
                      {{ form.errors.description }}
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
                    {{ dynasty ? 'Update Dynasty' : 'Create Dynasty' }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Information</h5>
            </div>
            <div class="card-body">
              <p class="mb-0">
                A dynasty is a sequence of rulers from the same family. Please provide accurate historical information when creating or editing a dynasty.
              </p>
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
    dynasty: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      showLoading: false,
      form: this.$inertia.form({
        name: this.dynasty?.name || '',
        description: this.dynasty?.description || '',
        start_year: this.dynasty?.start_year || null,
        end_year: this.dynasty?.end_year || null,
      })
    }
  },
  methods: {
    submit() {
      this.showLoading = true;
      if (this.dynasty) {
        this.form.put(this.$route('admin.dynasties.update', this.dynasty.id), {
          onFinish: () => {
            this.showLoading = false;
          }
        });
      } else {
        this.form.post(this.$route('admin.dynasties.store'), {
          onFinish: () => {
            this.showLoading = false;
          }
        });
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
</style>}
</script>

<style scoped>
.card-title {
  font-size: 1.1rem;
}

.form-label {
  font-weight: 500;
}
</style>
