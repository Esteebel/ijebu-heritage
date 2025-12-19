<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>{{ ticket.title }}</h1>
          <p class="text-muted">View ticket details</p>
        </div>
        <div class="col-auto">
          <div class="btn-group" role="group">
            <inertia-link :href="$route('admin.tickets.edit', ticket.id)" class="btn btn-primary">
              Edit
            </inertia-link>
            <button @click="destroy" class="btn btn-danger">
              Delete
            </button>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0">Ticket Details</h5>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Price:</strong> ₦{{ parseFloat(ticket.price).toFixed(2) }}</p>
            </div>
            <div class="col-md-6">
              <p><strong>Status:</strong>
                <span :class="ticket.is_published ? 'badge bg-success' : 'badge bg-secondary'">
                  {{ ticket.is_published ? 'Published' : 'Draft' }}
                </span>
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <p><strong>Maximum Quantity:</strong> {{ ticket.max_quantity }}</p>
            </div>
            <div class="col-md-6">
              <p><strong>Available:</strong> {{ ticket.available_from }} to {{ ticket.available_to }}</p>
            </div>
          </div>

          <div class="mb-3">
            <p><strong>Description:</strong></p>
            <p>{{ ticket.description || 'No description provided' }}</p>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '../../../layouts/AdminLayout.vue'

export default {
  name: 'TicketsShow',
  layout: AdminLayout,
  props: {
    ticket: {
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
        this.$inertia.delete(this.$route('admin.tickets.destroy', this.ticket.id));
      }
    }
  }
}
</script>
