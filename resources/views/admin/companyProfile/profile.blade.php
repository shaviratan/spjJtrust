<!DOCTYPE html>
<html lang="en">

@include('layouts.head')

<body>

@include('components.sidebar')
@include('components.header')

<main class="nxl-container">
<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-gear-fill me-2"></i>Maintenance Profil & Visi Misi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST') 
                <div class="row">
                    <div class="col-lg-6 border-end">
                        <h6 class="fw-bold text-primary mb-3">Bagian Profil</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Profil</label>
                            <textarea name="profile_description" class="form-control" rows="6" required>{{ old('profile_description', $data->profile_description ?? '') }}</textarea>
                            <div class="form-text">Jelaskan tentang organisasi secara singkat dan padat.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Profil Utama</label>
                            <input type="file" name="profile_image" class="form-control mb-2" accept="image/*">
                            @if(isset($data->profile_image))
                                <img src="{{ asset('storage/' . $data->profile_image) }}" class="img-thumbnail" width="200">
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h6 class="fw-bold text-primary mb-3">Visi & Misi</h6>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Visi</label>
                            <textarea name="visi" class="form-control" rows="3" required>{{ old('visi', $data->visi ?? '') }}</textarea>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-flex justify-content-between">
                                Poin-poin Misi
                                <button type="button" class="btn btn-sm btn-outline-success" id="add-misi">
                                    <i class="bi bi-plus"></i> Tambah Misi
                                </button>
                            </label>
                            <div id="misi-wrapper">
                                @if(isset($data->misi) && count($data->misi) > 0)
                                    @foreach($data->misi as $key => $m)
                                    <div class="input-group mb-2 misi-item">
                                        <span class="input-group-text bg-light"><i class="bi bi-check-circle"></i></span>
                                        <input type="text" name="misi[]" class="form-control" value="{{ $m }}" required>
                                        <button class="btn btn-outline-danger remove-misi" type="button"><i class="bi bi-trash"></i></button>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 misi-item">
                                        <span class="input-group-text bg-light"><i class="bi bi-check-circle"></i></span>
                                        <input type="text" name="misi[]" class="form-control" placeholder="Masukkan poin misi..." required>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Video Thumbnail (Preview)</label>
                            <input type="file" name="video_thumbnail" class="form-control mb-2" accept="image/*">
                            <div class="form-text">Gambar yang akan muncul sebagai cover video di halaman depan.</div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top d-flex justify-content-end align-items-center">
                    <button type="reset" class="btn btn-light px-4 me-2">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
    @include('components.script')
</main>

<script>
    // Script dinamis untuk menambah/menghapus input Misi
    document.getElementById('add-misi').addEventListener('click', function() {
        const wrapper = document.getElementById('misi-wrapper');
        const newItem = document.createElement('div');
        newItem.className = 'input-group mb-2 misi-item';
        newItem.innerHTML = `
            <span class="input-group-text bg-light"><i class="bi bi-check-circle"></i></span>
            <input type="text" name="misi[]" class="form-control" placeholder="Masukkan poin misi..." required>
            <button class="btn btn-outline-danger remove-misi" type="button"><i class="bi bi-trash"></i></button>
        `;
        wrapper.appendChild(newItem);
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-misi')) {
            e.target.closest('.misi-item').remove();
        }
    });
</script>

</body>
</html>