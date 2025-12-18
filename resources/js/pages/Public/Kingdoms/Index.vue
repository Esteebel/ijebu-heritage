<template>
  <app-layout>
    <div class="container my-5">
      <div class="row">
        <div class="col-12">
          <h1 class="h2 fw-bold text-dark mb-4">Kingdoms & Dynasties</h1>
          <p class="text-muted lead">
            Explore the rich history of various kingdoms and their royal dynasties through the centuries.
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="row g-4">
            <div
              v-for="kingdom in kingdoms"
              :key="kingdom.id"
              class="col-12 col-md-6 col-lg-3 animate__animated animate__fadeInUp"
            >
              <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px;">
                  <div class="text-center p-4">
                    <i class="bi bi-building text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-2 mb-0">{{ kingdom.name }}</p>
                  </div>
                </div>
                <div class="card-body d-flex flex-column">
                  <h3 class="h5 fw-bold text-dark mb-3">{{ kingdom.name }}</h3>
                  <p class="text-muted flex-grow-1">{{ kingdom.description?.substring(0, 100) }}{{ kingdom.description?.length > 100 ? '...' : '' }}</p>
                  <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-muted small">{{ kingdom.kings_count }} Kings</span>
                    <a
                      :href="route('kingdoms.show', kingdom.id)"
                      class="btn btn-outline-primary btn-sm"
                    >
                      Explore
                    </a>
                  </div>
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
import AppLayout from '../../../layouts/AppLayout.vue'

export default {
  name: 'PublicKingdomsIndex',
  props: {
    kingdoms: Array,
  },
  components: {
    AppLayout,
  },
  methods: {
    route(name, params) {
      // Simple route helper for demonstration
      // In a real app, you'd use Ziggy or similar
      const routes = {
        'kingdoms.show': `/kingdoms/${params}`
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
