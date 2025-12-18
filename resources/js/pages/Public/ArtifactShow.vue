<template>
    <app-layout>
        <div class="container my-5">
            <button onclick="window.location.href='/exhibits'"
                class="btn btn-outline-primary align-items-center hover-effect mb-4 btn-actions-pane-left">
                <i class="bi bi-arrow-left me-2"></i> Back to Exhibits
            </button>
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                        <div class="flex-grow-1 mb-3 mb-md-0">
                            <h1 class="h2 fw-bold text-dark mb-2">{{ artifact.title }}</h1>
                            <p class="text-muted mb-0">{{ artifact.era }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5">
                            <div class="row">
                                <div class="col-12 col-md-4 mb-4 mb-md-0">
                                    <div class="bg-light rounded-lg d-flex align-items-center justify-content-center overflow-hidden"
                                        style="height: 300px;">
                                        <template v-if="artifact.media && artifact.media.path">
                                            <img :src="'/storage/' + artifact.media.path"
                                                 :alt="artifact.title"
                                                 class="w-100 h-100 object-fit-cover">
                                        </template>
                                        <template v-else>
                                            <div class="text-center p-4">
                                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                                <p class="text-muted mt-3 mb-0">No Image Available</p>
                                            </div>
                                        </template>
                                    </div>

                                    <div class="mt-4">
                                        <h3 class="h5 fw-bold text-dark mb-3">Artifact Details</h3>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Accession Number</span>
                                                    <span class="fw-medium">{{ artifact.accession_number }}</span>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Origin Location</span>
                                                    <span class="fw-medium">{{ artifact.origin_location }}</span>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Era</span>
                                                    <span class="fw-medium">{{ artifact.era }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-8">
                                    <div class="ps-md-4">
                                        <h3 class="h4 fw-bold text-dark mb-3">Description</h3>
                                        <div class="prose text-muted">
                                            <p>{{ artifact.description }}</p>
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
    name: 'PublicArtifactShow',
    props: {
        artifact: Object,
    },
    components: {
        AppLayout,
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
</style>
