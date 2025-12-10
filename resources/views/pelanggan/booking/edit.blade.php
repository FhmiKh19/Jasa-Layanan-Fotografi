<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking Fotografer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #5d4037 0%, #8d6e63 50%, #d7ccc8 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            padding-top: 80px;
            padding-bottom: 20px;
        }
        .booking-card {
            max-width: 520px;
            width: 100%;
            border-radius: 20px;
            background: #fffaf5;
            box-shadow: 0 20px 50px rgba(93, 64, 55, 0.35);
        }
        .booking-header {
            background: linear-gradient(135deg, #3e2723 0%, #795548 60%, #bcaaa4 100%);
            color: white;
            padding: 25px;
            border-radius: 20px 20px 0 0;
            text-align: center;
        }
        .booking-header h3 {
            margin: 0;
            font-weight: 600;
        }
        .booking-body {
            padding: 30px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #a1887f;
            box-shadow: 0 0 0 0.2rem rgba(161, 136, 127, 0.3);
        }
        .btn-warning {
            background: linear-gradient(135deg, #6d4c41 0%, #a47c64 60%, #e0c0a3 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: #2a1b12;
            transition: transform 0.2s;
        }
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
            color: white;
        }
        .btn-secondary {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }
        .preview-image {
            max-width: 100%;
            border-radius: 10px;
            margin-top: 10px;
            border: 2px solid #e0e0e0;
        }
    </style>
</head>
<body>

{{-- ================== NAVBAR ================== --}}
@include('partials-pelanggan.navbar')
{{-- ============================================ --}}

<div class="container">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="booking-card">
            <div class="booking-header">
                <h3><i class="fas fa-edit me-2"></i>Edit Booking Fotografer</h3>
            </div>

            <div class="booking-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pelanggan.booking.update', $booking->id_pesanan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-camera me-2"></i>Pilih Layanan <span class="text-danger">*</span></label>
                        <select name="id_layanan" class="form-control @error('id_layanan') is-invalid @enderror" required>
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($layanan as $lay)
                                <option value="{{ $lay->id_layanan }}" 
                                        {{ old('id_layanan', $booking->id_layanan) == $lay->id_layanan ? 'selected' : '' }}>
                                    {{ $lay->nama_layanan }} - Rp {{ number_format($lay->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user-camera me-2"></i>Pilih Fotografer</label>
                        <select name="id_fotografer" class="form-control @error('id_fotografer') is-invalid @enderror">
                            <option value="">-- Pilih Fotografer (Opsional) --</option>
                            @foreach($fotografer as $foto)
                                <option value="{{ $foto->id_pengguna }}" 
                                        {{ old('id_fotografer', $booking->id_fotografer) == $foto->id_pengguna ? 'selected' : '' }}>
                                    {{ $foto->nama_pengguna }} ({{ $foto->username }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_fotografer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Biarkan kosong jika ingin admin yang assign fotografer</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Tanggal Acara <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_acara" class="form-control @error('tgl_acara') is-invalid @enderror" 
                               value="{{ old('tgl_acara', $booking->tgl_acara) }}" min="{{ date('Y-m-d') }}" required>
                        @error('tgl_acara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Pilih tanggal untuk jadwal foto</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Alamat Lokasi Foto</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                  rows="3" placeholder="Masukkan alamat lokasi foto...">{{ old('alamat', $booking->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-credit-card me-2"></i>Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-control @error('metode_pembayaran') is-invalid @enderror">
                            <option value="">-- Pilih Metode --</option>
                            <option value="transfer" {{ old('metode_pembayaran', $booking->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="cash" {{ old('metode_pembayaran', $booking->metode_pembayaran) == 'cash' ? 'selected' : '' }}>Tunai</option>
                            <option value="e-wallet" {{ old('metode_pembayaran', $booking->metode_pembayaran) == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                        @error('metode_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-image me-2"></i>Upload Bukti Transfer/Pembayaran Baru (opsional)</label>
                        <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" 
                               accept="image/*">
                        @error('bukti_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah bukti pembayaran</small>
                        
                        @if(!empty($booking->bukti_pembayaran))
                            <div class="mt-3">
                                <label class="form-label">Bukti Pembayaran Saat Ini:</label>
                                <img src="{{ asset('storage/payments/' . $booking->bukti_pembayaran) }}" 
                                     class="preview-image" alt="Bukti Pembayaran">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-warning w-100 mt-4">
                        <i class="fas fa-save me-2"></i>Update Booking
                    </button>
                </form>

                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary w-100 mt-3">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ================== FOOTER ================== --}}
@include('partials-pelanggan.footer')
{{-- =========================================== --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

