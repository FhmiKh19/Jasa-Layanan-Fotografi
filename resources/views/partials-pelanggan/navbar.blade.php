<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: rgba(139, 69, 19, 0.95); backdrop-filter: blur(10px); box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3); z-index: 1000;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('pelanggan.dashboard') }}">
            <i class="fas fa-camera me-2"></i>Jasa Fotografi
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a href="{{ route('pelanggan.dashboard') }}" class="nav-link text-white fw-semibold {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pelanggan.layanan.index') }}" class="nav-link text-white fw-semibold {{ request()->routeIs('pelanggan.layanan.*') ? 'active' : '' }}">
                        <i class="fas fa-box me-1"></i> Layanan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pelanggan.pesanan.index') }}" class="nav-link text-white fw-semibold {{ request()->routeIs('pelanggan.pesanan.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-bag me-1"></i> Pesanan Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pelanggan.chat.list') }}" class="nav-link text-white fw-semibold {{ request()->routeIs('pelanggan.chat.*') ? 'active' : '' }}">
                        <i class="fas fa-comments me-1"></i> Chat
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pelanggan.portofolio.index') }}" class="nav-link text-white fw-semibold {{ request()->routeIs('pelanggan.portofolio.*') ? 'active' : '' }}">
                        <i class="fas fa-images me-1"></i> Portofolio
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->nama_pengguna }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="fas fa-user me-2"></i> Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .nav-link.active {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: 8px 16px !important;
    }
    .dropdown-menu {
        background: rgba(139, 69, 19, 0.98);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .dropdown-item {
        color: white;
        transition: all 0.3s;
    }
    .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    .dropdown-item.text-danger:hover {
        background: rgba(220, 53, 69, 0.3);
        color: #ff6b6b !important;
    }
</style>
