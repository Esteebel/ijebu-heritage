<template>
  <app-layout>
    <div class="container my-5">
      <div class="row">
        <div class="col-12">
          <h1 class="h2 fw-bold text-dark mb-4">Featured Kings</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="row g-4">
            <div
              v-for="king in kings"
              :key="king.id"
              class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
            >
              <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden" style="height: 250px;">
                  <img
                    v-if="king.portrait_media"
                    :src="'/storage/' + king.portrait_media.path"
                    class="img-fluid w-100 h-100 object-fit-cover"
                    :alt="king.name"
                    style="object-fit: cover;"
                  >
                  <div v-else class="text-center p-4">
                    <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-2 mb-0">No Image Available</p>
                  </div>
                </div>
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <h3 class="h4 fw-bold text-dark mb-0">{{ king.name }}</h3>
                    <span class="badge bg-primary-subtle text-primary">{{ king.dynasty ? king.dynasty.name : 'Unknown Dynasty' }}</span>
                  </div>
                  <p class="text-muted flex-grow-1">{{ king.short_bio }}</p>
                  <a
                    :href="route('kings.show', king.id)"
                    class="btn btn-outline-primary mt-3"
                  >
                    View Profile
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../../layouts/AppLayout.vue'

export default {
  name: 'PublicKingsIndex',
  props: {
    kings: Array,
  },
  components: {
    AppLayout,
  },
  methods: {
    route(name, params) {
      // Simple route helper for demonstration
      // In a real app, you'd use Ziggy or similar
      const routes = {
        'kings.show': `/kings/${params}`
      };
      return routes[name] || '#';
    }
  }
}
</script>

<style scoped>
/* Hover lift effect */
.hover-lift {
  transition: all 0.3s ease;
}

.hover-lift:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15) !important;
}

/* Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate__fadeInUp {
  animation: fadeInUp 0.8s ease-out forwards;
}

.object-fit-cover {
  object-fit: cover;
}
</style>
