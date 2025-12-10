@extends('layouts-fotografer.corona')

@section('title', $portofolio->judul)

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Detail Album</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.portofolio.index') }}">Portofolio</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 mb-3">
                    @if($portofolio->kategori)
                    <span class="badge badge-primary">{{ $portofolio->kategori->nama_kategori }}</span>
                    @endif
                    @if($portofolio->is_featured)
                    <span class="badge" style="background: linear-gradient(135deg, #ffab00 0%, #ffeaa7 100%); color: #000;">
                        <i class="bi bi-star-fill me-1"></i> Featured
                    </span>
                    @endif
                    <span class="badge badge-secondary">
                        <i class="bi bi-images me-1"></i> {{ $portofolio->gambars->count() }} foto
                    </span>
                </div>
                
                <h2 style="color: var(--text-primary);">{{ $portofolio->judul }}</h2>
                
                <div class="d-flex align-items-center text-secondary mb-4" style="font-size: 14px;">
                    @if($portofolio->lokasi)
                    <span class="me-4">
                        <i class="bi bi-geo-alt me-1"></i> {{ $portofolio->lokasi }}
                    </span>
                    @endif
                    @if($portofolio->tanggal_foto)
                    <span>
                        <i class="bi bi-calendar me-1"></i> {{ $portofolio->tanggal_foto->format('d M Y') }}
                    </span>
                    @endif
                </div>
                
                @if($portofolio->deskripsi)
                <p style="color: var(--text-primary); line-height: 1.8;">{{ $portofolio->deskripsi }}</p>
                @endif
            </div>
        </div>

        <!-- Gallery -->
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-images me-2"></i>Galeri Foto</h6>
                
                <div class="row g-3">
                    @foreach($portofolio->gambars as $gambar)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ asset('storage/' . $gambar->file_gambar) }}" 
                           target="_blank" 
                           class="d-block position-relative portfolio-image-wrapper" 
                           style="border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%); min-height: 200px; display: flex; align-items: center; justify-content: center; border: 1px solid #2c2e33; transition: all 0.3s ease;"
                           onmouseover="this.style.transform='scale(1.02)'; this.style.borderColor='#6c5ce7';"
                           onmouseout="this.style.transform='scale(1)'; this.style.borderColor='#2c2e33';">
                            <img src="{{ asset('storage/' . $gambar->file_gambar) }}" 
                                 class="w-100 h-100" 
                                 alt="Foto {{ $loop->iteration }}"
                                 style="object-fit: contain; object-position: center; max-height: 250px; width: auto; height: auto; padding: 8px; transition: transform 0.3s ease;">
                            
                            @if($gambar->is_cover)
                            <span class="position-absolute top-0 start-0 m-2 badge" style="background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); color: #fff; font-size: 11px; font-weight: 600; padding: 6px 10px; border-radius: 8px; box-shadow: 0 2px 8px rgba(108, 92, 231, 0.4);">
                                <i class="bi bi-star-fill me-1"></i> Cover
                            </span>
                            @endif
                            
                            <div class="position-absolute top-0 end-0 bottom-0 start-0 d-flex align-items-center justify-content-center" 
                                 style="background: rgba(0,0,0,0); transition: all 0.3s ease; opacity: 0; border-radius: 12px;"
                                 onmouseover="this.style.background='rgba(0,0,0,0.6)'; this.style.opacity='1';"
                                 onmouseout="this.style.background='rgba(0,0,0,0)'; this.style.opacity='0';">
                                <div style="background: rgba(108, 92, 231, 0.9); padding: 12px 20px; border-radius: 10px; transform: scale(0.9); transition: transform 0.3s ease;"
                                     onmouseover="this.style.transform='scale(1)';"
                                     onmouseout="this.style.transform='scale(0.9)';">
                                    <i class="bi bi-zoom-in" style="font-size: 24px; color: white; display: block;"></i>
                                    <small style="color: white; font-size: 11px; font-weight: 600; display: block; margin-top: 4px;">Lihat Detail</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-info-circle me-2"></i>Informasi</h6>
                <table class="table table-sm">
                    <tr>
                        <td class="text-secondary">ID</td>
                        <td>{{ $portofolio->id_portofolio }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Kategori</td>
                        <td>
                            @if($portofolio->kategori)
                            <span class="badge badge-primary">{{ $portofolio->kategori->nama_kategori }}</span>
                            @else
                            <span class="text-secondary">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Jumlah Foto</td>
                        <td>{{ $portofolio->gambars->count() }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Status</td>
                        <td>
                            @if($portofolio->is_featured)
                                <span class="badge badge-warning"><i class="bi bi-star-fill me-1"></i> Featured</span>
                            @else
                                <span class="badge badge-secondary">Normal</span>
                            @endif
                        </td>
                    </tr>
                    @if($portofolio->lokasi)
                    <tr>
                        <td class="text-secondary">Lokasi</td>
                        <td>{{ $portofolio->lokasi }}</td>
                    </tr>
                    @endif
                    @if($portofolio->tanggal_foto)
                    <tr>
                        <td class="text-secondary">Tanggal Foto</td>
                        <td>{{ $portofolio->tanggal_foto->format('d M Y') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="text-secondary">Dibuat</td>
                        <td>{{ $portofolio->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-gear me-2"></i>Aksi</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('fotografer.portofolio.edit', $portofolio->id_portofolio) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i> Edit Album
                    </a>
                    
                    <form action="{{ route('fotografer.portofolio.toggleFeatured', $portofolio->id_portofolio) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn {{ $portofolio->is_featured ? 'btn-outline-warning' : 'btn-success' }} w-100">
                            <i class="bi bi-star{{ $portofolio->is_featured ? '' : '-fill' }} me-1"></i>
                            {{ $portofolio->is_featured ? 'Hapus dari Featured' : 'Tandai Featured' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('fotografer.portofolio.destroy', $portofolio->id_portofolio) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menghapus album ini?')">
                            <i class="bi bi-trash me-1"></i> Hapus Album
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <a href="{{ route('fotografer.portofolio.index') }}" class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Galeri
        </a>
    </div>
</div>
@endsection
