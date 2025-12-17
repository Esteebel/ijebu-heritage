<template>
    <app-layout>
        <div class="container my-5">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Get Tickets</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark mb-3">Get Your Tickets</h1>
                    <p class="lead text-muted">
                        Plan your visit to the Kingdom Museum and experience centuries of royal history
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="h3 fw-bold text-dark mb-4">Ticket Options</h2>

                            <div class="row g-4 mb-5">
                                <div v-for="(ticket, index) in tickets" :key="ticket.id" class="col-12 col-md-6">
                                    <div class="card h-100" :class="{ 'border-primary border-2': ticket.type === 'general' }">
                                        <div class="card-body">
                                            <h3 class="h4 fw-bold" :class="{ 'text-primary': ticket.type === 'general', 'text-dark': ticket.type !== 'general' }">{{ ticket.name }}</h3>
                                            <div class="price-display mb-3">
                                                <span class="display-5 fw-bold text-dark">${{ ticket.price }}</span>
                                                <span class="text-muted" v-if="ticket.type === 'family'">up to 4 people</span>
                                                <span class="text-muted" v-else>per person</span>
                                            </div>
                                            <p class="text-muted mb-3">{{ ticket.description }}</p>
                                            <ul class="list-unstyled mb-4">
                                                <li v-for="(benefit, bIndex) in ticket.benefits" :key="bIndex" class="mb-2">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>{{ benefit }}
                                                </li>
                                            </ul>
                                            <button class="btn" :class="{ 'btn-primary': ticket.type === 'general', 'btn-outline-primary': ticket.type !== 'general' }" w-100>Select Tickets</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-12">
                                    <h3 class="h4 fw-bold text-dark mb-4">Visit Information</h3>
                                    <div class="row g-4">
                                        <div class="col-12 col-md-6">
                                            <h4 class="h5 fw-bold text-dark mb-3">Hours</h4>
                                            <ul class="list-unstyled">
                                                <li class="d-flex justify-content-between py-2 border-bottom">
                                                    <span>Monday - Thursday</span>
                                                    <span class="fw-medium">9:00 AM - 5:00 PM</span>
                                                </li>
                                                <li class="d-flex justify-content-between py-2 border-bottom">
                                                    <span>Friday - Saturday</span>
                                                    <span class="fw-medium">9:00 AM - 7:00 PM</span>
                                                </li>
                                                <li class="d-flex justify-content-between py-2 border-bottom">
                                                    <span>Sunday</span>
                                                    <span class="fw-medium">10:00 AM - 5:00 PM</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <h4 class="h5 fw-bold text-dark mb-3">Location</h4>
                                            <address class="mb-0">
                                                <strong>Kingdom Museum</strong><br>
                                                123 Royal Avenue<br>
                                                Kingdom City, KC 12345<br>
                                                <abbr title="Phone">P:</abbr> (123) 456-7890
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <h3 class="h4 fw-bold text-dark mb-3">Need Assistance?</h3>
                                    <p class="mb-4">Contact our visitor services team for ticket inquiries and special accommodations.</p>
                                    <div class="d-flex flex-wrap justify-content-center gap-3">
                                        <a href="tel:+11234567890" class="btn btn-outline-secondary">
                                            <i class="bi bi-telephone me-2"></i>Call Us
                                        </a>
                                        <a href="mailto:tickets@kingdommuseum.org" class="btn btn-outline-secondary">
                                            <i class="bi bi-envelope me-2"></i>Email Us
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
import AppLayout from '../../layouts/AppLayout.vue'

export default {
    name: 'Tickets',
    props: {
        tickets: {
            type: Array,
            default: () => []
        }
    },
    components: {
        AppLayout,
    }
}
</script>

<style scoped>
.price-display {
    min-height: 60px;
}
</style>
