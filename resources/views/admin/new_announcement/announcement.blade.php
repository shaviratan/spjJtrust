<!DOCTYPE html>
<html lang="zxx">
@include('layouts.head')
<body>
@include('components.sidebar')
@include('components.header')

<main class="nxl-container">   
    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Pengumuman</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('admin.pengumuman.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Pengumuman</label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                            placeholder="Masukkan judul pengumuman" value="{{ old('judul') }}">

                        @error('judul')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Info">Info</option>
                            <option value="Penting">Penting</option>
                            <option value="Darurat">Darurat</option>
                            <option value="Umum">Umum</option>
                        </select>
                        @error('kategori')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Pengumuman</label>
                        <textarea name="isi" rows="5" class="form-control @error('isi') is-invalid @enderror"
                                placeholder="Tulis isi pengumuman">{{ old('isi') }}</textarea>
                        @error('isi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Berakhir</label>
                        <input type="date" name="tanggal_berakhir" class="form-control @error('tanggal_berakhir') is-invalid @enderror" 
                            value="{{ old('tanggal_berakhir') }}">
                        <small class="text-muted">Kosongkan jika pengumuman berlaku selamanya.</small>
                        
                        @error('tanggal_berakhir')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <button class="btn btn-primary w-100">Simpan Pengumuman</button>
                </form>
            </div>
        </div>
    </div>
@include('components.script')
</main>

</body>
</html>