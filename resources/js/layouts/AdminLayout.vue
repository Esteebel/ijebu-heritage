<template>
  <div class="d-flex min-vh-100">
    <!-- Sidebar -->
    <nav class="sidebar text-white d-flex flex-column" style="width: 250px;">
      <div class="d-flex flex-column h-100">
        <!-- Logo -->
        <div class="p-3 border-bottom border-light border-opacity-25">
          <div class="d-flex align-items-center">
            <img src="/storage/media/images/Ijebu-heritage-logo-removebg-preview.png" alt="Logo" class="me-2" style="width: 40px; height: 40px;">
            <span class="fs-6 fw-bold">Ijebu Heritage</span>
          </div>
        </div>

        <!-- Role Badge -->
        <div class="px-3 py-2">
          <span
            :class="[
              'badge',
              isAdmin ? 'bg-danger' : 'bg-primary'
            ]"
          >
            {{ isAdmin ? 'Admin' : 'Editor' }}
          </span>
        </div>

        <!-- Navigation -->
        <div class="flex-grow-1 overflow-auto">
          <ul class="nav flex-column px-4 py-3">
            <!-- Dashboard -->
            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('admin.dashboard')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url === '/admin' || $page.url === '/admin/' }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
              </inertia-link>
            </li>

            <!-- Content Management Section -->
            <li class="nav-item mt-3">
              <h6 class="text-uppercase text-light small mb-2 opacity-75">Content Management</h6>
            </li>

            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('timeline.index')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url.startsWith('/admin/timeline') }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Timeline
              </inertia-link>
            </li>

            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('admin.kings.index')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url.startsWith('/admin/kings') }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Kings
              </inertia-link>
            </li>

            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('admin.dynasties.index')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url.startsWith('/admin/dynasties') }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Dynasties
              </inertia-link>
            </li>

            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('admin.artifacts.index')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url.startsWith('/admin/artifacts') }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Gallery
              </inertia-link>
            </li>

            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('admin.events.index')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url.startsWith('/admin/events') }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Events
              </inertia-link>
            </li>

            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('admin.media.index')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url.startsWith('/admin/media') }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Media Library
              </inertia-link>
            </li>

            <!-- Tickets & Bookings Section -->
            <li class="nav-item mt-3">
              <h6 class="text-uppercase text-light small mb-2 opacity-75">Tickets & Bookings</h6>
            </li>

            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('admin.tickets.index')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url.startsWith('/admin/tickets') }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z"></path>
                </svg>
                Tickets
              </inertia-link>
            </li>

            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('admin.bookings.index')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url.startsWith('/admin/bookings') }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Bookings
              </inertia-link>
            </li>

            <!-- Virtual Tours -->
            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('admin.tours.index')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url.startsWith('/admin/tours') }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Virtual Tours
              </inertia-link>
            </li>

            <!-- Publishing Queue -->
            <li class="nav-item mb-1">
              <inertia-link
                :href="$route('admin.publishing.queue.index')"
                class="nav-link text-white d-flex align-items-center"
                :class="{ 'active': $page.url.startsWith('/admin/publishing') }"
              >
                <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Publishing Queue
              </inertia-link>
            </li>

            <!-- Admin-only sections -->
            <div v-if="isAdmin">
              <li class="nav-item mt-3">
                <h6 class="text-uppercase text-light small mb-2 opacity-75">Administration</h6>
              </li>

              <li class="nav-item mb-1">
                <inertia-link
                  :href="$route('admin.users.index')"
                  class="nav-link text-white d-flex align-items-center"
                  :class="{ 'active': $page.url.startsWith('/admin/users') }"
                >
                  <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                  </svg>
                  Users & Roles
                </inertia-link>
              </li>

              <li class="nav-item mb-1">
                <inertia-link
                  :href="$route('settings.index')"
                  class="nav-link text-white d-flex align-items-center"
                  :class="{ 'active': $page.url.startsWith('/admin/settings') }"
                >
                  <svg class="me-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                  Settings
                </inertia-link>
              </li>
            </div>
          </ul>
        </div>

        <!-- User Dropdown -->
        <div class="p-3 border-top border-light border-opacity-25 mt-auto">
          <div class="d-flex align-items-center mb-3">
            <div class="flex-shrink-0">
              <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <span class="text-white fw-bold">
                  {{ userInitials }}
                </span>
              </div>
            </div>
            <div class="ms-2">
              <p class="mb-0 small fw-bold text-white">
                {{ userName }}
              </p>
              <p class="mb-0 small text-light opacity-75">
                {{ userEmail }}
              </p>
            </div>
          </div>
          <button
            @click="logout"
            class="btn btn-outline-light w-100 btn-sm"
          >
            Logout
          </button>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-grow-1 d-flex flex-column">
      <!-- Top Navigation Bar -->
      <header class="bg-white shadow-sm">
        <div class="d-flex align-items-center justify-content-between p-3">
          <div class="d-flex align-items-center">
            <h1 class="h5 mb-0 fw-bold text-dark">
              {{ pageTitle }}
            </h1>
          </div>

          <div class="d-flex align-items-center">
            <!-- Global Search -->
            <div class="position-relative me-3">
              <div class="position-absolute top-50 start-0 translate-middle-y ms-2 text-muted">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </div>
              <input
                type="text"
                placeholder="Search..."
                class="form-control form-control-sm ps-5"
                style="width: 250px;"
              >
            </div>

            <!-- Notifications -->
            <button class="btn btn-light btn-sm me-3 position-relative">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
              </svg>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                3
              </span>
            </button>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-grow-1 overflow-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminLayout',
  computed: {
    isAdmin() {
      return this.$page.props.auth &&
             this.$page.props.auth.user &&
             this.$page.props.auth.user.role === 'admin';
    },
    userName() {
      return this.$page.props.auth && this.$page.props.auth.user ?
             this.$page.props.auth.user.name : 'User';
    },
    userEmail() {
      return this.$page.props.auth && this.$page.props.auth.user ?
             this.$page.props.auth.user.email : '';
    },
    userInitials() {
      const name = this.userName;
      return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
    },
    pageTitle() {
      // Extract page title from URL or route
      const path = this.$page.url;
      if (path.includes('dashboard')) return 'Dashboard Overview';
      if (path.includes('timeline')) return 'Timeline';
      if (path.includes('kings')) return 'Kings';
      if (path.includes('dynasties')) return 'Dynasties';
      if (path.includes('artifacts')) return 'Gallery';
      if (path.includes('events')) return 'Events';
      if (path.includes('media')) return 'Media Library';
      if (path.includes('tickets')) return 'Tickets';
      if (path.includes('bookings')) return 'Bookings';
      if (path.includes('tours')) return 'Virtual Tours';
      if (path.includes('publishing')) return 'Publishing Queue';
      if (path.includes('users')) return 'Users & Roles';
      if (path.includes('settings')) return 'Settings';
      return 'Dashboard';
    }
  },
  methods: {
    logout() {
      this.$inertia.post(this.$route('logout'));
    }
  }
}
</script>

<style scoped>
.sidebar {
  background-color: #B08B4F;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
  min-height: 100vh;
}

.nav-link {
  border-radius: 0.375rem;
  margin-bottom: 0.25rem;
  transition: all 0.2s ease-in-out;
  background-color: rgba(255, 255, 255, 0.1);
}

.nav-link:hover {
  background-color: rgba(255, 255, 255, 0.2);
}

.nav-link.active {
  background-color: rgba(255, 255, 255, 0.3);
}

.text-muted {
  color: #6c757d !important;
}

.badge {
  font-weight: 500;
}

.form-control {
  border: 1px solid #dee2e6;
  border-radius: 0.375rem;
}

.btn-light {
  background-color: #f8f9fa;
  border-color: #f8f9fa;
}

.btn-light:hover {
  background-color: #e9ecef;
  border-color: #e9ecef;
}

.border-light {
  border-color: rgba(255, 255, 255, 0.1) !important;
}

.text-light {
  color: rgba(255, 255, 255, 0.8) !important;
}
</style>
