<!DOCTYPE html>

<html>
<head>
    <title>Data Fotografer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

```
<div class="container">
    <h2 class="mb-4">Data Fotografer</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('fotografer.create') }}" class="btn btn-primary mb-3">+ Tambah Fotografer</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Fotografer</th>
                <th>Username</th>
                <th>No HP</th>
                <th>Status Akun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fotografer as $f)
            <tr>
                <td>{{ $f->id_pengguna }}</td>
                <td>{{ $f->nama_pengguna }}</td>
                <td>{{ $f->username }}</td>
                <td>{{ $f->no_hp }}</td>
                <td>{{ $f->status_akun }}</td>
                <td>
                    <a href="{{ route('fotografer.edit', $f->id_pengguna) }}" class="btn btn-warning btn-sm">Edit</a>
                    
                    <form action="{{ route('fotografer.delete', $f->id_pengguna) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

</body>
</html>
