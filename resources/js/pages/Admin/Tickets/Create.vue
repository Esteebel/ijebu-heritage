<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>Add New Ticket</h1>
          <p class="text-muted">Create a new ticket for visitors</p>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0">Ticket Details</h5>
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

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="max_quantity" class="form-label">Maximum Quantity *</label>
                      <input
                        type="number"
                        class="form-control"
                        id="max_quantity"
                        v-model="form.max_quantity"
                        :class="{ 'is-invalid': errors.max_quantity }"
                        min="1"
                      >
                      <div class="invalid-feedback" v-if="errors.max_quantity">{{ errors.max_quantity }}</div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="available_from" class="form-label">Available From *</label>
                      <input
                        type="date"
                        class="form-control"
                        id="available_from"
                        v-model="form.available_from"
                        :class="{ 'is-invalid': errors.available_from }"
                      >
                      <div class="invalid-feedback" v-if="errors.available_from">{{ errors.available_from }}</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="available_to" class="form-label">Available To *</label>
                      <input
                        type="date"
                        class="form-control"
                        id="available_to"
                        v-model="form.available_to"
                        :class="{ 'is-invalid': errors.available_to }"
                      >
                      <div class="invalid-feedback" v-if="errors.available_to">{{ errors.available_to }}</div>
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
            </div>

            <div class="d-flex gap-2">
              <inertia-link :href="$route('admin.tickets.index')" class="btn btn-secondary">
                Cancel
              </inertia-link>
              <button type="submit" class="btn btn-primary" :disabled="processing">
                <span v-if="processing">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Saving...
                </span>
                <span v-else>Save Ticket</span>
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
  name: 'TicketsCreate',
  layout: AdminLayout,
  data() {
    return {
      processing: false,
      form: {
        title: '',
        description: '',
        price: '',
        max_quantity: '',
        available_from: '',
        available_to: '',
        is_published: false
      },
      errors: {}
    }
  },
  methods: {
    async submit() {
      this.processing = true
      this.errors = {}

      try {
        await this.$inertia.post(this.$route('admin.tickets.store'), this.form, {
          onSuccess: () => {
            this.processing = false
          },
          onError: (errors) => {
            this.errors = errors
            this.processing = false
          }
        })
      } catch (error) {
        this.processing = false
        console.error('Error saving ticket:', error)
      }
    }
  }
}
</script>
