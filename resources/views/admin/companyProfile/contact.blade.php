<!DOCTYPE html>
<html lang="en">

@include('layouts.head')
<body>
@include('components.sidebar')
@include('components.header')

<main class="nxl-container">
<div class="container py-5">
    @if (session('success'))
        <div id="alertSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-info-circle-fill me-2"></i>Maintenance Identitas Instansi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.identity.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <label class="form-label fw-bold d-block">Logo Instansi</label>
                        <div class="mb-3">
                            @if(isset($data->logo) && $data->logo)
                                <img id="preview-logo" src="{{ asset($data->logo) }}" class="img-thumbnail shadow-sm" style="max-height: 150px; min-width: 150px; object-fit: contain;">
                            @else
                                <div id="placeholder-logo" class="mx-auto border rounded d-flex align-items-center justify-content-center bg-light" style="width: 150px; height: 150px;">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                                <img id="preview-logo" src="" class="img-thumbnail shadow-sm d-none" style="max-height: 150px; min-width: 150px; object-fit: contain;">
                            @endif
                        </div>
                        <div class="d-flex justify-content-center">
                            <input type="file" name="logo" class="form-control" style="max-width: 350px;" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <div class="form-text mt-2">Format: PNG/JPG/JPEG. Max: 2MB.</div>
                    </div>
                </div>

                <hr>

                <div class="row mt-4">
                    <div class="col-lg-6 mb-4 border-end">
                        <h6 class="fw-bold text-primary mb-3">Informasi Umum</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Instansi / Perusahaan</label>
                            <input type="text" name="company_name" class="form-control" 
                                   value="{{ old('company_name', $data->company_name ?? '') }}" 
                                   placeholder="Masukkan Nama Resmi..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Resmi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ old('email', $data->email ?? '') }}" 
                                       placeholder="email@perusahaan.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Kantor</label>
                            <textarea name="address" class="form-control" rows="4" 
                                      placeholder="Jl. Raya Nomor 123..." required>{{ old('address', $data->address ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h6 class="fw-bold text-primary mb-3">Kontak & Media</h6>

                        <div class="mb-3">
                            <label class="form-label fw-bold">WhatsApp (Gunakan kode negara, misal: 62812...)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white"><i class="bi bi-whatsapp"></i></span>
                                <input type="text" name="whatsapp" class="form-control" 
                                       value="{{ old('whatsapp', $data->whatsapp ?? '') }}" 
                                       placeholder="628xxxxxxxxxx" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Telepon Kantor (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="phone" class="form-control" 
                                       value="{{ old('phone', $data->phone ?? '') }}" 
                                       placeholder="021-xxxxxxx">
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <small><i class="bi bi-info-circle me-1"></i> Data ini akan tampil secara otomatis di bagian <strong>Footer</strong> dan halaman <strong>Kontak</strong> Landing Page Anda.</small>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end align-items-center">
                    <button type="reset" class="btn btn-light px-4 me-2">Batal</button>
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
    @include('components.script')
</main>
<script>
function previewImage(input) {
    const preview = document.getElementById('preview-logo');
    const placeholder = document.getElementById('placeholder-logo');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if(placeholder) placeholder.classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>