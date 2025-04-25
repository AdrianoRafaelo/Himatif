<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda</title>
    <link rel="icon" href="{{ asset('img/logo-himatif-removebg.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Font Awesome for social icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    
</head>

<body>
    <!-- Social Bar -->
    <div class="social-bar py-2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-none d-md-block">
                    <span class="text-secondary"><i class="far fa-envelope me-2"></i>himatif@example.com</span>
                </div>
                <div class="social-icons d-flex gap-3">
                    <a href="{{ route('login') }}" class="text-secondary" aria-label="Login"><i class="fas fa-sign-in-alt"></i></a>
                    <a href="#" class="text-secondary" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-secondary" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-secondary" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-secondary" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-secondary" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark navbar-custom py-0">
        <div class="container flex-column">
            <!-- Logo -->
            <div class="text-center my-3">
                <img src="{{ asset('img/logo-himatif-removebg.png') }}" alt="Logo HIMATIF" class="img-fluid" style="height: 120px; width: auto;">
            </div>
            

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto py-2">
                    <li class="nav-item mx-2"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="#">Acara</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="#">Galeri</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="#">Berita</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="#">Keuangan</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="#">Visi Misi</a></li>

                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" id="prokerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Proker
                            <span class="dropdown-arrow"><i class="fas fa-chevron-down"></i></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="prokerDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-alt me-2"></i>Proker 2023</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-alt me-2"></i>Proker 2022</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-alt me-2"></i>Proker 2021</a></li>
                        </ul>
                    </li>

                    <li class="nav-item mx-2"><a class="nav-link" href="#">STRUKTUR ORGANISASI</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    @if(Route::currentRouteName() == 'home')
    <div class="carousel-container">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <!-- Carousel Items -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="carousel-overlay"></div>
                    <img src="{{ asset('img/carousel-1.jpg') }}" class="d-block w-100" alt="Campus Event">
                    <div class="carousel-caption">
                        <div class="caption-content">
                            <h2>Lorem Ipsum Dolor Sit</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <span class="highlight">Sed do eiusmod tempor</span> incididunt ut labore et dolore magna aliqua.</p>
                            <a href="#" class="btn mt-3">Discover</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-overlay"></div>
                    <img src="{{ asset('img/carousel-2.jpg') }}" class="d-block w-100" alt="Workshop">
                    <div class="carousel-caption">
                        <div class="caption-content">
                            <h2>Ut Enim Ad Minim</h2>
                            <p>Ut enim ad minim veniam, quis nostrud exercitation <span class="highlight">ullamco laboris</span> nisi ut aliquip ex ea commodo consequat.</p>
                            <a href="#" class="btn mt-3">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-overlay"></div>
                    <img src="{{ asset('img/carousel-3.jpg') }}" class="d-block w-100" alt="Community">
                    <div class="carousel-caption">
                        <div class="caption-content">
                            <h2>Duis Aute Irure Dolor</h2>
                            <p>Duis aute irure dolor in reprehenderit in voluptate <span class="highlight">velit esse cillum</span> dolore eu fugiat nulla pariatur.</p>
                            <a href="#" class="btn mt-3">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    @endif

    

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Carousel Enhancement Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the carousel with options
            const heroCarousel = document.getElementById('heroCarousel');
            if (heroCarousel) {
                const carousel = new bootstrap.Carousel(heroCarousel, {
                    interval: 5000, // 5 seconds between slides
                    pause: 'hover',
                    ride: 'carousel', // Auto-start sliding
                    wrap: true // Loop back to the first slide
                });

                // Ensure navigation buttons work
                const prevButton = heroCarousel.querySelector('.carousel-control-prev');
                const nextButton = heroCarousel.querySelector('.carousel-control-next');

                prevButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    carousel.prev();
                });

                nextButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    carousel.next();
                });

                // Add keyboard navigation
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'ArrowLeft') {
                        carousel.prev();
                    } else if (e.key === 'ArrowRight') {
                        carousel.next();
                    }
                });

                // Add swipe gesture support for touch devices
                let touchStartX = 0;
                let touchEndX = 0;

                heroCarousel.addEventListener('touchstart', e => {
                    touchStartX = e.changedTouches[0].screenX;
                }, false);

                heroCarousel.addEventListener('touchend', e => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                }, false);

                function handleSwipe() {
                    if (touchEndX < touchStartX - 50) {
                        // Swipe left, go to next slide
                        carousel.next();
                    } else if (touchEndX > touchStartX + 50) {
                        // Swipe right, go to previous slide
                        carousel.prev();
                    }
                }

                // Enable mouse drag for desktop
                let isDragging = false;
                let startPosition = 0;
                let currentTranslate = 0;

                heroCarousel.addEventListener('mousedown', dragStart);
                heroCarousel.addEventListener('mouseup', dragEnd);
                heroCarousel.addEventListener('mouseleave', dragEnd);
                heroCarousel.addEventListener('mousemove', drag);

                function dragStart(e) {
                    isDragging = true;
                    startPosition = e.clientX;
                    heroCarousel.style.cursor = 'grabbing';
                }

                function drag(e) {
                    if (isDragging) {
                        currentTranslate = e.clientX - startPosition;
                    }
                }

                function dragEnd() {
                    isDragging = false;
                    heroCarousel.style.cursor = 'grab';

                    if (currentTranslate < -100) {
                        carousel.next();
                    } else if (currentTranslate > 100) {
                        carousel.prev();
                    }

                    currentTranslate = 0;
                }

                // Pause on hover functionality (enhanced)
                heroCarousel.addEventListener('mouseenter', () => {
                    carousel.pause();
                });

                heroCarousel.addEventListener('mouseleave', () => {
                    carousel.cycle();
                });

                // Add visual progress indicator
                const indicators = heroCarousel.querySelectorAll('.carousel-indicators button');

                // Create progress bars inside indicators
                indicators.forEach((indicator) => {
                    indicator.innerHTML = '<span class="progress-bar"></span>';
                    indicator.style.position = 'relative';
                    indicator.style.overflow = 'hidden';
                });

                // Update progress bar for active slide
                function updateProgressBar() {
                    const activeIndicator = heroCarousel.querySelector('.carousel-indicators button.active .progress-bar');
                    if (activeIndicator) {
                        activeIndicator.style.transition = 'none';
                        activeIndicator.style.width = '0%';

                        setTimeout(() => {
                            activeIndicator.style.transition = 'width 5s linear';
                            activeIndicator.style.width = '100%';
                        }, 50);
                    }
                }

                // Reset and start progress on slide change
                heroCarousel.addEventListener('slide.bs.carousel', () => {
                    updateProgressBar();
                });

                // Initial start
                updateProgressBar();
            }
        });
    </script>
</body>

</html>