<template>
  <app-layout>
    <div class="container-fluid py-4">
      <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
          <h1 class="h3 fw-bold text-dark mb-0">User Permissions</h1>
          <button class="btn btn-primary" @click="savePermissions">
            <i class="bi bi-save me-1"></i> Save Changes
          </button>
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
                      <th>Permission</th>
                      <th>Description</th>
                      <th>Administrator</th>
                      <th>Editor</th>
                      <th>User</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(permission, index) in permissions" :key="index">
                      <td class="fw-bold">{{ permission.name }}</td>
                      <td>{{ permission.description }}</td>
                      <td>
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            :id="`admin-${index}`"
                            v-model="permission.roles"
                            value="admin"
                          >
                        </div>
                      </td>
                      <td>
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            :id="`editor-${index}`"
                            v-model="permission.roles"
                            value="editor"
                          >
                        </div>
                      </td>
                      <td>
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            :id="`user-${index}`"
                            v-model="permission.roles"
                            value="user"
                          >
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
  name: 'PermissionsIndex',
  components: {
    AppLayout,
  },
  props: {
    permissions: Array
  },
  methods: {
    savePermissions() {
      // In a real application, you would make an API call to save the permissions
      alert('Permissions saving functionality would be implemented here.')
    }
  }
}
</script>
