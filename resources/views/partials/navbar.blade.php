<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
    <button class="btn btn-link d-md-none text-dark" id="sidebarToggle" type="button" style="text-decoration: none;">
      <i data-lucide="menu" class="text-dark" style="width: 24px; height: 24px;"></i>
    </button>
    <span class="navbar-brand mb-0 d-flex align-items-center">
      <i data-lucide="camera" class="me-2" style="width: 24px; height: 24px;"></i>
      <span>Selamat Datang, <strong>{{ Auth::user()->nama_pengguna ?? 'User' }}</strong></span>
    </span>
    <div class="d-flex align-items-center gap-3">
      <span class="text-muted d-flex align-items-center">
        <i data-lucide="calendar" class="me-2" style="width: 18px; height: 18px;"></i>
        <span>{{ date('d M Y') }}</span>
      </span>
      <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 8px 16px; font-size: 0.875rem;">
        {{ ucfirst(Auth::user()->role ?? 'User') }}
      </span>
    </div>
  </div>
</nav>

