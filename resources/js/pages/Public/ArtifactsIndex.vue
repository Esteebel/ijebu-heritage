<template>
  <app-layout>
    <div class="container my-5">
      <div class="row">
        <div class="col-12">
          <h1 class="h2 fw-bold text-dark mb-4">Exhibits Collection</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="row g-4">
            <div
              v-for="artifact in artifacts"
              :key="artifact.id"
              class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
            >
              <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px;">
                  <template v-if="artifact.media && artifact.media.path">
                    <img :src="'/storage/' + artifact.media.path"
                         :alt="artifact.title"
                         class="w-100 h-100 object-fit-cover">
                  </template>
                  <template v-else>
                    <div class="text-center p-4">
                      <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                      <p class="text-muted mt-2 mb-0">No Image Available</p>
                    </div>
                  </template>
                </div>
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <h3 class="h4 fw-bold text-dark mb-0">{{ artifact.title }}</h3>
                  </div>
                  <p class="text-muted flex-grow-1">{{ artifact.description }}</p>
                  <div class="mb-3">
                    <small class="text-muted">
                      Era: {{ artifact.era }}
                    </small>
                  </div>
                  <a
                    :href="route('exhibits.show', artifact.id)"
                    class="btn btn-outline-primary mt-3"
                  >
                    View Details
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
  name: 'PublicArtifactsIndex',
  props: {
    artifacts: Array,
  },
  components: {
    AppLayout,
  },
  methods: {
    route(name, params) {
      // Simple route helper for demonstration
      // In a real app, you'd use Ziggy or similar
      const routes = {
        'exhibits.show': `/exhibits/${params}`
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
