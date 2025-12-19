<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>Booking #{{ booking.id }}</h1>
          <p class="text-muted">View booking details</p>
        </div>
        <div class="col-auto">
          <div class="btn-group" role="group">
            <inertia-link :href="$route('admin.bookings.edit', booking.id)" class="btn btn-primary">
              Edit
            </inertia-link>
            <button @click="destroy" class="btn btn-danger">
              Delete
            </button>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0">Booking Details</h5>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <p><strong>Ticket:</strong> {{ booking.ticket.title }}</p>
                </div>
                <div class="col-md-6">
                  <p><strong>User:</strong> {{ booking.user.name }}</p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <p><strong>Quantity:</strong> {{ booking.quantity }}</p>
                </div>
                <div class="col-md-6">
                  <p><strong>Total Price:</strong> ₦{{ (parseFloat(booking.ticket.price) * booking.quantity).toFixed(2) }}</p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <p><strong>Booking Date:</strong> {{ booking.booking_date }}</p>
                </div>
                <div class="col-md-6">
                  <p><strong>Status:</strong>
                    <span :class="getStatusClass(booking.status)">
                      {{ booking.status.charAt(0).toUpperCase() + booking.status.slice(1) }}
                    </span>
                  </p>
                </div>
              </div>

              <div class="mb-3">
                <p><strong>Special Requests:</strong></p>
                <p>{{ booking.special_requests || 'No special requests' }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0">User Information</h5>
            </div>

            <div class="card-body">
              <p><strong>Name:</strong> {{ booking.user.name }}</p>
              <p><strong>Email:</strong> {{ booking.user.email }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '../../../layouts/AdminLayout.vue'

export default {
  name: 'BookingsShow',
  layout: AdminLayout,
  props: {
    booking: {
      type: Object,
      required: true
    }
  },
  methods: {
    async destroy() {
      const result = await this.$swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      });

      if (result.isConfirmed) {
        this.$inertia.delete(this.$route('admin.bookings.destroy', this.booking.id));
      }
    },
    getStatusClass(status) {
      const classes = {
        pending: 'badge bg-warning',
        confirmed: 'badge bg-success',
        cancelled: 'badge bg-danger'
      };
      return classes[status] || 'badge bg-secondary';
    }
  }
}
</script>
