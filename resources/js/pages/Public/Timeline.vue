<template>
  <app-layout>
    <div class="container my-5">
      <div class="row">
        <div class="col-12">
          <h1 class="h2 fw-bold text-dark mb-4">Royal Timeline</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
              <div class="timeline">
                <div
                  v-for="(king, index) in kings"
                  :key="king.id"
                  class="timeline-item mb-5"
                >
                  <div class="row">
                    <div class="col-12 col-md-1 d-flex justify-content-center">
                      <div class="timeline-badge rounded-circle d-flex align-items-center justify-content-center"
                           :class="index % 2 === 0 ? 'bg-primary' : 'bg-secondary'">
                        <i class="bi bi-person-fill text-white"></i>
                      </div>
                      <div v-if="index !== kings.length - 1" class="timeline-line"></div>
                    </div>
                    <div class="col-12 col-md-11">
                      <div class="card border-0 shadow-sm h-100 hover-lift">
                        <div class="card-body">
                          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                            <h3 class="h4 fw-bold text-dark mb-2 mb-md-0">{{ king.name }}</h3>
                            <span class="badge" :class="index % 2 === 0 ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary'">
                              {{ king.dynasty ? king.dynasty.name : 'Unknown Dynasty' }}
                            </span>
                          </div>
                          <p class="text-muted mb-2">
                            <strong>{{ king.regnal_name }}</strong>
                          </p>
                          <p class="text-muted mb-0">
                            Reign:
                            <span class="fw-medium">
                              {{ king.reign_start_date ? new Date(king.reign_start_date).getFullYear() : '' }}
                              -
                              {{ king.reign_end_date ? new Date(king.reign_end_date).getFullYear() : '' }}
                            </span>
                          </p>
                        </div>
                      </div>
                    </div>
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
import AppLayout from '../../layouts/AppLayout.vue'

export default {
  name: 'PublicTimeline',
  props: {
    kings: Array,
  },
  components: {
    AppLayout,
  },
}
</script>

<style scoped>
.timeline {
  position: relative;
  padding-left: 1rem;
}

.timeline-item {
  position: relative;
}

.timeline-badge {
  width: 40px;
  height: 40px;
  z-index: 2;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.timeline-line {
  position: absolute;
  top: 40px;
  left: 50%;
  transform: translateX(-50%);
  width: 2px;
  height: calc(100% + 20px);
  background-color: #dee2e6;
}

/* Hover lift effect */
.hover-lift {
  transition: all 0.3s ease;
}

.hover-lift:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .timeline {
    padding-left: 0;
  }

  .timeline-line {
    left: 20px;
    transform: none;
  }
}
</style>
