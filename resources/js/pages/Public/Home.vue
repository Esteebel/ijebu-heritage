<template>
    <app-layout>
        <!-- Full-width Hero Section with Professional Slider -->
        <div class="full-width-section mt-0">
            <section class="hero-section position-relative overflow-hidden w-100 vw-100 m-0 p-0">
                <!-- Slider Container -->
                <div class="slider-container position-absolute top-0 start-0 w-100 h-100 m-0 p-0">
                    <!-- Slides will be positioned here -->
                    <div v-for="(slide, index) in slides" :key="index"
                        class="slide position-absolute top-0 start-0 w-100 h-100"
                        :class="{ 'active': currentSlide === index }"
                        :style="{ backgroundImage: 'url(' + slide.image + ')', transform: 'translateX(' + (index - currentSlide) * 100 + '%)' }">
                    </div>
                </div>

                <!-- Overlay for better text visibility -->
                <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 mt-0"></div>

                <!-- Content Container -->
                <div class="hero-content position-relative z-3 container py-5 py-md-10 h-100 d-flex align-items-center">
                    <div class="row justify-content-center w-100">
                        <div class="col-12 col-lg-10 text-center">
                            <h1
                                class="display-3 display-md-2 fw-bold text-light mb-4 animate__animated animate__fadeInDown mt-5">
                                Discover the <span class="text-primary">Royal Legacy</span>
                            </h1>
                            <p
                                class="lead text-light opacity-90 mb-5 fs-3 animate__animated animate__fadeInUp animate__delay-1s">
                                Journey through centuries of monarchy, explore magnificent artifacts, and uncover the
                                fascinating stories of kings and queens who shaped history!.
                            </p>
                            <div
                                class="d-flex flex-column flex-md-row justify-content-center gap-3 animate__animated animate__fadeInUp animate__delay-2s">
                                <a href="/exhibits"
                                    class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg hover-lift">
                                    Explore Exhibits
                                </a>
                                <a href="/kingdoms" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold hover-lift">
                                    Explore Kingdoms
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slider Controls -->
                <div
                    class="slider-controls position-absolute bottom-0 start-0 w-100 d-flex justify-content-center pb-4 z-3">
                    <div class="slider-indicators d-flex gap-2">
                        <button v-for="(slide, index) in slides" :key="index"
                            class="indicator-btn rounded-circle border-0" :class="{ 'active': currentSlide === index }"
                            @click="goToSlide(index)"></button>
                    </div>
                </div>
            </section>

            <!-- Container-wrapped Content -->
            <div class="container-fluid p-0">
                <div class="container my-5">
                    <div class="row">
                        <div class="col-12">
                            <!-- Featured Kings Section -->
                            <section class="featured-kings mb-5">
                                <div class="row mb-4">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <h2 class="h2 fw-bold text-dark mb-0">Featured Monarchs</h2>
                                        <a href="/kings"
                                            class="btn btn-outline-primary d-flex align-items-center hover-effect">
                                            View All Kings
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <!-- Featured Kings from Database -->
                                    <template v-if="featuredKings && featuredKings.length > 0">
                                        <div v-for="(king, index) in getDisplayedKings(featuredKings, 3)" :key="index + '-' + king.id"
                                            class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                            :style="{ 'animation-delay': (index * 0.1 + 0.1) + 's' }">
                                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                                                    style="height: 250px;">
                                                    <template v-if="king.portrait_media && king.portrait_media.path">
                                                        <img :src="encodeURI('/storage/' + king.portrait_media.path)"
                                                             :alt="king.name"
                                                             class="w-100 h-100 object-fit-cover"
                                                             @error="handleImageError($event)">
                                                    </template>
                                                    <template v-else>
                                                        <span class="text-light">{{ king.name }}</span>
                                                    </template>
                                                </div>
                                                <div class="card-body d-flex flex-column">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <h3 class="h4 fw-bold text-dark mb-0">{{ king.name }}</h3>
                                                        <span class="badge" :class="{
                                                            'bg-primary-subtle text-primary': king.dynasty && king.dynasty.name && king.dynasty.name.includes('Tudor'),
                                                            'bg-success-subtle text-success': king.dynasty && king.dynasty.name && king.dynasty.name.includes('Stuart'),
                                                            'bg-warning-subtle text-warning': king.dynasty && king.dynasty.name && king.dynasty.name.includes('York')
                                                        }">
                                                            {{ king.dynasty ? king.dynasty.name : 'Unknown Dynasty' }}
                                                        </span>
                                                    </div>
                                                    <p class="text-muted flex-grow-1">{{ king.short_bio }}</p>
                                                    <a :href="route('kings.show', king.id)"
                                                        class="btn btn-outline-primary mt-3">
                                                        Read Biography
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <!-- Fallback content when no featured kings -->
                                        <div class="col-12">
                                            <p class="text-muted text-center">No featured kings available at the moment.</p>
                                        </div>
                                    </template>
                                </div>
                            </section>

                            <!-- Gallery Section -->
                            <section class="gallery-section mb-5">
                                <div class="row mb-4">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <h2 class="h2 fw-bold text-dark mb-0">Gallery</h2>
                                        <a href="/gallery"
                                            class="btn btn-outline-primary d-flex align-items-center hover-effect">
                                            View Gallery
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <!-- Gallery Items from Database -->
                                    <template v-if="galleryItems && galleryItems.length > 0">
                                        <div v-for="(item, index) in galleryItems" :key="item.id"
                                            class="col-6 col-md-4 col-lg-3">
                                            <div class="gallery-item rounded overflow-hidden shadow-sm hover-lift">
                                                <template v-if="item.media && item.media.path">
                                                    <img :src="encodeURI('/storage/' + item.media.path)"
                                                        class="w-100" style="height: 200px; object-fit: cover;"
                                                        :alt="item.title || 'Gallery Item'"
                                                        @error="handleImageError($event)">
                                                </template>
                                                <template v-else>
                                                    <div class="bg-secondary w-100 d-flex align-items-center justify-content-center"
                                                        style="height: 200px;">
                                                        <span class="text-light">No Image</span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <!-- Fallback gallery items -->
                                        <div v-for="index in 8" :key="index" class="col-6 col-md-4 col-lg-3">
                                            <div class="gallery-item rounded overflow-hidden shadow-sm hover-lift">
                                                <div class="bg-secondary w-100 d-flex align-items-center justify-content-center"
                                                    style="height: 200px;">
                                                    <span class="text-light">Gallery Item {{ index }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </section>

                            <!-- Kingdoms Section -->
                            <section class="kingdoms-section mb-5">
                                <div class="row mb-4">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <h2 class="h2 fw-bold text-dark mb-0">Kingdoms & Dynasties</h2>
                                        <a href="/kingdoms"
                                            class="btn btn-outline-primary d-flex align-items-center hover-effect">
                                            View All Kingdoms
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <!-- Kingdoms from Database -->
                                    <template v-if="featuredKingdoms && featuredKingdoms.length > 0">
                                        <div v-for="(kingdom, index) in featuredKingdoms" :key="kingdom.id"
                                            class="col-12 col-md-6 col-lg-3">
                                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                                    style="height: 150px;">
                                                    <div class="text-center p-3">
                                                        <i class="bi bi-building text-muted" style="font-size: 3rem;"></i>
                                                        <p class="text-muted mt-2 mb-0">{{ kingdom.name }}</p>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h3 class="h5 fw-bold text-dark mb-3">{{ kingdom.name }}</h3>
                                                    <p class="text-muted small mb-3">{{ kingdom.kings_count }} Kings</p>
                                                    <a :href="'/kingdoms/' + kingdom.id" class="btn btn-outline-primary btn-sm">Explore</a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <!-- Fallback content -->
                                        <div v-for="index in 4" :key="index" class="col-12 col-md-6 col-lg-3">
                                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                                    style="height: 150px;">
                                                    <div class="text-center p-3">
                                                        <i class="bi bi-building text-muted" style="font-size: 3rem;"></i>
                                                        <p class="text-muted mt-2 mb-0">Kingdom {{ index }}</p>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h3 class="h5 fw-bold text-dark mb-3">Kingdom {{ index }}</h3>
                                                    <p class="text-muted small mb-3">0 Kings</p>
                                                    <a href="/kingdoms" class="btn btn-outline-primary btn-sm">Explore</a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </section>

                            <!-- Current Kings Section -->
                            <section class="current-kings-section mb-5">
                                <div class="row mb-4">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <h2 class="h2 fw-bold text-dark mb-0">Current Kings</h2>
                                        <a href="/kings"
                                            class="btn btn-outline-primary d-flex align-items-center hover-effect">
                                            View All Kings
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <!-- Current Kings from Database -->
                                    <template v-if="currentKings && currentKings.length > 0">
                                        <div v-for="(king, index) in currentKings" :key="king.id"
                                            class="col-12 col-md-6 col-lg-4">
                                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                                    style="height: 250px;">
                                                    <template v-if="king.portrait_media && king.portrait_media.path">
                                                        <img :src="encodeURI('/storage/' + king.portrait_media.path)"
                                                                :alt="king.name"
                                                                class="w-100 h-100 object-fit-cover"
                                                                @error="handleImageError($event)">
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
                                                        <span class="badge bg-success-subtle text-success">{{ king.dynasty ? king.dynasty.name : 'Unknown Dynasty' }}</span>
                                                    </div>
                                                    <p class="text-muted">{{ king.short_bio || 'No biography available.' }}</p>
                                                    <a :href="route('kings.show', king.id)" class="btn btn-outline-primary btn-sm">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <!-- Fallback content -->
                                        <div v-for="index in 3" :key="index" class="col-12 col-md-6 col-lg-4">
                                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                                    style="height: 200px;">
                                                    <div class="text-center p-4">
                                                        <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                                                        <p class="text-muted mt-2 mb-0">No Image Available</p>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <h3 class="h5 fw-bold text-dark mb-0">Current King {{ index }}</h3>
                                                        <span class="badge bg-success-subtle text-success">Unknown Dynasty</span>
                                                    </div>
                                                    <p class="text-muted">Biography not available at the moment.</p>
                                                    <a href="/kings" class="btn btn-outline-primary btn-sm">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </section>

                            <!-- Past Kings Section -->
                            <section class="past-kings-section mb-5">
                                <div class="row mb-4">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <h2 class="h2 fw-bold text-dark mb-0">Past Kings</h2>
                                        <a href="/kings"
                                            class="btn btn-outline-primary d-flex align-items-center hover-effect">
                                            View All Kings
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <!-- Past Kings from Database -->
                                    <template v-if="pastKings && pastKings.length > 0">
                                        <div v-for="(king, index) in pastKings" :key="king.id"
                                            class="col-12 col-md-6 col-lg-4">
                                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                                    style="height: 250px;">
                                                    <template v-if="king.portrait_media && king.portrait_media.path">
                                                        <img :src="encodeURI('/storage/' + king.portrait_media.path)"
                                                                :alt="king.name"
                                                                class="w-100 h-100 object-fit-cover"
                                                                @error="handleImageError($event)">
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
                                                        <span class="badge bg-primary-subtle text-primary">{{ king.dynasty ? king.dynasty.name : 'Unknown Dynasty' }}</span>
                                                    </div>
                                                    <p class="text-muted">{{ king.short_bio || 'No biography available.' }}</p>
                                                    <a :href="route('kings.show', king.id)" class="btn btn-outline-primary btn-sm">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <!-- Fallback content -->
                                        <div v-for="index in 3" :key="index" class="col-12 col-md-6 col-lg-4">
                                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                                    style="height: 200px;">
                                                    <div class="text-center p-4">
                                                        <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                                                        <p class="text-muted mt-2 mb-0">No Image Available</p>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <h3 class="h5 fw-bold text-dark mb-0">Past King {{ index }}</h3>
                                                        <span class="badge bg-primary-subtle text-primary">Unknown Dynasty</span>
                                                    </div>
                                                    <p class="text-muted">Biography not available at the moment.</p>
                                                    <a href="/kings" class="btn btn-outline-primary btn-sm">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </section>

                            <!-- Upcoming Events Section -->
                            <section class="upcoming-events bg-light rounded-4 p-4 p-md-5 mb-5">
                                <div class="row mb-4">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <h2 class="h2 fw-bold text-dark mb-0">Upcoming Events</h2>
                                        <a href="/events"
                                            class="btn btn-outline-primary d-flex align-items-center hover-effect">
                                            View All Events
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <!-- Events from Database -->
                                    <template v-if="upcomingEvents && upcomingEvents.length > 0">
                                        <div v-for="(event, index) in upcomingEvents" :key="event.id"
                                            class="col-12 col-lg-6">
                                            <div class="card border-start border-4 border-primary shadow-sm h-100">
                                                <div class="row g-0">
                                                    <div class="col-md-4">
                                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden h-100">
                                                            <template v-if="event.featured_media && event.featured_media.path">
                                                                <img :src="encodeURI('/storage/' + event.featured_media.path)"
                                                                    class="w-100 h-100 object-fit-cover"
                                                                    :alt="event.title"
                                                                    @error="handleImageError($event)">
                                                            </template>
                                                            <template v-else>
                                                                <div class="text-center p-3">
                                                                    <i class="bi bi-calendar-event text-muted" style="font-size: 2rem;"></i>
                                                                    <p class="text-muted mt-2 mb-0 small">No Image</p>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                                <h3 class="h4 fw-bold text-dark mb-0">{{ event.title }}</h3>
                                                                <span class="text-muted small">{{ formatDateRange(event.start_datetime, event.end_datetime) }}</span>
                                                            </div>
                                                            <p class="text-muted mb-4">{{ event.description || 'No description available.' }}</p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-muted small">{{ event.location || 'Location TBD' }}</span>
                                                                <a :href="route('events.show', event.id)" class="btn btn-outline-primary btn-sm">Learn More</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <!-- Fallback content -->
                                        <div class="col-12">
                                            <p class="text-muted text-center">No upcoming events scheduled at this time.</p>
                                        </div>
                                    </template>
                                </div>
                            </section>

                            <!-- Call to Action Section -->
                            <section class="cta-section bg-gradient rounded-4 p-5 text-center">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-lg-8">
                                        <h2 class="display-5 fw-bold text-dark mb-4">Plan Your Visit Today</h2>
                                        <p class="lead text-dark opacity-75 mb-5 fs-3">
                                            Experience centuries of royal history through our interactive exhibits and
                                            guided tours.
                                        </p>
                                        <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                                            <a href="/tickets"
                                                class="btn btn-dark btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg hover-lift">
                                                Get Tickets
                                            </a>
                                            <a href="/virtual-tour"
                                                class="btn btn-outline-dark btn-lg px-5 py-3 rounded-pill fw-bold hover-lift">
                                                Virtual Tour
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </section>
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
    name: 'Home',
    props: {
        featuredKings: {
            type: Array,
            default: () => []
        },
        galleryItems: {
            type: Array,
            default: () => []
        },
        currentKings: {
            type: Array,
            default: () => []
        },
        pastKings: {
            type: Array,
            default: () => []
        },
        upcomingEvents: {
            type: Array,
            default: () => []
        },
        featuredKingdoms: {
            type: Array,
            default: () => []
        },
    },
    components: {
        AppLayout,
    },
    data() {
        return {
            currentSlide: 0,
            slides: [
                {
                    image: '/storage/media/images/farouq-hourse-ojudeoba.jpeg'
                },
                {
                    image: '/storage/media/images/Oba-Sikiru-Kayode-Adetona..jpeg'
                },
                {
                    image: '/storage/media/images/Culture-Colour-and-Heritage-on-display-at-OjudeOba2025.-1.jpg'
                },
                   {
                    image: '/storage/media/images/men-ojudeoba25.jpg'
                },
                   {
                    image: '/storage/media/images/regberegb-ojudeoba25.png'
                },
                  {
                    image: '/storage/media/images/Farouq-Oreagba-ojudeoba25.jpg'
                },


            ]
        }
    },
    mounted() {
        this.startSlider();
    },
    methods: {
        startSlider() {
            setInterval(() => {
                this.nextSlide();
            }, 5000); // Change slide every 5 seconds
        },
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        },
        goToSlide(index) {
            this.currentSlide = index;
        },
        handleImageError(event) {
            // When an image fails to load, replace it with the fallback content
            const imgElement = event.target;
            const cardImgTop = imgElement.closest('.card-img-top');

            if (cardImgTop) {
                // Hide the broken image
                imgElement.style.display = 'none';

                // Check if fallback already exists to prevent duplicates
                if (!cardImgTop.querySelector('.image-fallback')) {
                    // Create fallback content
                    const fallbackDiv = document.createElement('div');
                    fallbackDiv.className = 'image-fallback text-center p-4';
                    fallbackDiv.innerHTML = `
                        <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                        <p class="text-muted mt-2 mb-0">No Image Available</p>
                    `;
                    cardImgTop.appendChild(fallbackDiv);
                }
            }
        },
        route(name, params) {
            // Simple route helper for demonstration
            // In a real app, you'd use Ziggy or similar
            if (name === 'kings.show' && params) {
                return `/kings/${params}`;
            }
            if (name === 'events.show' && params) {
                return `/events/${params}`;
            }
            return '#';
        },
        getDisplayedKings(kings, limit) {
            // If we have fewer kings than the limit, duplicate some to fill the space
            if (kings.length >= limit) {
                return kings.slice(0, limit);
            }

            // Duplicate kings to reach the desired limit
            const displayedKings = [];
            for (let i = 0; i < limit; i++) {
                const kingIndex = i % kings.length;
                displayedKings.push(kings[kingIndex]);
            }
            return displayedKings;
        },
        getInitials(name) {
            if (!name) return 'PK';
            const names = name.split(' ');
            let initials = names[0].charAt(0);
            if (names.length > 1) {
                initials += names[names.length - 1].charAt(0);
            }
            return initials.toUpperCase();
        },
        getReignPeriod(king) {
            if (king.reign_start_date && king.reign_end_date) {
                const startYear = new Date(king.reign_start_date).getFullYear();
                const endYear = new Date(king.reign_end_date).getFullYear();
                return `${startYear}-${endYear}`;
            }
            return 'Unknown Period';
        },
        formatDateRange(start, end) {
            if (!start || !end) return 'Date TBD';

            const startDate = new Date(start);
            const endDate = new Date(end);

            const startFormatted = startDate.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });

            const endFormatted = endDate.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });

            return `${startFormatted} - ${endFormatted}`;
        }
    }
}
</script>

