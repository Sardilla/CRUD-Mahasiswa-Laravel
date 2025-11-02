<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-primary fw-bold">📋 Daftar Mahasiswa</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('mahasiswa.cetakPdf') }}" target="_blank" class="btn btn-danger">
                    🧾 Cetak PDF
                </a>
                <a href="{{ route('mahasiswa.exportExcel') }}" class="btn btn-outline-success">
                    🧾 Export Excel
                </a>
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-success">
                    ➕ Tambah Mahasiswa
                </a>
            </div>
        </div>

        <!-- 🔍 Form Pencarian -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('mahasiswa.index') }}" method="GET" class="d-flex align-items-center">
                    <input type="text" 
                           name="search" 
                           class="form-control me-2" 
                           placeholder="Cari nama, NIM, atau email..." 
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        🔍 Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary ms-2">
                            🔄 Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Table Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswa as $index => $m)
                            <tr>
                                <td class="text-center">{{ $mahasiswa->firstItem() + $index }}</td>
                                <td>{{ $m->nama }}</td>
                                <td>{{ $m->nim }}</td>
                                <td>{{ $m->email }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('mahasiswa.edit', $m->id) }}" class="btn btn-warning btn-sm">
                                            ✏ Edit
                                        </a>
                                        <form action="{{ route('mahasiswa.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                🗑 Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data mahasiswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- 🔢 Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $mahasiswa->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
