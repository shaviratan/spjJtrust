<!DOCTYPE html>
<html lang="zxx">

<head>
    @include('layouts.head')
</head>

<body>
    @include('components.sidebar')
    @include('components.header')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <h4 class="page-header-title">Klasifikasi & Statistik Pengaduan</h4>
        </div>
        <div class="row">
            @foreach($rekapKategori as $item)
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 p-3 bg-primary-soft rounded">
                            <i class="bi bi-folder-fill fs-3 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">{{ $item->category }}</h6>
                            <h3 class="mb-0 fw-bold">{{ $item->total }} <small class="fs-6 fw-normal">Laporan</small></h3>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                         @php $totalSemua = $rekapKategori->sum('total'); @endphp
                        <h5 class="mb-0">Tabel Klasifikasi</h5>
                         <span class="badge bg-primary px-3 py-2">Total: {{ $totalSemua }} Data</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kategori / Bidang</th>
                                        <th>Jumlah Laporan</th>
                                        <th>Persentase</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekapKategori as $item)
                                    <tr>
                                        <td><strong>{{ $item->category }}</strong></td>
                                        <td>{{ $item->total }} laporan</td>
                                        <td>
                                            @php $persen = ($item->total / $totalSemua) * 100; @endphp
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-primary" style="width: {{ $persen }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ round($persen, 1) }}% dari total aspirasi</small>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.aspirasi.dataAllByCategory', ['category' => $item->category]) }}" class="btn btn-sm btn-outline-primary">
                                                Lihat Daftar <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
 @include('components.script')
</body>
</html>