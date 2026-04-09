<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.head')
</head>
<body>
    @include('components.sidebar')
    @include('components.header')

<main class="nxl-container">
    <div class="container py-5">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Input Berita Baru</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Berita</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan judul..." value="{{ old('title') }}">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori / Status</label>
                        <select name="status" class="form-select">
                            <option value="draft">Draft (Simpan saja)</option>
                            <option value="published">Publish (Tayangkan)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_urgent" id="isUrgent" value="1" {{ old('is_urgent') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="isUrgent">
                                🚨 Tandai sebagai Berita Penting / Headline
                            </label>
                        </div>
                        <small class="text-muted">Berita ini akan muncul di bagian utama atau memiliki label khusus.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Berita</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="10">{{ old('content') }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Unggulan</label>
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Format: JPG, PNG. Maksimal 2MB.</small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="reset" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Form
                        </button>
                        
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                            Simpan & Terbitkan <i class="bi bi-send ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
    @include('components.script')
</body>
</html>