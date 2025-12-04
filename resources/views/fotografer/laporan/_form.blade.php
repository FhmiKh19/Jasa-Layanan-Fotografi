@csrf

<div class="mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal', $laporan->tanggal ?? date('Y-m-d')) }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="judul" value="{{ old('judul', $laporan->judul ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Ringkasan</label>
    <textarea name="ringkasan" class="form-control" rows="5" required>{{ old('ringkasan', $laporan->ringkasan ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Foto Kegiatan (opsional)</label>
    <input type="file" name="foto_kegiatan" accept="image/*" class="form-control">
    @if(!empty($laporan->foto_kegiatan))
        <div class="mt-2">
            <img src="{{ asset('storage/' . $laporan->foto_kegiatan) }}" alt="foto" style="max-width:200px">
        </div>
    @endif
</div>

<button class="btn btn-primary">Simpan</button>
