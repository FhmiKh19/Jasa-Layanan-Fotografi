@extends('layouts.app')

@section('title', 'Manajemen Portofolio')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@push('custom-styles')
<style>
  .stat-card {
    border-radius: 20px;
    border: none;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    padding: 1.5rem;
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--stat-color-1), var(--stat-color-2));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
  }

  .stat-card:hover::before {
    transform: scaleX(1);
  }

  .stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
  }

  .stat-card .stat-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--stat-color-1), var(--stat-color-2));
    color: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
  }

  .stat-card:hover .stat-icon-wrapper {
    transform: rotate(5deg) scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
  }

  .stat-card .stat-value {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--stat-color-1), var(--stat-color-2));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
  }

  .stat-card .stat-label {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
  }

  .stat-card.stat-primary { --stat-color-1: #667eea; --stat-color-2: #764ba2; }
  .stat-card.stat-success { --stat-color-1: #28a745; --stat-color-2: #20c997; }

  .filter-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: none;
  }

  .portfolio-card {
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    background: #fff;
    position: relative;
  }

  .portfolio-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
  }

  .portfolio-image-wrapper {
    position: relative;
    width: 100%;
    height: 250px;
    overflow: hidden;
    background: #f0f0f0;
  }

  .portfolio-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s ease;
  }

  .portfolio-card:hover .portfolio-image {
    transform: scale(1.15);
  }

  .portfolio-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
    opacity: 0;
    transition: all 0.3s ease;
    display: flex;
    align-items: flex-end;
    padding: 1rem;
  }

  .portfolio-card:hover .portfolio-overlay {
    opacity: 1;
  }

  .portfolio-overlay-content {
    color: white;
    width: 100%;
  }

  .portfolio-placeholder {
    width: 100%;
    height: 250px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
  }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1 d-flex align-items-center">
      <i data-lucide="image" class="me-2 text-primary"></i>Manajemen Portofolio
    </h3>
    <p class="text-muted mb-0">Kelola galeri portofolio fotografi</p>
  </div>
  <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary d-inline-flex align-items-center">
    <i data-lucide="plus" class="me-2" style="width: 1em; height: 1em;"></i>Tambah Portofolio
  </a>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-4">
  <div class="col-md-6">
    <div class="stat-card stat-primary">
      <div class="stat-icon-wrapper">
        <i data-lucide="image"></i>
      </div>
      <div class="stat-value">{{ $stats['total'] }}</div>
      <p class="stat-label mb-0">Total Portofolio</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="stat-card stat-success">
      <div class="stat-icon-wrapper">
        <i data-lucide="image-plus"></i>
      </div>
      <div class="stat-value">{{ $stats['dengan_gambar'] }}</div>
      <p class="stat-label mb-0">Dengan Gambar</p>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card filter-card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.portfolio.index') }}" class="row g-3">
      <div class="col-md-6">
        <label class="form-label fw-bold">Cari Portofolio</label>
        <input type="text" 
               name="search" 
               class="form-control" 
               placeholder="Judul, kategori, atau deskripsi..."
               value="{{ request('search') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label fw-bold">Filter Kategori</label>
        <select name="kategori" class="form-select">
          <option value="">Semua Kategori</option>
          @foreach($kategoris as $kategori)
            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
              {{ $kategori }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center">
          <i data-lucide="search" class="me-2" style="width: 1em; height: 1em;"></i>Filter
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Grid Portofolio -->
@if($portofolio->count() > 0)
  <div class="row g-4">
    @foreach($portofolio as $item)
      <div class="col-md-4 col-lg-3">
        <div class="card portfolio-card">
          <div class="portfolio-image-wrapper">
            @if($item->gambar)
              <img src="{{ asset('storage/portfolio/' . $item->gambar) }}" 
                   alt="{{ $item->judul }}" 
                   class="portfolio-image"
                   onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'portfolio-placeholder\'><i data-lucide=\'image\' style=\'width: 3rem; height: 3rem;\'></i><p class=\'text-white mt-2 small\'>Gambar tidak ditemukan</p></div>'; lucide.createIcons();">
              <div class="portfolio-overlay">
                <div class="portfolio-overlay-content">
                  <h6 class="text-white fw-bold mb-1">{{ Str::limit($item->judul, 25) }}</h6>
                  @if($item->kategori)
                    <span class="badge bg-light text-dark">{{ $item->kategori }}</span>
                  @endif
                </div>
              </div>
            @else
              <div class="portfolio-placeholder">
                <i data-lucide="image" style="width: 3rem; height: 3rem;"></i>
              </div>
            @endif
          </div>
          <div class="card-body p-3">
            <h6 class="fw-bold mb-2" style="font-size: 0.95rem;">{{ Str::limit($item->judul, 30) }}</h6>
            @if($item->kategori)
              <span class="badge mb-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">{{ $item->kategori }}</span>
            @endif
            <p class="text-muted small mb-3" style="font-size: 0.8rem; line-height: 1.5;">
              {{ Str::limit($item->deskripsi, 60) }}
            </p>
            <div class="d-flex gap-2 mb-2">
              <a href="{{ route('admin.portfolio.edit', $item->id_portofolio) }}" 
                 class="btn btn-action btn-primary flex-fill"
                 title="Edit">
                <i data-lucide="edit"></i>Edit
              </a>
              <form action="{{ route('admin.portfolio.destroy', $item->id_portofolio) }}" 
                    method="POST" 
                    class="flex-fill"
                    onsubmit="return confirm('Yakin ingin menghapus portofolio ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn btn-action btn-outline-danger w-100"
                        title="Hapus">
                  <i data-lucide="trash-2"></i>Hapus
                </button>
              </form>
            </div>
            <small class="text-muted d-flex align-items-center" style="font-size: 0.75rem;">
              <i data-lucide="calendar" style="width: 0.8em; height: 0.8em;" class="me-1"></i>
              {{ $item->tgl_dibuat->format('d M Y') }}
            </small>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  @if($portofolio->hasPages())
    <div class="mt-4">
      {{ $portofolio->links() }}
    </div>
  @endif
@else
  <div class="card">
    <div class="card-body text-center py-5">
      <i data-lucide="inbox" class="text-muted mb-3" style="width: 3rem; height: 3rem;"></i>
      <p class="text-muted">Tidak ada portofolio ditemukan</p>
      <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary mt-3 d-inline-flex align-items-center">
        <i data-lucide="plus" class="me-2" style="width: 1em; height: 1em;"></i>Tambah Portofolio Pertama
      </a>
    </div>
  </div>
@endif
@endsection

