<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Booking Fotografer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #4e342e 0%, #6d4c41 45%, #8d6e63 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            padding: 20px 0;
        }
        .booking-card {
            max-width: 520px;
            width: 100%;
            border-radius: 20px;
            background: #fffaf5;
            box-shadow: 0 20px 50px rgba(62, 39, 35, 0.35);
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
            border-color: #8d6e63;
            box-shadow: 0 0 0 0.2rem rgba(141, 110, 99, 0.35);
        }
        .btn-primary {
            background: linear-gradient(135deg, #5d4037 0%, #a1887f 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-edit {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            transition: transform 0.2s;
        }
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
            color: white;
        }
        .btn-secondary {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }
        .booking-info {
            background: #fff5ed;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #666;
        }
        .info-value {
            color: #333;
        }
        .preview-image {
            max-width: 100%;
            border-radius: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

{{-- ================== NAVBAR ================== --}}
@include('partials.navbar')
{{-- ============================================ --}}

<div class="container">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="booking-card">
            <div class="booking-header">
                <h3><i class="fas fa-calendar-check me-2"></i>Form Booking Fotografer</h3>
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

                {{-- FORM SIMPAN BOOKING --}}
                <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user me-2"></i>Nama Pemesan</label>
                        <input type="text" name="nama_pemesan" class="form-control"
                               placeholder="Masukkan nama pemesan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-clock me-2"></i>Jam Booking</label>
                        <input type="time" name="jam_booking" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-image me-2"></i>Upload Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" class="form-control" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, Max: 2MB</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-4">
                        <i class="fas fa-save me-2"></i>Simpan Booking
                    </button>
                </form>

                {{-- INFO BOOKING YANG SUDAH ADA --}}
                @if(!empty($booking))
                    <div class="booking-info mt-4">
                        <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Booking Anda</h5>
                        
                        <div class="info-item">
                            <span class="info-label">Nama Pemesan:</span>
                            <span class="info-value">{{ $booking->nama_pemesan }}</span>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-label">Jam Booking:</span>
                            <span class="info-value">{{ date('H:i', strtotime($booking->jam_booking)) }}</span>
                        </div>
                        
                        @if(!empty($booking->bukti_transfer))
                            <div class="info-item">
                                <span class="info-label">Bukti Transfer:</span>
                                <img src="{{ asset('storage/' . $booking->bukti_transfer) }}" 
                                     class="preview-image" alt="Bukti Transfer">
                            </div>
                        @endif

                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-edit">
                                <i class="fas fa-edit me-2"></i>Edit Booking
                            </a>
                            
                            <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" class="d-grid">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus booking ini?')">
                                    <i class="fas fa-trash me-2"></i>Hapus Booking
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <a href="{{ route('pesan.fotografer') }}" class="btn btn-secondary w-100 mt-3">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Home
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ================== FOOTER ================== --}}
@include('partials.footer')
{{-- =========================================== --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
