<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <!-- Stats Cards -->
      <div class="row g-4 mb-4">
        <!-- Featured Kings -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-primary bg-opacity-10 me-3">
                  <i class="bi bi-person-circle text-primary dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Featured Kings</h6>
                  <h3 class="mb-0">{{ featuredKingsCount }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Events -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-success bg-opacity-10 me-3">
                  <i class="bi bi-calendar-event text-success dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Events</h6>
                  <h3 class="mb-0">{{ eventsCount }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Artifacts -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-warning bg-opacity-10 me-3">
                  <i class="bi bi-images text-warning dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Artifacts</h6>
                  <h3 class="mb-0">{{ artifactsCount }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Bookings -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-info bg-opacity-10 me-3">
                  <i class="bi bi-ticket-perforated text-info dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Bookings</h6>
                  <h3 class="mb-0">{{ bookingsCount }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Publishing Queue -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-purple bg-opacity-10 me-3">
                  <i class="bi bi-file-earmark-text text-white dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Queue Items</h6>
                  <h3 class="mb-0">{{ publishingQueueCount }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Draft Items -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-warning bg-opacity-10 me-3">
                  <i class="bi bi-pencil-square text-warning dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Draft Items</h6>
                  <h3 class="mb-0">{{ draftQueueItems }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="row g-4 mb-4">
        <!-- Recent Bookings -->
        <div class="col-lg-6">
          <div class="card shadow-sm h-100">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
              <h5 class="card-title mb-0">Recent Bookings</h5>
              <button
                @click="$inertia.visit(route('admin.bookings.index'))"
                class="btn btn-sm btn-outline-primary"
              >
                View All
              </button>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Booking ID</th>
                    <th>User</th>
                    <th>Ticket Type</th>
                    <th>Quantity</th>
                    <th>Visit Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="booking in recentBookings" :key="booking.id">
                    <td>#{{ booking.id }}</td>
                    <td>{{ booking.user.name }}</td>
                    <td>{{ booking.ticket.name }}</td>
                    <td>{{ booking.quantity }}</td>
                    <td>{{ formatDate(booking.visit_date) }}</td>
                    <td>${{ booking.total_amount }}</td>
                    <td>
                      <span
                        :class="[
                          'badge',
                          booking.status === 'pending' ? 'bg-warning' :
                          booking.status === 'confirmed' ? 'bg-success' : 'bg-secondary'
                        ]"
                      >
                        {{ booking.status }}
                      </span>
                    </td>
                  </tr>
                  <tr v-if="recentBookings.length === 0">
                    <td colspan="7" class="text-center text-muted">No bookings found</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Recent Queue Items -->
        <div class="col-lg-6">
          <div class="card shadow-sm h-100">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
              <h5 class="card-title mb-0">Recent Queue Items</h5>
              <button
                @click="$inertia.visit(route('admin.publishing.queue.index'))"
                class="btn btn-sm btn-outline-primary"
              >
                View All
              </button>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Created</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in recentQueueItems" :key="item.id">
                    <td>{{ item.title }}</td>
                    <td>
                      <span class="badge" :class="getTypeBadgeClass(item.type)">
                        {{ item.type }}
                      </span>
                    </td>
                    <td>{{ item.user.name }}</td>
                    <td>
                      <span class="badge" :class="getStatusBadgeClass(item.status)">
                        {{ item.status }}
                      </span>
                    </td>
                    <td>{{ formatDate(item.created_at) }}</td>
                  </tr>
                  <tr v-if="recentQueueItems.length === 0">
                    <td colspan="5" class="text-center text-muted">No queue items found</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Manage Content</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-4 col-sm-6">
                  <button
                    @click="$inertia.visit(route('admin.kings.index'))"
                    class="btn btn-outline-primary w-100 py-3"
                  >
                    <i class="bi bi-person-circle d-block mx-auto mb-2 action-icon"></i>
                    <span>Manage Kings</span>
                  </button>
                </div>

                <div class="col-md-4 col-sm-6">
                  <button
                    @click="$inertia.visit(route('admin.events.index'))"
                    class="btn btn-outline-success w-100 py-3"
                  >
                    <i class="bi bi-calendar-event d-block mx-auto mb-2 action-icon"></i>
                    <span>Manage Events</span>
                  </button>
                </div>

                <div class="col-md-4 col-sm-6">
                  <button
                    @click="$inertia.visit(route('admin.artifacts.index'))"
                    class="btn btn-outline-warning w-100 py-3"
                  >
                    <i class="bi bi-images d-block mx-auto mb-2 action-icon"></i>
                    <span>Manage Artifacts</span>
                  </button>
                </div>

                <div class="col-md-4 col-sm-6">
                  <button
                    @click="$inertia.visit(route('admin.tickets.index'))"
                    class="btn btn-outline-info w-100 py-3"
                  >
                    <i class="bi bi-ticket-perforated d-block mx-auto mb-2 action-icon"></i>
                    <span>Manage Tickets</span>
                  </button>
                </div>

                <div class="col-md-4 col-sm-6">
                  <button
                    @click="$inertia.visit(route('admin.tours.index'))"
                    class="btn btn-outline-purple w-100 py-3"
                  >
                    <i class="bi bi-camera-video d-block mx-auto mb-2 action-icon"></i>
                    <span>Manage Tours</span>
                  </button>
                </div>

                <div class="col-md-4 col-sm-6">
                  <button
                    @click="$inertia.visit(route('admin.bookings.index'))"
                    class="btn btn-outline-secondary w-100 py-3"
                  >
                    <i class="bi bi-bookmark-check d-block mx-auto mb-2 action-icon"></i>
                    <span>Manage Bookings</span>
                  </button>
                </div>

                <div class="col-md-4 col-sm-6">
                  <button
                    @click="$inertia.visit(route('admin.publishing.queue.index'))"
                    class="btn btn-outline-dark w-100 py-3"
                  >
                    <i class="bi bi-file-earmark-text d-block mx-auto mb-2 action-icon"></i>
                    <span>Publishing Queue</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">System Overview</h5>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Total Entities</span>
                <span class="fw-bold">{{ featuredKingsCount + eventsCount + artifactsCount }}</span>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Active Bookings</span>
                <span class="fw-bold">{{ bookingsCount }}</span>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Queue Items</span>
                <span class="fw-bold">{{ publishingQueueCount }}</span>
              </div>
              <div class="d-flex justify-content-between">
                <span class="text-muted">System Status</span>
                <span class="badge bg-success">Operational</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import AdminLayout from '../../layouts/AdminLayout.vue'

export default {
  components: {
    AdminLayout
  },
  props: {
    featuredKingsCount: Number,
    eventsCount: Number,
    artifactsCount: Number,
    bookingsCount: Number,
    recentBookings: Array,
    publishingQueueCount: Number,
    draftQueueItems: Number,
    readyQueueItems: Number,
    recentQueueItems: Array
  },
  methods: {
    route(name) {
      // Simple route helper for demonstration
      const routes = {
        'admin.kings.index': '/admin/kings',
        'admin.events.index': '/admin/events',
        'admin.artifacts.index': '/admin/artifacts',
        'admin.tickets.index': '/admin/tickets',
        'admin.tours.index': '/admin/tours',
        'admin.bookings.index': '/admin/bookings',
        'admin.publishing.queue.index': '/admin/publishing/queue'
      };
      return routes[name] || '#';
    },
    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString();
    },
    getTypeBadgeClass(type) {
      const classes = {
        'king': 'bg-primary',
        'event': 'bg-success',
        'artifact': 'bg-warning',
        'tour': 'bg-info',
        'ticket': 'bg-secondary'
      };
      return classes[type] || 'bg-secondary';
    },
    getStatusBadgeClass(status) {
      const classes = {
        'draft': 'bg-warning',
        'ready': 'bg-info',
        'published': 'bg-success'
      };
      return classes[status] || 'bg-secondary';
    }
  }
}
</script>

<style scoped>
.avatar {
  width: 40px;
  height: 40px;
}

.icon-container {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.dashboard-icon {
  font-size: 24px;
}

.activity-icon {
  font-size: 20px;
}

.action-icon {
  font-size: 24px;
}

.text-purple {
  color: #6f42c1 !important;
}

.bg-purple {
  background-color: #6f42c1 !important;
}

.bg-opacity-10 {
  --bs-bg-opacity: 0.1;
}

.btn-outline-purple {
  color: #6f42c1;
  border-color: #6f42c1;
}

.btn-outline-purple:hover {
  color: #fff;
  background-color: #6f42c1;
  border-color: #6f42c1;
}

.btn-outline-purple:focus {
  box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
}

.small {
  font-size: 0.875rem;
}
</style>
