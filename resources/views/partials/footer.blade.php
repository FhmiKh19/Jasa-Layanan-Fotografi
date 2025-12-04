<footer class="bg-light py-4 mt-5 border-top">
  <div class="container-fluid px-4">
    <div class="row">
      <div class="col-md-6">
        <p class="text-muted mb-0">
          <i class="fas fa-copyright me-1"></i>
          {{ date('Y') }} Layanan Jasa Fotografi. All Rights Reserved.
        </p>
      </div>
      <div class="col-md-6 text-end">
        <span class="text-muted small">
          <i class="fas fa-user me-1"></i>
          {{ Auth::user()->nama_pengguna ?? 'User' }} 
          <span class="mx-2">|</span>
          <i class="fas fa-camera me-1"></i>
          {{ ucfirst(Auth::user()->role ?? 'User') }}
        </span>
      </div>
    </div>
  </div>
</footer>

