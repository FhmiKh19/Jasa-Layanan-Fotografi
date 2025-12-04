@extends('layouts.corona')

@section('title', 'Kategori Portofolio')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Kategori Portofolio</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.portofolio.index') }}">Portofolio</a></li>
            <li class="breadcrumb-item active">Kategori</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <span><i class="bi bi-folder me-2"></i>Kelola Kategori</span>
                    <a href="{{ route('fotografer.portofolio.kategori.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                    </a>
                </div>

                @if($kategoris->count() > 0)
                <div class="row">
                    @foreach($kategoris as $kategori)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100" style="border: 1px solid var(--border-color); overflow: hidden;">
                            <div class="position-relative" style="height: 150px; background: linear-gradient(135deg, var(--primary-color) 0%, #a29bfe 100%);">
                                @if($kategori->cover_image)
                                    <img src="{{ asset('storage/' . $kategori->cover_image) }}" 
                                         class="w-100 h-100" 
                                         alt="{{ $kategori->nama_kategori }}"
                                         style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-folder" style="font-size: 48px; color: rgba(255,255,255,0.5);"></i>
                                    </div>
                                @endif
                                
                                <span class="position-absolute top-0 end-0 m-2 badge {{ $kategori->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            
                            <div class="card-body">
                                <h5 class="card-title mb-2" style="color: var(--text-primary);">{{ $kategori->nama_kategori }}</h5>
                                <p class="card-text text-secondary" style="font-size: 13px;">
                                    {{ Str::limit($kategori->deskripsi, 60) ?? 'Tidak ada deskripsi' }}
                                </p>
                                
                                <div class="d-flex align-items-center text-secondary mb-3" style="font-size: 12px;">
                                    <span class="me-3">
                                        <i class="bi bi-images me-1"></i> {{ $kategori->portofolios_count }} Album
                                    </span>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="{{ route('fotografer.portofolio.index', ['kategori' => $kategori->id_kategori]) }}" 
                                       class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('fotografer.portofolio.kategori.edit', $kategori->id_kategori) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('fotografer.portofolio.kategori.destroy', $kategori->id_kategori) }}" 
                                          method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus kategori ini? Semua portofolio dalam kategori ini juga akan terhapus!')">
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
                    <i class="bi bi-folder-plus"></i>
                    <h5>Belum ada kategori</h5>
                    <p>Buat kategori untuk mengorganisir portofolio Anda</p>
                    <a href="{{ route('fotografer.portofolio.kategori.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

