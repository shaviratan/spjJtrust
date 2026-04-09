<!DOCTYPE html>
<html lang="zxx">

<style>
    .pagination svg,
    nav[role="navigation"] svg,
    .pagination .w-5,
    .pagination .h-5 {
        width: 18px !important;
        height: 18px !important;
        stroke-width: 2 !important;
    }
    #importModal {
    z-index: 10050 !important; /* Pastikan lebih tinggi dari sidebar atau header */
    }
    .modal-backdrop {
        z-index: 10040 !important;
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
                <h5 class="mb-0" style="color: #f7f9fa;">Data Anggota</h5>
                <a href="{{ route('admin.anggota.export') }}" class="btn btn-info btn-sm text-white"><i class="bi bi-download"></i> Download Data (Excel)</a>
                <a href="{{ route('admin.anggota.tambah') }}" class="btn btn-light btn-sm" >
                    + Tambah Anggota
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Email</th>
                                <th width="140">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($officer as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                             <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $item->id }}">Edit
                                            </button>
                                             <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data anggota</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $officer->links() }}
                </div>

            </div>
        </div>

    </div>
<!-- Pop Up Delete -->
    <div id="confirmModal" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:white; padding:25px; border-radius:10px; width:350px; text-align:center;">
            <h5 style="margin-bottom:15px;">Konfirmasi Hapus</h5>
            <p>Apakah kamu yakin ingin menghapus data ini?</p>

            <div style="margin-top:20px; display:flex; justify-content:center; gap:10px;">
                <button id="btnCancel" class="btn btn-secondary btn-sm">Batal</button>
                <button id="btnConfirmDelete" class="btn btn-danger btn-sm">Hapus</button>
            </div>
        </div>
    </div>
<!-- Pop Up Edit -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div style="background:white; padding:25px; border-radius:10px; width:400px;">
        <h5 class="text-center">Edit Anggota</h5>
        <form id="editForm" method="POST" style="margin-top:15px;">
             @csrf
            <input type="hidden" id="edit_id" name="id">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" id="edit_name" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>NIK</label>
                <input type="text" id="edit_nik" name="nik" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" id="edit_email" name="email" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <button type="button" id="btnEditCancel" class="btn btn-outline-secondary px-4 py-1 rounded-2">Batal</button>
                <button type="submit" class="btn btn-primary px-4 py-1 rounded-2">Simpan</button>
            </div>
        </form>
    </div>
</div>
    @include('components.script')
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
/* ====================== DELETE MODAL ======================= */
    let confirmModal = document.getElementById("confirmModal");
    let btnCancel = document.getElementById("btnCancel");
    let btnConfirmDelete = document.getElementById("btnConfirmDelete");
    let deleteId = null;
    document.querySelectorAll(".btn-delete").forEach(btn => {
        btn.addEventListener("click", function() {
            deleteId = this.dataset.id;
            confirmModal.style.display = "flex";
        });
    });
    btnCancel.addEventListener("click", function() {
        confirmModal.style.display = "none";
        deleteId = null;
    });
    btnConfirmDelete.addEventListener("click", function() {
        fetch(`{{ url('admin/anggota/delete') }}/${deleteId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
                "Accept": "application/json" // 
            },
            body: JSON.stringify({ _method: "DELETE" })
        })
        .then(res => res.json())
        .then(data => {
            confirmModal.style.display = "none";
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert("Gagal menghapus!");
            }
        })
        .catch(err => {
            confirmModal.style.display = "none";
            console.error(err);
            alert("Terjadi kesalahan saat menghapus!");
        });
    });

/* ====================== EDIT MODAL ======================= */
    let editModal = document.getElementById("editModal");
    let btnEditCancel = document.getElementById("btnEditCancel");
    let editId = document.getElementById("edit_id");
    let editName = document.getElementById("edit_name");
    let editNik = document.getElementById("edit_nik");
    let editEmail = document.getElementById("edit_email");
    // CLICK EDIT BUTTON
        document.querySelectorAll(".btn-edit").forEach(btn => {
            btn.addEventListener("click", function() {
                let id = this.dataset.id;
                fetch(`{{ url('admin/anggota/show') }}/${id}`)
                .then(res => res.json())
                .then(data => {
                    editId.value = data.id;
                    editName.value = data.name;
                    editNik.value = data.nik;
                    editEmail.value = data.email;
                    editModal.style.display = "flex";
                })
                .catch(err => console.error("ERROR FETCH DATA:", err));
                        });
        });

    // CANCEL BUTTON
    btnEditCancel.addEventListener("click", function() {
        editModal.style.display = "none";
    });
    // FORM SUBMIT EDIT
    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();
        let id = document.getElementById('edit_id').value; 
        let form = document.getElementById('editForm');
        let formData = new FormData(form);
       fetch(`{{ url('admin/anggota/update') }}/${id}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect; 
            } else {
                alert("Gagal update!");
            }
        })
        .catch(error => {
            console.log(error);
            alert("Terjadi kesalahan");
        });
    });
/* ====================== Close alert 5 detik ======================= */
    let alertBox = document.getElementById("alertSuccess");
    if (alertBox) {
        setTimeout(() => {
            let bsAlert = new bootstrap.Alert(alertBox);
            bsAlert.close();
        }, 5000); // 5 detik
    }
});
</script>



</body>
</html>
