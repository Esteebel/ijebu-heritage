<template>
  <div class="min-h-screen bg-body">
    <!-- Animated Header -->
    <header class="bg-navbar-footer shadow-lg sticky-top">
      <div class="container">
        <div class="row align-items-center py-3">
          <div class="col-12 col-md-4 mb-3 mb-md-0 animate__animated animate__fadeInDown">
            <div class="d-flex align-items-center">
              <a href="/" class="d-flex align-items-center text-decoration-none">
                <img src="/storage/media/images/Ijebu-heritage-logo-removebg-preview.png" alt="Ijebu Heritage Logo" class="me-3" style="width: 100px; height: 80px; object-fit: contain;">
                <h1 class="h2 m-0 fw-bold text-light">Ijebu Heritage</h1>
              </a>
            </div>
          </div>

          <!-- Navigation -->
          <div class="col-12 col-md-8">
            <nav class="d-flex justify-content-md-end">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link text-light fw-medium mx-1 mx-md-2 hover-effect" href="/">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light fw-medium mx-1 mx-md-2 hover-effect" href="/historical-events">Timeline</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light fw-medium mx-1 mx-md-2 hover-effect" href="/kings">Kings</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light fw-medium mx-1 mx-md-2 hover-effect" href="/kingdoms">Kingdoms</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link text-light fw-medium mx-1 mx-md-2 hover-effect dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Culture
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/festivals">Festivals</a></li>
                    <li><a class="dropdown-item" href="/foods">Cuisine</a></li>
                    <li><a class="dropdown-item" href="/language">Language</a></li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light fw-medium mx-1 mx-md-2 hover-effect" href="/sites">Sites</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light fw-medium mx-1 mx-md-2 hover-effect" href="/gallery">Gallery</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light fw-medium mx-1 mx-md-2 hover-effect" href="/photo-archives">Photo Archives</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link text-light fw-medium mx-1 mx-md-2 hover-effect dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Community
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/personalities">Notable Figures</a></li>
                    <li><a class="dropdown-item" href="/oral-histories">Oral Histories</a></li>
                    <li><a class="dropdown-item" href="/diaspora">Diaspora</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="container">
      <div class="row">
        <div class="col-12">
          <transition name="fade" mode="out-in">
            <slot />
          </transition>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-navbar-footer text-light py-5 mt-auto">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-4 mb-4 mb-md-0">
            <div class="d-flex align-items-center mb-3">
              <a href="/" class="d-flex align-items-center text-decoration-none">
                <img src="/storage/media/images/Ijebu-heritage-logo-removebg-preview.png" alt="Ijebu Heritage Logo" class="me-3" style="width: 100px; height: 100px; object-fit: contain;">
                <h3 class="h4 fw-bold text-light mb-0">Ijebu Heritage</h3>
              </a>
            </div>
            <p class="text-light opacity-75">Preserving the rich history of royal kingdoms through interactive exhibits and artifacts.</p>
          </div>
          <div class="col-12 col-md-4 mb-4 mb-md-0">
            <h4 class="h5 fw-semibold mb-3">Quick Links</h4>
            <ul class="list-unstyled">
              <li class="mb-2"><a href="/" class="text-light opacity-75 text-decoration-none hover-effect">Home</a></li>
              <li class="mb-2"><a href="/historical-events" class="text-light opacity-75 text-decoration-none hover-effect">Timeline</a></li>
              <li class="mb-2"><a href="/kings" class="text-light opacity-75 text-decoration-none hover-effect">Kings & Queens</a></li>
              <li class="mb-2"><a href="/kingdoms" class="text-light opacity-75 text-decoration-none hover-effect">Kingdoms & Dynasties</a></li>
              <li class="mb-2"><a href="/festivals" class="text-light opacity-75 text-decoration-none hover-effect">Festivals</a></li>
              <li class="mb-2"><a href="/foods" class="text-light opacity-75 text-decoration-none hover-effect">Cuisine</a></li>
              <li class="mb-2"><a href="/sites" class="text-light opacity-75 text-decoration-none hover-effect">Historical Sites</a></li>
              <li class="mb-2"><a href="/gallery" class="text-light opacity-75 text-decoration-none hover-effect">Artifact Gallery</a></li>
              <li class="mb-2"><a href="/personalities" class="text-light opacity-75 text-decoration-none hover-effect">Notable Figures</a></li>
              <li class="mb-2"><a href="/oral-histories" class="text-light opacity-75 text-decoration-none hover-effect">Oral Histories</a></li>
              <li class="mb-2"><a href="/diaspora" class="text-light opacity-75 text-decoration-none hover-effect">Diaspora</a></li>
              <li class="mb-2"><a href="/language" class="text-light opacity-75 text-decoration-none hover-effect">Language</a></li>
              <li class="mb-2"><a href="/photo-archives" class="text-light opacity-75 text-decoration-none hover-effect">Photo Archives</a></li>
              <li class="mb-2"><a href="/olu-corner" class="text-light opacity-75 text-decoration-none hover-effect">Olu's Corner</a></li>
            </ul>
          </div>
          <div class="col-12 col-md-4">
            <h4 class="h5 fw-semibold mb-3">Contact Us</h4>
            <address class="text-light opacity-75 fst-normal">
              123 Royal Avenue<br>
              Kingdom City, KC 12345<br>
              Email: info@kingdommuseum.org<br>
              Phone: (123) 456-7890
            </address>
          </div>
        </div>
        <hr class="my-4 opacity-25">
        <div class="row">
          <div class="col-12 text-center text-light opacity-50">
            <p class="mb-0">&copy; {{ new Date().getFullYear() }} Ijebu Heritage. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'AppLayout'
}
</script>

<style scoped>
/* Custom Styles */
.bg-navbar-footer {
  background-color: #B08B4F !important;
}

.sticky-top {
  position: sticky;
  top: 0;
  z-index: 1020;
  transition: all 0.3s ease;
}

.sticky-top:hover {
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.hover-effect {
  position: relative;
  transition: all 0.3s ease;
}

.hover-effect::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 0;
  height: 2px;
  background-color: #ffffff;
  transition: all 0.3s ease;
  transform: translateX(-50%);
}

.hover-effect:hover {
  color: #ffffff !important;
}

.hover-effect:hover::after {
  width: 70%;
}

/* Transition Effects */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Animations */
@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate__fadeInDown {
  animation: fadeInDown 0.5s ease-out;
}

/* Responsive Navigation Adjustments */
@media (min-width: 768px) and (max-width: 991px) {
  .nav-link {
    font-size: 0.9rem;
    padding-left: 0.25rem;
    padding-right: 0.25rem;
  }

  .mx-1 {
    margin-left: 0.15rem !important;
    margin-right: 0.15rem !important;
  }

  .mx-md-2 {
    margin-left: 0.25rem !important;
    margin-right: 0.25rem !important;
  }
}

@media (max-width: 767px) {
  .navbar-nav .nav-link {
    font-size: 0.85rem;
  }
}
</style>
