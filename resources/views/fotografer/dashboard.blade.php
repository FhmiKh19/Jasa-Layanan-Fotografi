@extends('layouts-fotografer.corona')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header mb-4">
    <div>
        <h3 style="font-size: 30px; font-weight: 700; color: #ffffff; letter-spacing: -0.5px; margin-bottom: 8px;">
            <i class="bi bi-speedometer2 me-2" style="color: #6c5ce7;"></i>Dashboard
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#" style="color: #6c7293; text-decoration: none;">Home</a></li>
                <li class="breadcrumb-item active" style="color: #6c5ce7;">Dashboard</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Welcome Message -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 20px; box-shadow: 0 10px 40px rgba(102, 126, 234, 0.4); overflow: hidden; position: relative;">
            <!-- Decorative Elements -->
            <div style="position: absolute; top: -80px; right: -80px; width: 300px; height: 300px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
            <div style="position: absolute; bottom: -60px; left: -60px; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.08); border-radius: 50%;"></div>
            <div style="position: absolute; top: 50%; right: 10%; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; transform: translateY(-50%);"></div>
            
            <div class="card-body d-flex align-items-center justify-content-between" style="padding: 40px; position: relative; z-index: 1;">
                <div style="flex: 1;">
                    <div style="display: inline-block; background: rgba(255, 255, 255, 0.2); padding: 8px 16px; border-radius: 30px; margin-bottom: 15px; backdrop-filter: blur(10px);">
                        <span style="font-size: 12px; font-weight: 600; color: #ffffff; text-transform: uppercase; letter-spacing: 1px;">Selamat Datang Kembali</span>
                    </div>
                    <h2 class="mb-3" style="font-size: 36px; font-weight: 800; color: #ffffff; text-shadow: 0 2px 15px rgba(0, 0, 0, 0.2); margin-bottom: 15px !important; line-height: 1.2;">
                        {{ Auth::user()->nama_pengguna ?? 'Fotografer' }}! 👋
                    </h2>
                    <p class="mb-0" style="font-size: 17px; color: rgba(255, 255, 255, 0.95); font-weight: 400; text-shadow: 0 1px 5px rgba(0, 0, 0, 0.1); line-height: 1.6;">
                        <i class="bi bi-stars me-2"></i>Semoga harimu menyenangkan dan penuh kreativitas dalam setiap momen yang kamu abadikan.
                    </p>
                </div>
                <div class="d-none d-md-block" style="animation: float 3s ease-in-out infinite; margin-left: 30px;">
                    <div style="width: 120px; height: 120px; background: rgba(255, 255, 255, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);">
                        <i class="bi bi-camera-fill" style="font-size: 64px; color: rgba(255, 255, 255, 0.95); text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card bg-gradient-primary" style="padding: 28px; border-radius: 16px; box-shadow: 0 8px 25px rgba(108, 92, 231, 0.3); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; cursor: pointer;">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
            <div class="stat-content" style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-calendar-event" style="font-size: 24px; color: #ffffff;"></i>
                    </div>
                </div>
                <h3 style="font-size: 42px; font-weight: 800; color: #ffffff; margin-bottom: 8px; line-height: 1;">{{ $totalJadwal ?? 0 }}</h3>
                <p style="font-size: 16px; color: rgba(255, 255, 255, 0.95); font-weight: 600; margin-bottom: 6px;">Total Jadwal</p>
                <small style="font-size: 13px; color: rgba(255, 255, 255, 0.85); display: flex; align-items: center; gap: 6px;">
                    <i class="bi bi-calendar-check"></i> Jadwal Terdaftar
                </small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card bg-gradient-success" style="padding: 28px; border-radius: 16px; box-shadow: 0 8px 25px rgba(0, 210, 91, 0.3); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; cursor: pointer;">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
            <div class="stat-content" style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-cart-check" style="font-size: 24px; color: #ffffff;"></i>
                    </div>
                </div>
                <h3 style="font-size: 42px; font-weight: 800; color: #ffffff; margin-bottom: 8px; line-height: 1;">{{ $pesananSelesai ?? 0 }}</h3>
                <p style="font-size: 16px; color: rgba(255, 255, 255, 0.95); font-weight: 600; margin-bottom: 6px;">Pesanan Selesai</p>
                <small style="font-size: 13px; color: rgba(255, 255, 255, 0.85); display: flex; align-items: center; gap: 6px;">
                    <i class="bi bi-check-circle"></i> Bulan Ini
                </small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card bg-gradient-warning" style="padding: 28px; border-radius: 16px; box-shadow: 0 8px 25px rgba(255, 171, 0, 0.3); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; cursor: pointer;">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
            <div class="stat-content" style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-hourglass-split" style="font-size: 24px; color: #ffffff;"></i>
                    </div>
                </div>
                <h3 style="font-size: 42px; font-weight: 800; color: #ffffff; margin-bottom: 8px; line-height: 1;">{{ $pesananPending ?? 0 }}</h3>
                <p style="font-size: 16px; color: rgba(255, 255, 255, 0.95); font-weight: 600; margin-bottom: 6px;">Pesanan Pending</p>
                <small style="font-size: 13px; color: rgba(255, 255, 255, 0.85); display: flex; align-items: center; gap: 6px;">
                    <i class="bi bi-clock"></i> Menunggu
                </small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card bg-gradient-info" style="padding: 28px; border-radius: 16px; box-shadow: 0 8px 25px rgba(143, 95, 232, 0.3); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; cursor: pointer;">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
            <div class="stat-content" style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-images" style="font-size: 24px; color: #ffffff;"></i>
                    </div>
                </div>
                <h3 style="font-size: 42px; font-weight: 800; color: #ffffff; margin-bottom: 8px; line-height: 1;">{{ $totalPortofolio ?? 0 }}</h3>
                <p style="font-size: 16px; color: rgba(255, 255, 255, 0.95); font-weight: 600; margin-bottom: 6px;">Total Portofolio</p>
                <small style="font-size: 13px; color: rgba(255, 255, 255, 0.85); display: flex; align-items: center; gap: 6px;">
                    <i class="bi bi-images"></i> Karya Terupload
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mb-4">
    <div class="col-12 mb-3">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <div>
                <h4 style="font-size: 22px; font-weight: 700; color: #ffffff; margin-bottom: 5px;">
                    <i class="bi bi-lightning-charge-fill me-2" style="color: #6c5ce7;"></i>Aksi Cepat
                </h4>
                <p style="font-size: 14px; color: #6c7293; margin: 0;">Akses cepat ke fitur utama aplikasi</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('fotografer.jadwal.index') }}" class="quick-action-card" style="display: block; background: linear-gradient(135deg, #191c24 0%, #1f2332 100%); border: 1px solid #2c2e33; border-radius: 16px; padding: 28px; text-decoration: none; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); height: 100%; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(108, 92, 231, 0.1) 0%, rgba(108, 92, 231, 0.05) 100%); border-radius: 0 16px 0 50px;"></div>
            <div class="icon" style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; box-shadow: 0 6px 20px rgba(108, 92, 231, 0.4); position: relative; z-index: 1;">
                <i class="bi bi-calendar-plus" style="font-size: 28px; color: #ffffff;"></i>
            </div>
            <h5 style="font-size: 18px; font-weight: 700; color: #ffffff; margin-bottom: 10px; position: relative; z-index: 1;">Kelola Jadwal</h5>
            <p style="font-size: 14px; color: #6c7293; margin: 0; line-height: 1.6; position: relative; z-index: 1;">Atur jadwal pemotretan Anda dengan mudah</p>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('fotografer.pesanan.index') }}" class="quick-action-card" style="display: block; background: linear-gradient(135deg, #191c24 0%, #1f2332 100%); border: 1px solid #2c2e33; border-radius: 16px; padding: 28px; text-decoration: none; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); height: 100%; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(0, 210, 91, 0.1) 0%, rgba(0, 210, 91, 0.05) 100%); border-radius: 0 16px 0 50px;"></div>
            <div class="icon" style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #00d25b 0%, #55efc4 100%); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; box-shadow: 0 6px 20px rgba(0, 210, 91, 0.4); position: relative; z-index: 1;">
                <i class="bi bi-cart-check" style="font-size: 28px; color: #ffffff;"></i>
            </div>
            <h5 style="font-size: 18px; font-weight: 700; color: #ffffff; margin-bottom: 10px; position: relative; z-index: 1;">Kelola Pesanan</h5>
            <p style="font-size: 14px; color: #6c7293; margin: 0; line-height: 1.6; position: relative; z-index: 1;">Lihat dan proses pesanan pelanggan</p>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('fotografer.portofolio.index') }}" class="quick-action-card" style="display: block; background: linear-gradient(135deg, #191c24 0%, #1f2332 100%); border: 1px solid #2c2e33; border-radius: 16px; padding: 28px; text-decoration: none; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); height: 100%; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(143, 95, 232, 0.1) 0%, rgba(143, 95, 232, 0.05) 100%); border-radius: 0 16px 0 50px;"></div>
            <div class="icon" style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #8f5fe8 0%, #a29bfe 100%); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; box-shadow: 0 6px 20px rgba(143, 95, 232, 0.4); position: relative; z-index: 1;">
                <i class="bi bi-images" style="font-size: 28px; color: #ffffff;"></i>
            </div>
            <h5 style="font-size: 18px; font-weight: 700; color: #ffffff; margin-bottom: 10px; position: relative; z-index: 1;">Portofolio</h5>
            <p style="font-size: 14px; color: #6c7293; margin: 0; line-height: 1.6; position: relative; z-index: 1;">Kelola galeri karya Anda</p>
        </a>
    </div>
</div>

<div class="row g-3">
    <!-- Recent Orders -->
    <div class="col-xl-8">
        <div class="card" style="background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%); border: 1px solid #2c2e33; border-radius: 20px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2); overflow: hidden;">
            <div class="card-body" style="padding: 0;">
                <div class="card-title" style="padding: 28px 28px 24px; border-bottom: 1px solid #2c2e33; display: flex; align-items: center; justify-content: space-between; margin: 0; background: linear-gradient(135deg, rgba(108, 92, 231, 0.05) 0%, rgba(108, 92, 231, 0.02) 100%);">
                    <div>
                        <h5 style="font-size: 20px; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-cart3" style="color: #ffffff; font-size: 18px;"></i>
                            </div>
                            Pesanan Terbaru
                        </h5>
                        <p style="font-size: 13px; color: #6c7293; margin: 8px 0 0;">5 pesanan terakhir</p>
                    </div>
                    <a href="{{ route('fotografer.pesanan.index') }}" class="btn btn-sm btn-outline-primary" style="font-size: 13px; padding: 10px 20px; border-radius: 10px; font-weight: 600; border-width: 2px;">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table" style="margin: 0;">
                        <thead style="position: sticky; top: 0; z-index: 10;">
                            <tr style="background: linear-gradient(135deg, #1a1e26 0%, #191c24 100%);">
                                <th style="font-size: 12px; font-weight: 700; color: #6c7293; text-transform: uppercase; letter-spacing: 1px; padding: 20px 24px; border: none;">Pelanggan</th>
                                <th style="font-size: 12px; font-weight: 700; color: #6c7293; text-transform: uppercase; letter-spacing: 1px; padding: 20px 24px; border: none;">Tanggal Acara</th>
                                <th style="font-size: 12px; font-weight: 700; color: #6c7293; text-transform: uppercase; letter-spacing: 1px; padding: 20px 24px; border: none;">Alamat</th>
                                <th style="font-size: 12px; font-weight: 700; color: #6c7293; text-transform: uppercase; letter-spacing: 1px; padding: 20px 24px; border: none;">Status</th>
                                <th style="font-size: 12px; font-weight: 700; color: #6c7293; text-transform: uppercase; letter-spacing: 1px; padding: 20px 24px; border: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesananTerbaru ?? [] as $pesanan)
                            <tr style="border-bottom: 1px solid #2c2e33; transition: all 0.3s ease;">
                                <td style="padding: 22px 24px;">
                                    <div class="user-cell" style="display: flex; align-items: center; gap: 14px;">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($pesanan->pengguna->nama_pengguna ?? 'U') }}&background=6c5ce7&color=fff&size=128&bold=true" 
                                             alt="user" 
                                             style="width: 44px; height: 44px; border-radius: 50%; border: 2px solid #6c5ce7; object-fit: cover; box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);">
                                        <div>
                                            <div style="font-size: 15px; font-weight: 600; color: #ffffff; margin-bottom: 3px;">{{ $pesanan->pengguna->nama_pengguna ?? 'Unknown' }}</div>
                                            <div style="font-size: 12px; color: #6c7293;">Pelanggan</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 22px 24px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 36px; height: 36px; background: rgba(108, 92, 231, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-calendar3" style="color: #6c5ce7; font-size: 16px;"></i>
                                        </div>
                                        <span style="font-size: 14px; color: #ffffff; font-weight: 500;">
                                            {{ $pesanan->tgl_acara ? \Carbon\Carbon::parse($pesanan->tgl_acara)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td style="padding: 22px 24px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 36px; height: 36px; background: rgba(108, 92, 231, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-geo-alt" style="color: #6c5ce7; font-size: 16px;"></i>
                                        </div>
                                        <span style="font-size: 14px; color: #ffffff;">{{ Str::limit($pesanan->alamat ?? '-', 25) }}</span>
                                    </div>
                                </td>
                                <td style="padding: 22px 24px;">
                                    @if($pesanan->status == 'selesai')
                                        <span class="badge badge-success" style="font-size: 11px; font-weight: 700; padding: 8px 14px; border-radius: 20px; background: rgba(0, 210, 91, 0.15); color: #00d25b; border: 1.5px solid rgba(0, 210, 91, 0.3); display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="bi bi-check-circle"></i>Selesai
                                        </span>
                                    @elseif($pesanan->status == 'diproses')
                                        <span class="badge badge-primary" style="font-size: 11px; font-weight: 700; padding: 8px 14px; border-radius: 20px; background: rgba(108, 92, 231, 0.15); color: #6c5ce7; border: 1.5px solid rgba(108, 92, 231, 0.3); display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="bi bi-gear"></i>Diproses
                                        </span>
                                    @else
                                        <span class="badge badge-warning" style="font-size: 11px; font-weight: 700; padding: 8px 14px; border-radius: 20px; background: rgba(255, 171, 0, 0.15); color: #ffab00; border: 1.5px solid rgba(255, 171, 0, 0.3); display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="bi bi-hourglass-split"></i>Pending
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 22px 24px; text-align: center;">
                                    <a href="{{ route('fotografer.pesanan.show', $pesanan->id_pesanan) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       style="font-size: 13px; padding: 8px 14px; border-radius: 10px; border: 2px solid #6c5ce7; color: #6c5ce7; background: transparent; transition: all 0.3s ease; font-weight: 600;">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="padding: 80px 20px; text-align: center;">
                                    <div style="color: #6c7293;">
                                        <div style="width: 80px; height: 80px; background: rgba(108, 92, 231, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                            <i class="bi bi-inbox" style="font-size: 40px; color: #6c5ce7;"></i>
                                        </div>
                                        <h6 style="font-size: 18px; font-weight: 700; color: #ffffff; margin-bottom: 10px;">Belum ada pesanan</h6>
                                        <p style="font-size: 14px; color: #6c7293; margin: 0;">Pesanan akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Schedule & Recent Reports -->
    <div class="col-xl-4">
        <!-- Upcoming Schedule -->
        <div class="card mb-3" style="background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%); border: 1px solid #2c2e33; border-radius: 20px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2); overflow: hidden;">
            <div class="card-body" style="padding: 0;">
                <div class="card-title" style="padding: 28px 28px 24px; border-bottom: 1px solid #2c2e33; margin: 0; background: linear-gradient(135deg, rgba(108, 92, 231, 0.05) 0%, rgba(108, 92, 231, 0.02) 100%);">
                    <h5 style="font-size: 20px; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-calendar-event" style="color: #ffffff; font-size: 18px;"></i>
                        </div>
                        Jadwal Mendatang
                    </h5>
                    <p style="font-size: 13px; color: #6c7293; margin: 8px 0 0;">5 jadwal terdekat</p>
                </div>
                <div style="padding: 24px; max-height: 400px; overflow-y: auto;">
                    <ul class="activity-list" style="list-style: none; padding: 0; margin: 0;">
                        @forelse($jadwalMendatang ?? [] as $jadwal)
                        <li style="display: flex; align-items: flex-start; padding: 20px 0; border-bottom: 1px solid #2c2e33; transition: all 0.3s ease;">
                            <div class="activity-icon" style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, rgba(108, 92, 231, 0.2) 0%, rgba(108, 92, 231, 0.1) 100%); display: flex; align-items: center; justify-content: center; margin-right: 16px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(108, 92, 231, 0.2);">
                                <i class="bi bi-camera" style="color: #6c5ce7; font-size: 20px;"></i>
                            </div>
                            <div class="activity-content" style="flex: 1; min-width: 0;">
                                <h6 style="font-size: 15px; font-weight: 700; color: #ffffff; margin: 0 0 8px; line-height: 1.4;">{{ $jadwal->nama_klien }}</h6>
                                <p style="font-size: 13px; color: #6c7293; margin: 0 0 8px; line-height: 1.5;">{{ $jadwal->layanan->nama_layanan ?? 'Layanan' }}</p>
                                <div style="display: flex; align-items: center; gap: 8px; margin-top: 10px;">
                                    <div style="width: 28px; height: 28px; background: rgba(108, 92, 231, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-clock" style="color: #6c5ce7; font-size: 12px;"></i>
                                    </div>
                                    <span style="font-size: 12px; color: #6c7293; font-weight: 500;">{{ \Carbon\Carbon::parse($jadwal->tgl_acara)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li style="text-align: center; padding: 60px 20px;">
                            <div style="width: 80px; height: 80px; background: rgba(108, 92, 231, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="bi bi-calendar-x" style="font-size: 40px; color: #6c5ce7;"></i>
                            </div>
                            <h6 style="font-size: 18px; font-weight: 700; color: #ffffff; margin-bottom: 10px;">Tidak ada jadwal</h6>
                            <p style="font-size: 14px; color: #6c7293; margin: 0;">Jadwal mendatang akan muncul di sini</p>
                        </li>
                        @endforelse
                    </ul>
                    <a href="{{ route('fotografer.jadwal.index') }}" class="btn btn-outline-primary w-100 mt-3" style="font-size: 14px; padding: 14px; border-radius: 12px; border: 2px solid #6c5ce7; color: #6c5ce7; background: transparent; transition: all 0.3s ease; font-weight: 600;">
                        <i class="bi bi-plus-circle me-2"></i>Lihat Semua Jadwal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-12px);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.stat-card {
    animation: fadeInUp 0.8s ease-out;
    animation-fill-mode: both;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

.stat-card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4) !important;
}

.quick-action-card {
    animation: fadeInUp 0.8s ease-out;
    animation-fill-mode: both;
}

.quick-action-card:nth-child(1) { animation-delay: 0.5s; }
.quick-action-card:nth-child(2) { animation-delay: 0.6s; }
.quick-action-card:nth-child(3) { animation-delay: 0.7s; }
.quick-action-card:nth-child(4) { animation-delay: 0.8s; }

.quick-action-card:hover {
    transform: translateY(-8px) scale(1.02);
    border-color: #6c5ce7 !important;
    box-shadow: 0 12px 40px rgba(108, 92, 231, 0.3) !important;
    background: linear-gradient(135deg, #1f2332 0%, #252938 100%) !important;
}

.quick-action-card:hover .icon {
    transform: scale(1.15) rotate(5deg);
    box-shadow: 0 10px 30px rgba(108, 92, 231, 0.5) !important;
}

.card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.card:hover {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25) !important;
    transform: translateY(-2px);
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background: rgba(108, 92, 231, 0.1) !important;
    transform: translateX(6px);
    border-left: 3px solid #6c5ce7;
}

.activity-list li:hover {
    background: rgba(108, 92, 231, 0.08);
    border-radius: 12px;
    padding-left: 12px;
    padding-right: 12px;
    margin-left: -12px;
    margin-right: -12px;
}

.activity-list li:hover .activity-icon {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(108, 92, 231, 0.3) !important;
}

.btn-outline-primary:hover {
    background: #6c5ce7 !important;
    color: #ffffff !important;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(108, 92, 231, 0.5);
    border-color: #6c5ce7 !important;
}

/* Professional scrollbar */
.table-responsive::-webkit-scrollbar,
div[style*="overflow-y: auto"]::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track,
div[style*="overflow-y: auto"]::-webkit-scrollbar-track {
    background: #191c24;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb,
div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover,
div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5b4bc4 0%, #8f7ef5 100%);
}

/* Smooth transitions */
* {
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}

/* Professional card shadows */
.card {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

/* Gradient text effect */
h2, h3, h4, h5, h6 {
    background: linear-gradient(135deg, #ffffff 0%, rgba(255, 255, 255, 0.9) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Glass morphism effect */
.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
    border-radius: 16px;
    pointer-events: none;
}
</style>
@endpush
@endsection
