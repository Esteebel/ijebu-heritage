<template>
  <app-layout>
    <div class="container-fluid py-4">
      <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
          <h1 class="h3 fw-bold text-dark mb-0">User Management</h1>
          <a href="/admin/users/create" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add User
          </a>
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
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Created At</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>
                        <span class="badge" :class="{
                          'bg-primary': user.role === 'admin',
                          'bg-success': user.role === 'editor',
                          'bg-secondary': user.role === 'user'
                        }">
                          {{ user.role }}
                        </span>
                      </td>
                      <td>{{ new Date(user.created_at).toLocaleDateString() }}</td>
                      <td>
                        <div class="btn-group" role="group">
                          <a :href="`/admin/users/${user.id}/edit`" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                          </a>
                          <button @click="deleteUser(user.id)" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
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
  name: 'UsersIndex',
  components: {
    AppLayout,
  },
  props: {
    users: Array
  },
  methods: {
    deleteUser(userId) {
      if (confirm('Are you sure you want to delete this user?')) {
        // In a real application, you would make an API call to delete the user
        alert('User deletion functionality would be implemented here.')
      }
    }
  }
}
</script>
