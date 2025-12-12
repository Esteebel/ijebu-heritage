<template>
  <app-layout>
    <div class="container my-5">
      <div class="row">
        <div class="col-12">
          <h1 class="h2 fw-bold text-dark mb-4">Upcoming Events</h1>
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
                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                  <span v-if="event.featuredMedia" class="text-light">Event Image</span>
                  <span v-else class="text-light">No Image Available</span>
                </div>
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <h3 class="h4 fw-bold text-dark mb-0">{{ event.title }}</h3>
                  </div>
                  <p class="text-muted flex-grow-1">{{ event.description }}</p>
                  <div class="mb-3">
                    <small class="text-muted">
                      {{ formatDate(event.start_datetime) }} - {{ formatDate(event.end_datetime) }}
                    </small>
                  </div>
                  <a
                    :href="route('events.show', event.id)"
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
  name: 'PublicEventsIndex',
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
        'events.show': `/events/${params}`
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
</style>