<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Ticket Management</h1>
        <button class="btn btn-primary" @click="$inertia.visit('/admin/tickets/create')">
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Add New Ticket
        </button>
      </div>

      <div class="row g-4 mb-4">
        <!-- Stats Cards -->
        <div class="col-xl-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-primary bg-opacity-10 me-3">
                  <svg class="text-primary" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                  </svg>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Total Tickets</h6>
                  <h3 class="mb-0">{{ stats.total }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-success bg-opacity-10 me-3">
                  <svg class="text-success" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Active Tickets</h6>
                  <h3 class="mb-0">{{ stats.active }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-warning bg-opacity-10 me-3">
                  <svg class="text-warning" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Inactive Tickets</h6>
                  <h3 class="mb-0">{{ stats.total - stats.active }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-info bg-opacity-10 me-3">
                  <svg class="text-info" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Avg. Price</h6>
                  <h3 class="mb-0">{{ formatCurrency(tickets.length ? tickets.reduce((sum, t) => sum + parseFloat(t.price), 0) / tickets.length : 0) }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Ticket Types</h5>
            <div class="d-flex">
              <input type="text" class="form-control form-control-sm me-2" placeholder="Search tickets..." v-model="searchTerm">
              <select class="form-select form-select-sm" v-model="statusFilter">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Ticket Type</th>
                <th>Price</th>
                <th>Validity</th>
                <th>Status</th>
                <th>Sales</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(ticket, index) in filteredTickets" :key="ticket.id">
                <td>
                  <strong>{{ ticket.name }}</strong>
                  <div class="small text-muted">{{ ticket.description || 'No description' }}</div>
                </td>
                <td>{{ formatCurrency(ticket.price) }}</td>
                <td>1 Day</td>
                <td>
                  <span class="badge" :class="ticket.active ? 'bg-success' : 'bg-secondary'">{{ ticket.active ? 'Active' : 'Inactive' }}</span>
                </td>
                <td>-</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary" @click.stop="viewTicket(ticket.id)" title="View Ticket">
                      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                      </svg>
                    </button>
                    <button class="btn btn-outline-secondary" @click.stop="editTicket(ticket.id)" title="Edit Ticket">
                      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                    </button>
                    <button class="btn btn-outline-danger" @click.stop="deleteTicket(ticket.id)" title="Delete Ticket">
                      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="filteredTickets.length === 0">
                <td colspan="6" class="text-center text-muted py-5">
                  <i class="bi bi-ticket-perforated display-5 d-block mb-3"></i>
                  <p class="mb-0">No tickets found</p>
                  <p class="small mb-3">Try adjusting your search or filter criteria</p>
                  <button class="btn btn-primary btn-sm" @click="$inertia.visit('/admin/tickets/create')">
                    <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Ticket
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer bg-white border-top">
          <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
              Showing {{ filteredTickets.length }} of {{ tickets.length }} ticket types
            </div>
            <nav v-if="tickets.length > 10">
              <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active">
                  <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav>
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
    AdminLayout
  },
  props: {
    tickets: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      searchTerm: '',
      statusFilter: ''
    }
  },
  computed: {
    filteredTickets() {
      let filtered = this.tickets;

      if (this.searchTerm) {
        filtered = filtered.filter(ticket =>
          ticket.name.toLowerCase().includes(this.searchTerm.toLowerCase())
        );
      }

      if (this.statusFilter) {
        filtered = filtered.filter(ticket =>
          this.statusFilter === 'active' ? ticket.active : !ticket.active
        );
      }

      return filtered;
    },
    stats() {
      const total = this.tickets.length;
      const active = this.tickets.filter(t => t.active).length;
      return {
        total,
        active
      };
    }
  },
  methods: {
    formatCurrency(amount) {
      return new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: 'NGN'
      }).format(amount);
    },
    viewTicket(id) {
      if (!id) {
        console.error('Ticket ID is missing');
        return;
      }
      this.$inertia.visit(`/admin/tickets/${id}`, {
        preserveScroll: true,
        onError: (errors) => {
          console.error('Error viewing ticket:', errors);
        }
      });
    },
    editTicket(id) {
      if (!id) {
        console.error('Ticket ID is missing');
        return;
      }
      this.$inertia.visit(`/admin/tickets/${id}/edit`, {
        preserveScroll: true,
        onError: (errors) => {
          console.error('Error editing ticket:', errors);
        }
      });
    },
    async deleteTicket(id) {
      if (!id) {
        console.error('Ticket ID is missing');
        return;
      }
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
        this.$inertia.delete(`/admin/tickets/${id}`, {
          preserveScroll: true,
          onSuccess: () => {
            console.log('Ticket deleted successfully');
          },
          onError: (errors) => {
            console.error('Error deleting ticket:', errors);
          }
        });
      }
    }
  }
}
</script>

<style scoped>
.table th {
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.875rem;
  letter-spacing: 0.5px;
}
</style>
