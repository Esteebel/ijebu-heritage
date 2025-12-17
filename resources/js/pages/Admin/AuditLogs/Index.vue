<template>
  <app-layout>
    <div class="container-fluid py-4">
      <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
          <h1 class="h3 fw-bold text-dark mb-0">Audit Logs</h1>
          <div>
            <button class="btn btn-outline-secondary me-2">
              <i class="bi bi-download me-1"></i> Export
            </button>
            <button class="btn btn-outline-danger">
              <i class="bi bi-trash me-1"></i> Clear Logs
            </button>
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-12 col-md-6 col-lg-4">
          <div class="input-group">
            <span class="input-group-text">
              <i class="bi bi-search"></i>
            </span>
            <input
              type="text"
              class="form-control"
              placeholder="Search logs..."
              v-model="searchQuery"
            >
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mt-2 mt-md-0">
          <select class="form-select" v-model="filterUser">
            <option value="">All Users</option>
            <option value="Admin User">Admin User</option>
            <option value="Editor User">Editor User</option>
          </select>
        </div>
        <div class="col-12 col-lg-4 mt-2 mt-lg-0">
          <select class="form-select" v-model="filterModel">
            <option value="">All Models</option>
            <option value="King">King</option>
            <option value="Event">Event</option>
            <option value="Media">Media</option>
            <option value="Ad">Advertisement</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Action</th>
                      <th>Model</th>
                      <th>Model ID</th>
                      <th>Timestamp</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="log in filteredLogs" :key="log.id">
                      <td>{{ log.user }}</td>
                      <td>{{ log.action }}</td>
                      <td>
                        <span class="badge bg-secondary">{{ log.model }}</span>
                      </td>
                      <td>{{ log.model_id }}</td>
                      <td>{{ new Date(log.timestamp).toLocaleString() }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                  Showing {{ filteredLogs.length }} of {{ logs.length }} logs
                </div>
                <nav>
                  <ul class="pagination mb-0">
                    <li class="page-item disabled">
                      <a class="page-link" href="#">Previous</a>
                    </li>
                    <li class="page-item active">
                      <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">2</a>
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
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../../../layouts/AppLayout.vue'

export default {
  name: 'AuditLogsIndex',
  components: {
    AppLayout,
  },
  props: {
    logs: Array
  },
  data() {
    return {
      searchQuery: '',
      filterUser: '',
      filterModel: ''
    }
  },
  computed: {
    filteredLogs() {
      return this.logs.filter(log => {
        // Apply search filter
        const matchesSearch = !this.searchQuery ||
          log.user.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          log.action.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          log.model.toLowerCase().includes(this.searchQuery.toLowerCase());

        // Apply user filter
        const matchesUser = !this.filterUser || log.user === this.filterUser;

        // Apply model filter
        const matchesModel = !this.filterModel || log.model === this.filterModel;

        return matchesSearch && matchesUser && matchesModel;
      });
    }
  }
}
</script>
