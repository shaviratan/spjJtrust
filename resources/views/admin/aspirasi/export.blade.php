<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.head')
</head>
<body>
    @include('components.sidebar')
    @include('components.header')

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold">Laporan Pengaduan</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.laporan.excel', request()->query()) }}" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.laporan.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.aspirasi.filtering') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Dari Tanggal</label>
                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Sampai Tanggal</label>
                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="category" class="form-control">
                                <option value="">Semua Kategori</option>
                                <option value="Kesejahteraan" {{ request('category') == 'Kesejahteraan' ? 'selected' : '' }}>Kesejahteraan</option>
                                <option value="Hubungan Industrial" {{ request('category') == 'Hubungan Industrial' ? 'selected' : '' }}>Hubungan Industrial</option>
                                <option value="Fasilitas" {{ request('category') == 'Fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                                <option value="Lainnya" {{ request('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                            <a href="{{ route('admin.aspirasi.filtering') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tgl</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Tipe</th>
                                    <th>Kategori</th>
                                    <th>Subjek</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aspirasi as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->subject }}</td>
                                    <td>
                                        <span class="badge {{ $item->status == 'Pending' ? 'bg-warning' : 'bg-success' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Data tidak ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('components.script')
</body>
</html>