<template>
  <app-layout>
    <div class="container my-5">
      <div class="row">
        <div class="col-12">
          <h1 class="h2 fw-bold text-dark mb-4">Historical Events</h1>
          <p class="lead text-muted mb-4">Explore key historical events that shaped the Ijebu people and their culture.</p>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="row g-4">
            <div
              v-for="event in events"
              :key="event.id"
              class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
            >
              <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px;">
                  <template v-if="event.featured_media && event.featured_media.path">
                    <img :src="'/storage/' + event.featured_media.path"
                         :alt="event.title"
                         class="w-100 h-100 object-fit-cover">
                  </template>
                  <template v-else>
                    <div class="text-center p-4">
                      <i class="bi bi-calendar-event text-muted" style="font-size: 3rem;"></i>
                      <p class="text-muted mt-2 mb-0">Historical Event</p>
                    </div>
                  </template>
                </div>
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <h3 class="h4 fw-bold text-dark mb-0">{{ event.title }}</h3>
                  </div>
                  <p class="text-muted flex-grow-1">{{ event.description }}</p>
                  <div class="mb-3">
                    <small class="text-muted">
                      Date: {{ formatDate(event.event_date) }}
                    </small>
                  </div>
                  <a
                    :href="route('historical.events.show', event.id)"
                    class="btn btn-outline-primary mt-3"
                  >
                    Learn More
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
  name: 'PublicHistoricalEventsIndex',
  props: {
    events: Array,
  },
  components: {
    AppLayout,
  },
  methods: {
    route(name, params) {
      // Simple route helper for demonstration
      // In a real app, you'd use Ziggy or similar
      const routes = {
        'historical.events.show': `/historical-events/${params}`
      };
      return routes[name] || '#';
    },
    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString();
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
