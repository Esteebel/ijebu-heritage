<template>
  <admin-layout>
    <div class="container-fluid py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">System Settings</h1>
        <button class="btn btn-primary" v-if="isAdmin">
          <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          Save Changes
        </button>
      </div>

      <div class="row g-4">
        <!-- General Settings -->
        <div class="col-lg-6">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">General Settings</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Site Name</label>
                <input type="text" class="form-control" value="Ijebu Heritage Museum">
              </div>

              <div class="mb-3">
                <label class="form-label">Site Description</label>
                <textarea class="form-control" rows="3">Preserving the rich history of royal kingdoms through interactive exhibits and artifacts.</textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">Timezone</label>
                <select class="form-select">
                  <option selected>UTC+1 (West Africa Time)</option>
                  <option>UTC+0 (GMT)</option>
                  <option>UTC-5 (Eastern Time)</option>
                </select>
              </div>

              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="maintenanceMode" checked>
                <label class="form-check-label" for="maintenanceMode">Maintenance Mode</label>
                <div class="form-text">Enable maintenance mode to temporarily disable the site for visitors.</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Media Settings -->
        <div class="col-lg-6">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Media Settings</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Max Upload Size</label>
                <select class="form-select">
                  <option>2MB</option>
                  <option selected>5MB</option>
                  <option>10MB</option>
                  <option>20MB</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Allowed File Types</label>
                <input type="text" class="form-control" value="jpg,jpeg,png,gif,mp4,mov">
              </div>

              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="autoOptimize" checked>
                <label class="form-check-label" for="autoOptimize">Auto-optimize Images</label>
                <div class="form-text">Automatically compress uploaded images for better performance.</div>
              </div>

              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="watermark" checked>
                <label class="form-check-label" for="watermark">Add Watermark</label>
                <div class="form-text">Add watermark to all uploaded images.</div>
              </div>
            </div>
          </div>
        </div>

        <!-- SEO Settings -->
        <div class="col-lg-6">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">SEO Settings</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Meta Title Prefix</label>
                <input type="text" class="form-control" value="Ijebu Heritage |">
              </div>

              <div class="mb-3">
                <label class="form-label">Default Meta Description</label>
                <textarea class="form-control" rows="3">Discover the rich heritage of the Ijebu kingdom through our digital museum collection.</textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">Google Analytics ID</label>
                <input type="text" class="form-control" placeholder="UA-XXXXXXXX-X">
              </div>

              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="sitemap" checked>
                <label class="form-check-label" for="sitemap">Generate Sitemap</label>
              </div>
            </div>
          </div>
        </div>

        <!-- Security Settings -->
        <div class="col-lg-6">
          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title mb-0">Security Settings</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Session Timeout (minutes)</label>
                <input type="number" class="form-control" value="30">
              </div>

              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="twoFactor" checked>
                <label class="form-check-label" for="twoFactor">Two-Factor Authentication</label>
                <div class="form-text">Require two-factor authentication for admin users.</div>
              </div>

              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="ipRestriction">
                <label class="form-check-label" for="ipRestriction">IP Address Restriction</label>
                <div class="form-text">Restrict admin access to specific IP addresses.</div>
              </div>
            </div>
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
  computed: {
    isAdmin() {
      return this.$page.props.auth &&
             this.$page.props.auth.user &&
             this.$page.props.auth.user.role === 'admin';
    }
  }
}
</script>

<style scoped>
.card-title {
  font-size: 1.1rem;
}

.form-label {
  font-weight: 500;
}
</style>
