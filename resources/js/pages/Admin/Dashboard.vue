<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <!-- Stats Cards -->
      <div class="row g-4 mb-4">
        <!-- Total Live Content -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-success bg-opacity-10 me-3">
                  <i class="bi bi-check-circle text-success dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Live Content</h6>
                  <h3 class="mb-0">{{ stats.liveContent }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Draft Content -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-secondary bg-opacity-10 me-3">
                  <i class="bi bi-pencil-square text-secondary dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Draft Content</h6>
                  <h3 class="mb-0">{{ stats.draftContent }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Approvals -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-primary bg-opacity-10 me-3">
                  <i class="bi bi-clock-history text-primary dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Pending</h6>
                  <h3 class="mb-0">{{ stats.pendingApprovals }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Bookings -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-purple bg-opacity-10 me-3">
                  <i class="bi bi-ticket-perforated text-purple dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Bookings</h6>
                  <h3 class="mb-0">{{ stats.totalBookings }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Upcoming Events -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-warning bg-opacity-10 me-3">
                  <i class="bi bi-calendar-event text-warning dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Upcoming Events</h6>
                  <h3 class="mb-0">{{ stats.upcomingEvents }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Media Storage -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="icon-container bg-info bg-opacity-10 me-3">
                  <i class="bi bi-images text-info dashboard-icon"></i>
                </div>
                <div>
                  <h6 class="text-muted small mb-1">Media Storage</h6>
                  <h3 class="mb-0">{{ stats.mediaStorage }}%</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content Grid -->
      <div class="row g-4 mb-4">
        <!-- Activity Timeline -->
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
              <div class="list-group list-group-flush">
                <div v-for="(activity, index) in activities" :key="activity.id" class="list-group-item border-0 px-0 py-3">
                  <div class="d-flex">
                    <div class="position-relative me-3">
                      <div class="avatar rounded-circle d-flex align-items-center justify-content-center bg-white border">
                        <div :class="[
                          'avatar rounded-circle d-flex align-items-center justify-content-center',
                          activity.type === 'update' ? 'bg-primary bg-opacity-10' :
                          activity.type === 'publish' ? 'bg-success bg-opacity-10' :
                          activity.type === 'booking' ? 'bg-purple bg-opacity-10' : 'bg-secondary bg-opacity-10'
                        ]">
                          <i v-if="activity.type === 'update'" class="bi bi-pencil-square text-primary activity-icon"></i>
                          <i v-else-if="activity.type === 'publish'" class="bi bi-check-circle text-success activity-icon"></i>
                          <i v-else-if="activity.type === 'booking'" class="bi bi-ticket-perforated text-purple activity-icon"></i>
                          <i v-else class="bi bi-info-circle text-secondary activity-icon"></i>
                        </div>
                      </div>
                      <div v-if="index !== activities.length - 1" class="position-absolute top-100 start-50 translate-middle-x h-100 border-start" style="width: 1px;"></div>
                    </div>
                    <div class="flex-grow-1">
                      <div class="d-flex align-items-center mb-1">
                        <h6 class="mb-0 me-2">{{ activity.user }}</h6>
                        <span class="text-muted">{{ activity.action }}</span>
                        <strong class="ms-1">{{ activity.target }}</strong>
                      </div>
                      <small class="text-muted">{{ activity.time }}</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
          <div class="row g-4">
            <!-- Content Creation -->
            <div class="col-12">
              <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                  <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                  <div class="row g-2">
                    <div class="col-6">
                      <button
                        @click="$inertia.visit($route('kings.index'))"
                        class="btn btn-outline-primary w-100 py-2"
                      >
                        <i class="bi bi-person-circle d-block mx-auto mb-1 action-icon"></i>
                        <span class="small">Manage Kings</span>
                      </button>
                    </div>

                    <div class="col-6">
                      <button
                        @click="$inertia.visit($route('events.index'))"
                        class="btn btn-outline-success w-100 py-2"
                      >
                        <i class="bi bi-calendar-event d-block mx-auto mb-1 action-icon"></i>
                        <span class="small">Manage Events</span>
                      </button>
                    </div>

                    <div class="col-6">
                      <button
                        @click="$inertia.visit($route('artifacts.index'))"
                        class="btn btn-outline-purple w-100 py-2"
                      >
                        <i class="bi bi-images d-block mx-auto mb-1 action-icon"></i>
                        <span class="small">Manage Gallery</span>
                      </button>
                    </div>

                    <div class="col-6">
                      <button
                        @click="$inertia.visit($route('media.index'))"
                        class="btn btn-outline-warning w-100 py-2"
                      >
                        <i class="bi bi-folder d-block mx-auto mb-1 action-icon"></i>
                        <span class="small">Manage Media</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Content Status Overview -->
            <div class="col-12">
              <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                  <h5 class="card-title mb-0">Content Status</h5>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                      <span class="text-muted small">Live Content</span>
                      <span class="small">{{ contentStatus.live }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                      <div
                        class="progress-bar bg-success"
                        :style="{ width: contentStatus.live > 0 ? (contentStatus.live / contentStatus.total * 100) + '%' : '0%' }"
                      ></div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                      <span class="text-muted small">Draft Content</span>
                      <span class="small">{{ contentStatus.draft }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                      <div
                        class="progress-bar bg-secondary"
                        :style="{ width: contentStatus.draft > 0 ? (contentStatus.draft / contentStatus.total * 100) + '%' : '0%' }"
                      ></div>
                    </div>
                  </div>

                  <div>
                    <div class="d-flex justify-content-between mb-1">
                      <span class="text-muted small">Pending Approval</span>
                      <span class="small">{{ contentStatus.pending }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                      <div
                        class="progress-bar bg-primary"
                        :style="{ width: contentStatus.pending > 0 ? (contentStatus.pending / contentStatus.total * 100) + '%' : '0%' }"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Publishing Queue Preview -->
      <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Publishing Queue</h5>
          <inertia-link
            :href="$route('admin.dashboard')"
            class="btn btn-sm btn-outline-primary"
          >
            View all
          </inertia-link>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Content</th>
                <th>Type</th>
                <th>Author</th>
                <th>Status</th>
                <th>Last Updated</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in publishingQueue" :key="item.id">
                <td>{{ item.title }}</td>
                <td>{{ item.type }}</td>
                <td>{{ item.author }}</td>
                <td>
                  <span
                    :class="[
                      'badge',
                      item.status === 'draft' ? 'bg-secondary' :
                      item.status === 'ready' ? 'bg-primary' :
                      'bg-success'
                    ]"
                  >
                    {{ item.status }}
                  </span>
                </td>
                <td>{{ item.lastUpdated }}</td>
                <td>
                  <button
                    v-if="canPublish(item)"
                    @click="publishItem(item)"
                    class="btn btn-sm btn-success"
                  >
                    Set Live
                  </button>
                  <span v-else>-</span>
                </td>
              </tr>
            </tbody>
          </table>
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
    stats: Object,
    activities: Array,
    contentStatus: Object,
    publishingQueue: Array
  },
  computed: {
    isAdmin() {
      return this.$page.props.auth &&
             this.$page.props.auth.user &&
             this.$page.props.auth.user.role === 'admin';
    }
  },
  methods: {
    canPublish(item) {
      // Admins can publish anything, editors can only publish their own content
      if (this.isAdmin) return true;
      return item.authorId === this.$page.props.auth.user.id;
    },
    publishItem(item) {
      // Show confirmation modal before publishing
      if (confirm('This action will make this content visible to the public. Are you sure?')) {
        // In a real implementation, this would make an API call to publish the item
        console.log('Publishing item:', item);
        // Refresh the page or update the UI accordingly
      }
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
  font-size: 20px;
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
