<template>
  <app-layout>
    <div class="container-fluid py-4">
      <div class="row mb-4">
        <div class="col-12">
          <h1 class="h3 fw-bold text-dark">
            {{ user ? 'Edit User' : 'Add User' }}
          </h1>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <form @submit.prevent="saveUser">
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    v-model="formData.name"
                    required
                  >
                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    v-model="formData.email"
                    required
                  >
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">
                    {{ user ? 'New Password (optional)' : 'Password' }}
                  </label>
                  <input
                    type="password"
                    class="form-control"
                    id="password"
                    v-model="formData.password"
                    :required="!user"
                  >
                </div>

                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">
                    Confirm Password
                  </label>
                  <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    v-model="formData.password_confirmation"
                    :required="!user || formData.password"
                  >
                </div>

                <div class="mb-3">
                  <label for="role" class="form-label">Role</label>
                  <select class="form-select" id="role" v-model="formData.role" required>
                    <option value="admin">Administrator</option>
                    <option value="editor">Editor</option>
                    <option value="user">User</option>
                  </select>
                </div>

                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary">
                    {{ user ? 'Update User' : 'Create User' }}
                  </button>
                  <a href="/admin/users" class="btn btn-secondary">
                    Cancel
                  </a>
                </div>
              </form>
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
  name: 'UserForm',
  components: {
    AppLayout,
  },
  props: {
    user: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      formData: {
        name: this.user ? this.user.name : '',
        email: this.user ? this.user.email : '',
        password: '',
        password_confirmation: '',
        role: this.user ? this.user.role : 'user'
      }
    }
  },
  methods: {
    saveUser() {
      // In a real application, you would make an API call to save the user
      alert('User saving functionality would be implemented here.')
    }
  }
}
</script>
