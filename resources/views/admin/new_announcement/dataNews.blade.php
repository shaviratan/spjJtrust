<!DOCTYPE html>
<html lang="en">

<style>
    .pagination svg, nav[role="navigation"] svg, .pagination .w-5, .pagination .h-5 {
        width: 18px !important;
        height: 18px !important;
        stroke-width: 2 !important;
    }
    #editModal, #confirmModal {
        z-index: 10050 !important;
    }
</style>

@include('layouts.head')

<body>

@include('components.sidebar')
@include('components.header')

<main class="nxl-container">
    <div class="container mt-4">
        @if (session('success'))
            <div id="alertSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: #f7f9fa;">News List</h5>
                <a href="{{ route('admin.berita') }}" class="btn btn-light btn-sm">
                    + Add News
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th width="160">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $item->judul }}</div>
                                        <small class="text-muted">{{ Str::limit($item->isi, 40) }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $badge = [
                                                'archived' => 'bg-warning text-dark',
                                                'draft' => 'bg-info text-white',
                                                'published' => 'bg-success'
                                            ][$item->status] ?? 'bg-light';
                                        @endphp
                                        <span class="badge {{ $badge }}">{{ $item->status }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                             <button class="btn btn-primary btn-sm btn-edit" data-id="{{ $item->id }}">Edit</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No News found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>

<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div style="background:white; padding:25px; border-radius:10px; width:1000px; max-width:90%; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
        <h5 class="text-center mb-4">Edit Berita</h5>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="edit_id" name="id">
            
            <div class="mb-3">
                <label class="fw-bold">Judul Berita</label>
                <input type="text" id="edit_judul" name="judul" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Status</label>
                <select id="edit_status" name="status" class="form-select" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Isi Berita</label>
                <textarea id="edit_isi" name="isi" class="form-control" rows="6" required></textarea>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Gambar Berita</label>
                <input type="file" id="edit_gambar" name="gambar" class="form-control" accept="image/*">
            </div>

            <div class="mb-3 text-center">
                <img id="preview_gambar" 
                    src="" 
                    style="max-width: 200px; display:none; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.2);" />
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" id="btnEditCancel" class="btn btn-outline-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

    

    @include('components.script')
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let editModal = document.getElementById("editModal");
    let editForm = document.getElementById("editForm");
    document.querySelectorAll(".btn-edit").forEach(btn => {
        btn.addEventListener("click", function() {
            let id = this.dataset.id;
            fetch(`{{ url('admin/news/databy') }}/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById("edit_id").value = data.id;
                document.getElementById("edit_judul").value = data.judul;
                document.getElementById("edit_isi").value = data.isi;
                let statusSelect = document.getElementById("edit_status");
                statusSelect.value = data.status;
                let preview = document.getElementById("preview_gambar");
                if (data.gambar) {
                    preview.src = `/frontendpartials/assets/img/news/${data.gambar}`;
                    preview.style.display = "block";
                } else {
                    preview.style.display = "none";
                }
                editModal.style.display = "flex";  
            })
            .catch(err => alert("Gagal mengambil data"));
        });
    });
    document.getElementById("btnEditCancel").addEventListener("click", () => {
        editModal.style.display = "none";
    });
    editForm.addEventListener('submit', function (e) {
        e.preventDefault();
        let id = document.getElementById('edit_id').value;
        let formData = new FormData(this);
        fetch(`{{ url('admin/news/update') }}/${id}`, {
            method: "POST",
            headers: { 
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert("Update gagal: " + (data.message || "Terjadi kesalahan"));
            }
        })
        .catch(err => alert("Terjadi kesalahan jaringan"));
    });
    document.getElementById("edit_gambar").addEventListener("change", function(e) {
    let file = e.target.files[0];
    let preview = document.getElementById("preview_gambar");

    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        }
        reader.readAsDataURL(file);
    }
    });
});
</script>
</body>
</html>