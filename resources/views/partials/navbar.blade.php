<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(120deg, #3e2723 0%, #7b4b2a 70%, #a0683a 100%); box-shadow: 0 6px 25px rgba(62, 39, 35, 0.45);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('login.form') }}">Jasa Fotografi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item me-lg-3">
                    <a href="{{ route('login.form') }}" class="nav-link text-white fw-semibold">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item me-lg-3">
                    <a href="{{ route('booking.create') }}" class="nav-link text-white fw-semibold">
                        <i class="fas fa-calendar-plus me-1"></i> Booking
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light fw-semibold">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