<style scoped>
/* Image fallback */
.image-fallback {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}

/* Full width section to break out of container */
.full-width-section {
    margin-left: calc(50% - 50vw);
    margin-right: calc(50% - 50vw);
    width: 100vw;
}

/* Hero Section Styles */
.hero-section {
    min-height: 100vh;
    background-color: #000;
}

/* Slider Styles */
.slider-container {
    overflow: hidden;
}

.slide {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    transition: transform 1s ease-in-out;
}

/* Overlay for better text visibility */
.hero-overlay {
    background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2));
}

/* Content Styles */
.hero-content {
    backdrop-filter: blur(2px);
}

/* Slider Controls */
.slider-controls {
    pointer-events: none;
}

.slider-indicators {
    pointer-events: auto;
}

.indicator-btn {
    width: 12px;
    height: 12px;
    background-color: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: all 0.3s ease;
}

.indicator-btn.active {
    background-color: #fff;
    transform: scale(1.2);
}

.indicator-btn:hover:not(.active) {
    background-color: rgba(255, 255, 255, 0.8);
    transform: scale(1.1);
}

/* Hover lift effect */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15) !important;
}

/* Hover effect for links */
.hover-effect {
    position: relative;
    transition: all 0.3s ease;
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
}

.hover-effect:hover::after {
    width: 100%;
}

/* Background gradient */
.bg-gradient {
    background: linear-gradient(135deg, #B08B4F 0%, #7DB118 100%);
}

/* Gallery Items */
.gallery-item {
    transition: all 0.3s ease;
}

.gallery-item:hover {
    transform: scale(1.03);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
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

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate__fadeInDown {
    animation: fadeInDown 0.8s ease-out forwards;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-content {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .hero-section h1 {
        font-size: 2rem;
    }

    .hero-section .lead {
        font-size: 1.0rem;
    }

    .full-width-section {
        margin-left: -15px;
        margin-right: -15px;
        width: calc(100% + 30px);
    }
}
</style>
