<!DOCTYPE html>
<html lang="zxx">
@include('layouts.head')
<body>
@include('components.sidebar')
@include('components.header')

<main class="nxl-container">
    <div class="card-body p-4">
        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Judul Kegiatan</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <select name="category" class="form-select" required>
                        <option value="pendidikan">Pendidikan & Pelatihan</option>
                        <option value="advokasi">Advokasi & Hukum</option>
                        <option value="kesejahteraan">Kesejahteraan</option>
                        <option value="sosial">Sosial & Kemanusiaan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal</label>
                    <input type="date" name="event_date" class="form-control" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Pilih Foto (Bisa lebih dari 1)</label>
                <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                    <i class="bi bi-images fs-1 text-muted"></i>
                    <p class="mb-0 text-muted">Klik untuk pilih beberapa foto sekaligus</p>
                    <small class="text-muted">Gunakan tombol <b>Ctrl</b> atau <b>Shift</b> saat memilih gambar</small>
                    <input type="file" name="photos[]" id="fileInput" class="d-none" accept="image/*" multiple onchange="previewImages(event)">
                </div>
                
                <div id="previewWrapper" class="row g-2 mt-3">
                    </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-lg text-white" style="background: #ff4500;">
                    <i class="bi bi-cloud-upload me-2"></i>Simpan Semua Foto
                </button>
            </div>
        </form>
    </div>
</main>
@include('components.script')
<script>
    function previewImages(event) {
        const previewWrapper = document.getElementById("previewWrapper");
        previewWrapper.innerHTML = "";
        if (event.target.files) {
            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement("div");
                    col.className = "col-4 col-md-3 position-relative";

                    col.innerHTML = `
                        <div class="ratio ratio-1x1 shadow-sm rounded overflow-hidden">
                            <img src="${e.target.result}" class="img-fluid object-fit-cover" style="object-fit: cover;">
                        </div>
                    `;                    
                    previewWrapper.appendChild(col);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
</body>
</html>