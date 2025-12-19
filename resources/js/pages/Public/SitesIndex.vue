<template>
  <app-layout>
    <div class="container my-5">
      <div class="row">
        <div class="col-12">
          <h1 class="h2 fw-bold text-dark mb-4">Historical Sites</h1>
          <p class="lead text-muted mb-4">Explore the historical landmarks and sacred sites of the Ijebu people.</p>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="row g-4">
            <div
              v-for="site in sites"
              :key="site.id"
              class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
            >
              <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px;">
                  <template v-if="site.featured_media && site.featured_media.path">
                    <img :src="'/storage/' + site.featured_media.path"
                         :alt="site.name"
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
                    <h3 class="h4 fw-bold text-dark mb-0">{{ site.name }}</h3>
                  </div>
                  <p class="text-muted flex-grow-1">{{ site.description }}</p>
                  <div class="mb-3">
                    <small class="text-muted">
                      Location: {{ site.location || 'Unknown' }}
                    </small>
                  </div>
                  <a
                    :href="route('sites.show', site.id)"
                    class="btn btn-outline-primary mt-3"
                  >
                    Explore Site
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
  name: 'PublicSitesIndex',
  props: {
    sites: Array,
  },
  components: {
    AppLayout,
  },
  methods: {
    route(name, params) {
      // Simple route helper for demonstration
      // In a real app, you'd use Ziggy or similar
      const routes = {
        'sites.show': `/sites/${params}`
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
