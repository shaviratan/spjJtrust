<!DOCTYPE html>
<html lang="zxx">

@include('layouts.head')

<body>

    @include('components.sidebar')
    @include('components.header')

    <main class="nxl-container">
        <div class="nxl-content">

            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <h4 class="page-header-title" >Tambah Anggota</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">

                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"  style="color: #f7f9fa;">Form Tambah Anggota</h5>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importModal" data-bs-backdrop="static"> Import Excel</button>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card-body">
                            <form action="{{ route('anggota.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" placeholder="Nomor Induk Karyawan" value="{{ old('nik') }}" required>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </main>

<!-- Pop Up Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.anggota.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <p class="mb-1">Silakan unduh template jika belum memiliki format yang sesuai:</p>
                        <a href="{{ route('admin.anggota.template') }}" class="btn btn-sm btn-outline-info">
                             <i class="bi bi-download"></i> Download Template CSV
                        </a>
                    </div>
                    
                    <div class="mb-3 mt-3">
                        <label class="form-label">Pilih File Excel/CSV</label>
                        <input type="file" name="file_excel" class="form-control" required accept=".xlsx, .xls, .csv">
                        <small class="text-danger">*Peringatan: Data lama akan dihapus semua!</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload & Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
    @include('components.script')

</body>
</html>
