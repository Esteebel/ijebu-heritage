<template>
    <app-layout>
        <div class="container my-5">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Virtual Tour</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark mb-3">Virtual Tour</h1>
                    <p class="lead text-muted">
                        Explore the Kingdom Museum from anywhere in the world with our immersive virtual experience
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card shadow-sm border-0 mb-5">
                        <div class="card-body p-0">
                            <!-- Virtual tour placeholder -->
                            <div class="ratio ratio-16x9 bg-secondary d-flex align-items-center justify-content-center">
                                <div class="text-center text-light">
                                    <i class="bi bi-camera-video display-1 mb-3"></i>
                                    <h3 class="h4 text-light">Interactive Virtual Tour</h3>
                                    <p class="mb-4">Explore our galleries and exhibits in 360°</p>
                                    <button class="btn btn-primary btn-lg">
                                        <i class="bi bi-play-circle me-2"></i>Start Virtual Tour
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-12 col-md-4">
                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                <div class="card-body text-center">
                                    <div class="icon-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                                        <i class="bi bi-building display-5"></i>
                                    </div>
                                    <h3 class="h5 fw-bold text-dark mb-3">Main Gallery</h3>
                                    <p class="text-muted">
                                        Explore our extensive collection of royal artifacts and historical items.
                                    </p>
                                    <a href="#" class="btn btn-outline-primary">Explore Gallery</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                <div class="card-body text-center">
                                    <div class="icon-circle bg-success bg-opacity-10 text-success mx-auto mb-3">
                                        <i class="bi bi-clock-history display-5"></i>
                                    </div>
                                    <h3 class="h5 fw-bold text-dark mb-3">Historical Timeline</h3>
                                    <p class="text-muted">
                                        Journey through centuries of royal history with our interactive exhibits.
                                    </p>
                                    <a href="/timeline" class="btn btn-outline-primary">View Timeline</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                <div class="card-body text-center">
                                    <div class="icon-circle bg-warning bg-opacity-10 text-warning mx-auto mb-3">
                                        <i class="bi bi-star display-5"></i>
                                    </div>
                                    <h3 class="h5 fw-bold text-dark mb-3">Special Exhibits</h3>
                                    <p class="text-muted">
                                        Discover our rotating special exhibitions featuring rare artifacts.
                                    </p>
                                    <a href="/exhibits" class="btn btn-outline-primary">View Exhibits</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 bg-light">
                        <div class="card-body p-4 p-md-5">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-8 mb-4 mb-md-0">
                                    <h3 class="h4 fw-bold text-dark mb-2">Want to Visit in Person?</h3>
                                    <p class="mb-0">
                                        Book your tickets today to experience the Kingdom Museum in person with our world-class exhibits and guided tours.
                                    </p>
                                </div>
                                <div class="col-12 col-md-4 text-md-end">
                                    <a href="/tickets" class="btn btn-primary btn-lg">
                                        Get Tickets
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
    name: 'VirtualTour',
    components: {
        AppLayout,
    },
}
</script>

<style scoped>
.icon-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15) !important;
}
</style>
