@php
  $user = Auth::user();
  $role = $user->role ?? 'pelanggan';
  $currentRoute = request()->route()->getName();
@endphp

<div class="sidebar d-flex flex-column">
  <div>
    <h4 class="d-flex align-items-center">
      @if($role === 'admin')
        <i data-lucide="camera" class="me-2" style="width: 28px; height: 28px;"></i>Admin Panel
      @elseif($role === 'fotografer')
        <i data-lucide="camera" class="me-2"></i>Fotografer
      @else
        <i data-lucide="user" class="me-2"></i>Pelanggan
      @endif
    </h4>
    
    <div class="px-3 pt-3">

  @if($role === 'admin')
    <a href="{{ route('admin.dashboard') }}" class="{{ $currentRoute === 'admin.dashboard' ? 'active' : '' }}">
      <i data-lucide="layout-dashboard" class="me-2"></i>Dashboard
    </a>
    <a href="{{ route('admin.users.index') }}" class="{{ $currentRoute === 'admin.users.index' ? 'active' : '' }}">
      <i data-lucide="users" class="me-2"></i>Manajemen User
    </a>
    <a href="{{ route('admin.orders.index') }}" class="{{ $currentRoute === 'admin.orders.index' || $currentRoute === 'admin.orders.show' ? 'active' : '' }}">
      <i data-lucide="shopping-cart" class="me-2"></i>Manajemen Pesanan
    </a>
    <a href="{{ route('admin.services.index') }}" class="{{ str_starts_with($currentRoute, 'admin.services') ? 'active' : '' }}">
      <i data-lucide="package" class="me-2"></i>Manajemen Layanan
    </a>
    <a href="{{ route('admin.portfolio.index') }}" class="{{ str_starts_with($currentRoute, 'admin.portfolio') ? 'active' : '' }}">
      <i data-lucide="image" class="me-2"></i>Manajemen Portofolio
    </a>
    <a href="{{ route('admin.transactions.index') }}" class="{{ str_starts_with($currentRoute, 'admin.transactions') ? 'active' : '' }}">
      <i data-lucide="receipt" class="me-2"></i>Transaksi
    </a>
    <a href="{{ route('admin.testimoni.index') }}" class="{{ $currentRoute === 'admin.testimoni.index' ? 'active' : '' }}">
      <i data-lucide="star" class="me-2"></i>Laporan Testimoni
    </a>
    <a href="{{ route('profile.show') }}" class="{{ $currentRoute === 'profile.show' ? 'active' : '' }}">
      <i data-lucide="user-circle" class="me-2"></i>Profil
    </a>
  @elseif($role === 'fotografer')
    <a href="{{ route('fotografer.dashboard') }}" class="{{ $currentRoute === 'fotografer.dashboard' ? 'active' : '' }}">
      <i data-lucide="layout-dashboard" class="me-2"></i>Dashboard
    </a>
    <a href="{{ route('profile.show') }}" class="{{ $currentRoute === 'profile.show' ? 'active' : '' }}">
      <i data-lucide="user-circle" class="me-2"></i>Profil
    </a>
  @else
    <a href="{{ route('pelanggan.dashboard') }}" class="{{ $currentRoute === 'pelanggan.dashboard' ? 'active' : '' }}">
      <i data-lucide="layout-dashboard" class="me-2"></i>Dashboard
    </a>
    <a href="{{ route('profile.show') }}" class="{{ $currentRoute === 'profile.show' ? 'active' : '' }}">
      <i data-lucide="user-circle" class="me-2"></i>Profil
    </a>
  @endif

    </div>
  </div>
  
  <div class="mt-auto pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-logout d-flex align-items-center justify-content-center">
        <i data-lucide="log-out" class="me-2" style="width: 18px; height: 18px;"></i>Logout
      </button>
    </form>
  </div>
</div>

