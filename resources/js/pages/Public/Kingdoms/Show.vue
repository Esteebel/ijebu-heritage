<template>
  <app-layout>
    <div class="container my-5">
      <button onclick="window.location.href='/kingdoms'"
        class="btn btn-outline-primary align-items-center hover-effect mb-4 btn-actions-pane-left">
        <i class="bi bi-arrow-left me-2"></i> Back to Kingdoms
      </button>

      <div class="row">
        <div class="col-12">
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div class="flex-grow-1 mb-3 mb-md-0">
              <h1 class="h2 fw-bold text-dark mb-2">{{ kingdom.name }}</h1>
              <p class="text-muted mb-0">
                {{ kingdom.start_year }} - {{ kingdom.end_year || 'Present' }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm mb-5">
            <div class="card-body p-4 p-md-5">
              <h3 class="h4 fw-bold text-dark mb-4">About This Kingdom</h3>
              <div class="prose text-muted">
                <p>{{ kingdom.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Kings of this Kingdom -->
      <div class="row mb-5">
        <div class="col-12">
          <h2 class="h3 fw-bold text-dark mb-4">Rulers of {{ kingdom.name }}</h2>
          <div class="row g-4">
            <div
              v-for="king in kingdom.kings"
              :key="king.id"
              class="col-12 col-md-6 col-lg-4"
            >
              <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden"
                  style="height: 250px;">
                  <template v-if="king.portraitMedia && king.portraitMedia.path">
                    <img
                      :src="'/storage/' + king.portraitMedia.path"
                      class="img-fluid w-100 h-100 object-fit-cover"
                      :alt="king.name"
                      style="object-fit: cover;"
                      @click="openImagePreview(king.portraitMedia.path)"
                    >
                  </template>
                  <template v-else>
                    <div class="text-center p-4">
                      <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                      <p class="text-muted mt-2 mb-0">No Image Available</p>
                    </div>
                  </template>
                </div>
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <h3 class="h5 fw-bold text-dark mb-0">{{ king.name }}</h3>
                    <span class="badge bg-primary-subtle text-primary">{{ king.regnal_name }}</span>
                  </div>
                  <p class="text-muted">{{ king.short_bio || 'No biography available.' }}</p>
                  <div class="d-flex justify-content-between text-muted small">
                    <span>
                      {{ king.reign_start_date ? new Date(king.reign_start_date).getFullYear() : '' }} -
                      {{ king.reign_end_date ? new Date(king.reign_end_date).getFullYear() : 'Present' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Image Gallery -->
      <div class="row" v-if="kingdomImages.length > 0">
        <div class="col-12">
          <h2 class="h3 fw-bold text-dark mb-4">Historical Images</h2>
          <div class="row g-3">
            <div
              v-for="(image, index) in kingdomImages"
              :key="index"
              class="col-6 col-md-4 col-lg-3"
            >
              <div class="gallery-item rounded overflow-hidden shadow-sm hover-lift cursor-pointer"
                @click="openImagePreview(image.path)">
                <img
                  :src="'/storage/' + image.path"
                  class="w-100"
                  style="height: 250px; object-fit: cover;"
                  :alt="image.caption || 'Historical Image'"
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" :class="{ 'show d-block': showImagePreview }" tabindex="-1" v-if="showImagePreview">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Image Preview</h5>
            <button type="button" class="btn-close" @click="closeImagePreview"></button>
          </div>
          <div class="modal-body text-center">
            <img
              v-if="currentPreviewImage"
              :src="'/storage/' + currentPreviewImage"
              class="img-fluid"
              :alt="'Preview'"
            >
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade" :class="{ 'show': showImagePreview }" v-if="showImagePreview"></div>
  </app-layout>
</template>

<script>
import AppLayout from '../../../layouts/AppLayout.vue'

export default {
  name: 'PublicKingdomShow',
  props: {
    kingdom: Object,
  },
  components: {
    AppLayout,
  },
  data() {
    return {
      showImagePreview: false,
      currentPreviewImage: null
    }
  },
  computed: {
    kingdomImages() {
      // Collect all images from kings in this kingdom
      const images = [];
      if (this.kingdom.kings) {
        this.kingdom.kings.forEach(king => {
          if (king.portraitMedia && king.portraitMedia.path) {
            images.push(king.portraitMedia);
          }
        });
      }
      return images;
    }
  },
  methods: {
    openImagePreview(imagePath) {
      this.currentPreviewImage = imagePath;
      this.showImagePreview = true;
      document.body.classList.add('modal-open');
    },
    closeImagePreview() {
      this.showImagePreview = false;
      this.currentPreviewImage = null;
      document.body.classList.remove('modal-open');
    }
  }
}
</script>

<style scoped>
/* Hover effect for links */
.hover-effect {
  position: relative;
  transition: all 0.3s ease;
  text-decoration: none;
}

.hover-effect::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0;
  height: 2px;
  background-color: var(--bs-primary);
  transition: width 0.3s ease;
}

.hover-effect:hover {
  color: var(--bs-primary) !important;
  color: navy !important;
}

.hover-effect:hover::after {
  width: 100%;
}

/* Prose styling */
.prose p {
  margin-bottom: 1rem;
  line-height: 1.7;
}

.object-fit-cover {
  object-fit: cover;
}

.cursor-pointer {
  cursor: pointer;
}

.modal {
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-open {
  overflow: hidden;
}
</style>
