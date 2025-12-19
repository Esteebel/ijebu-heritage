<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>Edit Booking</h1>
          <p class="text-muted">Update booking details</p>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0">Booking Details</h5>
        </div>

        <div class="card-body">
          <form @submit.prevent="submit">
            <div class="row">
              <div class="col-md-8">
                <div class="mb-3">
                  <label for="ticket_id" class="form-label">Ticket *</label>
                  <select
                    class="form-select"
                    id="ticket_id"
                    v-model="form.ticket_id"
                    :class="{ 'is-invalid': errors.ticket_id }"
                  >
                    <option value="">Select a ticket</option>
                    <option
                      v-for="ticket in tickets"
                      :key="ticket.id"
                      :value="ticket.id"
                    >
                      {{ ticket.title }} - ₦{{ parseFloat(ticket.price).toFixed(2) }}
                    </option>
                  </select>
                  <div class="invalid-feedback" v-if="errors.ticket_id">{{ errors.ticket_id }}</div>
                </div>

                <div class="mb-3">
                  <label for="user_id" class="form-label">User *</label>
                  <select
                    class="form-select"
                    id="user_id"
                    v-model="form.user_id"
                    :class="{ 'is-invalid': errors.user_id }"
                  >
                    <option value="">Select a user</option>
                    <option
                      v-for="user in users"
                      :key="user.id"
                      :value="user.id"
                    >
                      {{ user.name }} ({{ user.email }})
                    </option>
                  </select>
                  <div class="invalid-feedback" v-if="errors.user_id">{{ errors.user_id }}</div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="quantity" class="form-label">Quantity *</label>
                      <input
                        type="number"
                        class="form-control"
                        id="quantity"
                        v-model="form.quantity"
                        :class="{ 'is-invalid': errors.quantity }"
                        min="1"
                      >
                      <div class="invalid-feedback" v-if="errors.quantity">{{ errors.quantity }}</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="booking_date" class="form-label">Booking Date *</label>
                      <input
                        type="date"
                        class="form-control"
                        id="booking_date"
                        v-model="form.booking_date"
                        :class="{ 'is-invalid': errors.booking_date }"
                      >
                      <div class="invalid-feedback" v-if="errors.booking_date">{{ errors.booking_date }}</div>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="status" class="form-label">Status *</label>
                  <select
                    class="form-select"
                    id="status"
                    v-model="form.status"
                    :class="{ 'is-invalid': errors.status }"
                  >
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                  </select>
                  <div class="invalid-feedback" v-if="errors.status">{{ errors.status }}</div>
                </div>

                <div class="mb-3">
                  <label for="special_requests" class="form-label">Special Requests</label>
                  <textarea
                    class="form-control"
                    id="special_requests"
                    rows="3"
                    v-model="form.special_requests"
                    :class="{ 'is-invalid': errors.special_requests }"
                  ></textarea>
                  <div class="invalid-feedback" v-if="errors.special_requests">{{ errors.special_requests }}</div>
                </div>
              </div>
            </div>

            <div class="d-flex gap-2">
              <inertia-link :href="$route('admin.bookings.index')" class="btn btn-secondary">
                Cancel
              </inertia-link>
              <button type="submit" class="btn btn-primary" :disabled="processing">
                <span v-if="processing">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Updating...
                </span>
                <span v-else>Update Booking</span>
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
  name: 'BookingsEdit',
  layout: AdminLayout,
  props: {
    booking: {
      type: Object,
      required: true
    },
    tickets: {
      type: Array,
      required: true
    },
    users: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      processing: false,
      form: {
        ticket_id: this.booking.ticket_id,
        user_id: this.booking.user_id,
        quantity: this.booking.quantity,
        booking_date: this.booking.booking_date,
        status: this.booking.status,
        special_requests: this.booking.special_requests
      },
      errors: {}
    }
  },
  methods: {
    async submit() {
      this.processing = true
      this.errors = {}

      try {
        await this.$inertia.put(this.$route('admin.bookings.update', this.booking.id), this.form, {
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
        console.error('Error updating booking:', error)
      }
    }
  }
}
</script>
