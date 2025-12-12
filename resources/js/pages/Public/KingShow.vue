<template>
    <app-layout>
        <div class="container my-5">
            <button onclick="window.location.href='/kings'"
                class="btn btn-outline-primary align-items-center hover-effect mb-4 btn-actions-pane-left">
                <i class="bi bi-arrow-left me-2"></i> Back to Kings
            </button>
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                        <div class="flex-grow-1 mb-3 mb-md-0">
                            <h1 class="h2 fw-bold text-dark mb-2">{{ king.name }}</h1>
                            <p class="text-muted mb-0">{{ king.regnal_name }}</p>
                        </div>
                        <div class="badge bg-primary-subtle text-primary py-2 px-3">
                            {{ king.dynasty?.name || 'Unknown Dynasty' }}
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
                                    <div class="bg-secondary rounded-lg d-flex align-items-center justify-content-center"
                                        style="height: 300px;">
                                        <span v-if="king.portraitMedia" class="text-light">Portrait Image</span>
                                        <span v-else class="text-light">No Image Available</span>
                                    </div>

                                    <div class="mt-4">
                                        <h3 class="h5 fw-bold text-dark mb-3">King Details</h3>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Reign Period</span>
                                                    <span class="fw-medium">
                                                        {{
                                                            king.reign_start_date
                                                                ? new Date(king.reign_start_date).toLocaleDateString()
                                                                : ''
                                                        }}
                                                        -
                                                        {{
                                                            king.reign_end_date
                                                                ? new Date(king.reign_end_date).toLocaleDateString()
                                                                : ''
                                                        }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Born</span>
                                                    <span class="fw-medium">{{ king.birth_year }}</span>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Died</span>
                                                    <span class="fw-medium">{{ king.death_year }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-8">
                                    <div class="ps-md-4">
                                        <h3 class="h4 fw-bold text-dark mb-3">About</h3>
                                        <p class="text-muted mb-4">{{ king.short_bio }}</p>

                                        <h3 class="h4 fw-bold text-dark mb-3">Biography</h3>
                                        <div class="prose text-muted">
                                            <p>{{ king.full_bio }}</p>
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
    name: 'PublicKingShow',
    props: {
        king: Object,
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
</style>
