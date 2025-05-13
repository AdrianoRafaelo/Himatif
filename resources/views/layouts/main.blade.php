<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda')</title>
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
    <style>
        .toast {
            position: fixed;
            top: 60px;
            right: 20px;
            width: 300px;
            z-index: 1050;
        }
        .toast-header .icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
        .toast-body {
            font-size: 14px;
        }
        .notification-dropdown {
            max-height: 300px;
            overflow-y: auto;
        }
        .notification-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .notification-item.read {
            background-color: #f8f9fa;
        }
        .notification-item.unread {
            font-weight: bold;
            background-color: #fff3cd;
        }
    </style>
</head>

<body>
    <!-- Toast Container for Notifications -->
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container">
            <!-- Notifikasi dari Admin (session) -->
            @if(session('notifications'))
                @foreach(session('notifications') as $notification)
                    <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                        <div class="toast-header">
                            <i class="fas fa-check-circle text-white icon"></i>
                            <strong class="me-auto">Notifikasi</strong>
                            <small>{{ $notification['date'] }}</small>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{ $notification['message'] }} untuk NIM {{ $notification['nim'] }}
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Notifikasi untuk Mahasiswa (dari database) -->
            @if(session('user') && session('user')['role'] === 'mahasiswa' && isset(session('user')['nim']))
                @php
                    $notifications = App\Models\Notification::where('nim', session('user')['nim'])
                        ->where('is_read', false)
                        ->get();
                @endphp
                @foreach($notifications as $notification)
                    <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                        <div class="toast-header">
                            <i class="fas fa-check-circle text-white icon"></i>
                            <strong class="me-auto">Notifikasi</strong>
                            <small>{{ $notification->created_at->format('d M Y') }}</small>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{ $notification->message }}
                        </div>
                    </div>
                    @php
                        $notification->update(['is_read' => true]);
                    @endphp
                @endforeach
            @endif
        </div>
    </div>

    <!-- Social Bar -->
    <div class="social-bar py-2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-none d-md-block">
                    <span class="text-secondary"><i class="far fa-envelope me-2"></i>himatif@example.com</span>
                </div>
                <div class="social-icons d-flex gap-3 align-items-center position-relative">
                    <!-- Social Media Icons -->
                    <a href="#" class="text-secondary" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-secondary" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-secondary" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-secondary" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-secondary" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    @if(session('user') && isset(session('user')['role']) && session('user')['role'] === 'mahasiswa')
                        <!-- Dropdown Notifikasi -->
                        <div class="dropdown ms-3">
                            <a href="#" class="text-secondary dropdown-toggle" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                <span class="badge bg-danger rounded-circle" style="position: absolute; top: -5px; right: -5px;">
                                    {{ App\Models\Notification::where('nim', session('user')['nim'])->where('is_read', false)->count() }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown">
                                @php
                                    $history = App\Models\Notification::where('nim', session('user')['nim'])
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                                @endphp
                                @forelse($history as $notif)
                                    <li class="notification-item {{ !$notif->is_read ? 'unread' : 'read' }}">
                                        <small>{{ $notif->created_at->format('d M Y H:i') }}</small><br>
                                        {{ $notif->message }}
                                    </li>
                                @empty
                                    <li class="notification-item">Tidak ada riwayat notifikasi.</li>
                                @endforelse
                                @if($history->count() >= 5)
                                    <li class="notification-item text-center">
                                        <a href="#" class="text-decoration-none">Lihat semua</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <!-- Dropdown User Icon -->
                        <div class="dropdown ms-3">
                            <a href="#" class="text-secondary dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li class="px-3 py-2 text-secondary small">
                                    {{ session('user')['nama'] ?? 'Mahasiswa' }}<br>
                                    <span class="text-muted">{{ session('user')['email'] ?? '' }}</span>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Tombol Login dengan logo -->
                        <a href="{{ route('login') }}" class="text-secondary" aria-label="Login">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                    @endif
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
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('events') }}">Acara</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('galeri') }}">Galery</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('keuangan') }}">Keuangan</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('news') }}">Berita</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('tentang') }}">Visi Misi</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('organization') }}">Organisasi</a></li>
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

    <!-- Toast Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl);
            });
            toastList.forEach(toast => toast.show());
        });

        // Initialize the carousel with options
        const heroCarousel = document.getElementById('heroCarousel');
        if (heroCarousel) {
            const carousel = new bootstrap.Carousel(heroCarousel, {
                interval: 5000,
                pause: 'hover',
                ride: 'carousel',
                wrap: true
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
                    carousel.next();
                } else if (touchEndX > touchStartX + 50) {
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

            indicators.forEach((indicator) => {
                indicator.innerHTML = '<span class="progress-bar"></span>';
                indicator.style.position = 'relative';
                indicator.style.overflow = 'hidden';
            });

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

            heroCarousel.addEventListener('slide.bs.carousel', () => {
                updateProgressBar();
            });

            updateProgressBar();
        }
    </script>
</body>

</html>