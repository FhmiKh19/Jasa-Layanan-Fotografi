@extends('layouts-fotografer.corona')

@section('title', 'Portofolio')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Portofolio Saya</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Portofolio</li>
        </ol>
    </nav>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card bg-gradient-primary" style="padding: 20px;">
            <div class="stat-content">
                <h3>{{ $totalPortofolio ?? 0 }}</h3>
                <p class="mb-0">Total Album</p>
            </div>
            <div class="stat-icon">
                <i class="bi bi-folder"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card bg-gradient-success" style="padding: 20px;">
            <div class="stat-content">
                <h3>{{ $totalGambar ?? 0 }}</h3>
                <p class="mb-0">Total Gambar</p>
            </div>
            <div class="stat-icon">
                <i class="bi bi-images"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card bg-gradient-warning" style="padding: 20px;">
            <div class="stat-content">
                <h3>{{ $totalFeatured ?? 0 }}</h3>
                <p class="mb-0">Featured</p>
            </div>
            <div class="stat-icon">
                <i class="bi bi-star-fill"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <span><i class="bi bi-images me-2"></i>Galeri Portofolio</span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('fotografer.portofolio.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Upload Album
                        </a>
                    </div>
                </div>

                <!-- Filter -->
                @if(isset($kategoris) && $kategoris->count() > 0)
                <div class="mb-4">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('fotografer.portofolio.index') }}" 
                           class="btn btn-sm {{ !request('kategori') ? 'btn-primary' : 'btn-outline-secondary' }}">
                            Semua
                        </a>
                        @foreach($kategoris as $kat)
                        <a href="{{ route('fotografer.portofolio.index', ['kategori' => $kat->id_kategori]) }}" 
                           class="btn btn-sm {{ request('kategori') == $kat->id_kategori ? 'btn-primary' : 'btn-outline-secondary' }}">
                            {{ $kat->nama_kategori }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(isset($portofolios) && $portofolios->count() > 0)
                <div class="row">
                    @foreach($portofolios as $item)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100" style="border: 1px solid var(--border-color); overflow: hidden;">
                            <div class="position-relative" style="background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%); min-height: 280px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/portfolio/' . $item->gambar) }}" 
                                         class="card-img-top" 
                                         alt="{{ $item->judul }}"
                                         style="width: 100%; height: 100%; min-height: 280px; object-fit: contain; object-position: center; background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%);">
                                @else
                                    <div class="card-img-top d-flex align-items-center justify-content-center" 
                                         style="height: 280px; width: 100%; background: linear-gradient(135deg, var(--primary-color) 0%, #a29bfe 100%);">
                                        <i class="bi bi-images" style="font-size: 48px; color: rgba(255,255,255,0.5);"></i>
                                    </div>
                                @endif
                                
                                @if(isset($item->is_featured) && $item->is_featured)
                                <span class="position-absolute top-0 end-0 m-2 badge" style="background: linear-gradient(135deg, #ffab00 0%, #ffeaa7 100%); color: #000;">
                                    <i class="bi bi-star-fill me-1"></i> Featured
                                </span>
                                @endif
                                
                                <span class="position-absolute bottom-0 start-0 m-2 badge badge-dark" style="background: rgba(0,0,0,0.7);">
                                    <i class="bi bi-images me-1"></i> {{ $item->gambar ? '1' : '0' }} foto
                                </span>
                                
                                @if($item->kategori)
                                <span class="position-absolute bottom-0 end-0 m-2 badge badge-primary">
                                    {{ $item->kategori }}
                                </span>
                                @endif
                            </div>
                            
                            <div class="card-body">
                                <h5 class="card-title mb-2" style="color: var(--text-primary);">{{ $item->judul }}</h5>
                                <p class="card-text text-secondary" style="font-size: 13px;">
                                    {{ Str::limit($item->deskripsi, 80) }}
                                </p>
                                
                                <div class="d-flex align-items-center text-secondary mb-3" style="font-size: 12px;">
                                    @if(isset($item->lokasi) && $item->lokasi)
                                    <span class="me-3">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $item->lokasi }}
                                    </span>
                                    @endif
                                    @if($item->tgl_dibuat)
                                    <span>
                                        <i class="bi bi-calendar me-1"></i> {{ $item->tgl_dibuat->format('d M Y') }}
                                    </span>
                                    @endif
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="{{ route('fotografer.portofolio.show', $item->id_portofolio) }}" 
                                       class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('fotografer.portofolio.edit', $item->id_portofolio) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if(isset($item->is_featured))
                                    <form action="{{ route('fotografer.portofolio.toggleFeatured', $item->id_portofolio) }}" 
                                          method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $item->is_featured ? 'btn-success' : 'btn-outline-secondary' }}" 
                                                title="{{ $item->is_featured ? 'Hapus dari Featured' : 'Tandai Featured' }}">
                                            <i class="bi bi-star{{ $item->is_featured ? '-fill' : '' }}"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('fotografer.portofolio.destroy', $item->id_portofolio) }}" 
                                          method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus album ini beserta semua fotonya?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <i class="bi bi-images"></i>
                    <h5>Belum ada portofolio</h5>
                    <p>Mulai upload karya-karya terbaik Anda</p>
                    @if(!isset($kategoris) || $kategoris->count() == 0)
                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-info-circle me-1"></i>
                        Hubungi admin untuk membuat kategori terlebih dahulu
                    </small>
                    @endif
                    <a href="{{ route('fotografer.portofolio.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Upload Album
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
