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
                <h5 class="mb-0" style="color: #f7f9fa;">Announcement List</h5>
                <a href="{{ route('admin.pengumuman') }}" class="btn btn-light btn-sm">
                    + Add Announcement
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Expires At</th>
                                <th width="160">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($announcements as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $item->title }}</div>
                                        <small class="text-muted">{{ Str::limit($item->content, 40) }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $badge = [
                                                'Penting' => 'bg-warning text-dark',
                                                'Darurat' => 'bg-danger',
                                                'Info' => 'bg-info text-white',
                                                'Umum' => 'bg-secondary'
                                            ][$item->category] ?? 'bg-light';
                                        @endphp
                                        <span class="badge {{ $badge }}">{{ $item->category }}</span>
                                    </td>
                                    <td>{{ $item->expires_at ? \Carbon\Carbon::parse($item->expires_at)->format('d M Y') : 'Permanent' }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                             <button class="btn btn-primary btn-sm btn-edit" data-id="{{ $item->id }}">Edit</button>
                                             <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No announcements found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $announcements->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:white; padding:25px; border-radius:10px; width:350px; text-align:center;">
            <h5>Confirm Delete</h5>
            <p>Are you sure you want to delete this announcement?</p>
            <div style="margin-top:20px; display:flex; justify-content:center; gap:10px;">
                <button id="btnCancel" class="btn btn-secondary btn-sm">Cancel</button>
                <button id="btnConfirmDelete" class="btn btn-danger btn-sm">Delete Now</button>
            </div>
        </div>
    </div>

    <div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
        <div style="background:white; padding:25px; border-radius:10px; width:450px;">
            <h5 class="text-center">Edit Announcement</h5>
            <form id="editForm" method="POST" style="margin-top:15px;">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="mb-3">
                    <label class="fw-bold">Title</label>
                    <input type="text" id="edit_title" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Category</label>
                    <select id="edit_category" name="category" class="form-select" required>
                        <option value="Info">Info</option>
                        <option value="Penting">Penting</option>
                        <option value="Darurat">Darurat</option>
                        <option value="Umum">Umum</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Expiry Date</label>
                    <input type="date" id="edit_expires_at" name="expires_at" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Content</label>
                    <textarea id="edit_content" name="content" class="form-control" rows="4" required></textarea>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" id="btnEditCancel" class="btn btn-outline-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    @include('components.script')
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    /* ====================== DELETE LOGIC ======================= */
    let confirmModal = document.getElementById("confirmModal");
    let deleteId = null;

    document.querySelectorAll(".btn-delete").forEach(btn => {
        btn.addEventListener("click", function() {
            deleteId = this.dataset.id;
            confirmModal.style.display = "flex";
        });
    });

    document.getElementById("btnCancel").addEventListener("click", () => confirmModal.style.display = "none");

    document.getElementById("btnConfirmDelete").addEventListener("click", function() {
        fetch(`{{ url('admin/announcements/delete') }}/${deleteId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ _method: "DELETE" })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) window.location.reload();
            else alert("Failed to delete!");
        });
    });

    /* ====================== EDIT LOGIC ======================= */
    let editModal = document.getElementById("editModal");

    document.querySelectorAll(".btn-edit").forEach(btn => {
        btn.addEventListener("click", function() {
            let id = this.dataset.id;
            fetch(`{{ url('admin/announcements/databy') }}/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById("edit_id").value = data.id;
                document.getElementById("edit_title").value = data.title;
                let categoryFromDb = data.category; 
                let selectEl = document.getElementById("edit_category");
                Array.from(selectEl.options).forEach(option => {
                    if (option.value.toLowerCase() === categoryFromDb.toLowerCase()) {
                        option.selected = true;
                    }
                });
                document.getElementById("edit_expires_at").value = data.expires_at;
                document.getElementById("edit_content").value = data.content;
                editModal.style.display = "flex";
            });
        });
    });

    document.getElementById("btnEditCancel").addEventListener("click", () => editModal.style.display = "none");
    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();
        let id = document.getElementById('edit_id').value;
        let formData = new FormData(this);

        fetch(`{{ url('admin/announcements/update') }}/${id}`, {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) window.location.reload();
            else alert("Update failed!");
        });
    });

    /* Alert Auto-close */
    setTimeout(() => {
        let alert = document.getElementById("alertSuccess");
        if(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
});
</script>
</body>
</html>