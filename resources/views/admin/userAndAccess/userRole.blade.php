<!DOCTYPE html>
<html lang="zxx">
@include('layouts.head')
<body>
@include('components.sidebar')
@include('components.header')

<main class="nxl-container">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Master Role</h3>
                <p class="text-muted">Kelola hak akses dan tingkatan pengguna.</p>
            </div>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahRole">
                <i class="bi bi-plus-circle me-2"></i>Tambah Role
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Nama Role</th>
                                <th>Deskripsi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($role as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-bold">{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-icon btn-light" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEditRole" 
                                        data-id="{{ $role->id }}" 
                                        data-name="{{ $role->name }}" 
                                        data-description="{{ $role->description }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn btn-sm btn-icon btn-light text-danger btn-delete-role" 
                                        data-id="{{ $role->id }}" 
                                        data-name="{{ $role->name }}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <form id="form-delete-role-{{ $role->id }}" action="{{ route('admin.role.delete', $role->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Data role belum tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalTambahRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Master Role</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.role.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Role</label>
                        <input type="text" name="role_name" class="form-control" placeholder="Administrator / Member" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan kegunaan role ini..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Master Role</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditRole" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Role</label>
                        <input type="text" name="role_name" id="edit_role_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info text-white px-4">Update Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('components.script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Logic Modal Edit: Passing data dari button ke form
        const modalEditRole = document.getElementById('modalEditRole');
        if (modalEditRole) {
            modalEditRole.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const desc = button.getAttribute('data-description');
                
                const form = modalEditRole.querySelector('#formEditRole');
                form.action = "{{ url('admin/role/update') }}/" + id;
                modalEditRole.querySelector('#edit_role_name').value = name;
                modalEditRole.querySelector('#edit_description').value = desc;
            });
        }
        // Logic Delete Confirmation
        document.querySelectorAll('.btn-delete-role').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                Swal.fire({
                    title: 'Hapus Role?',
                    text: "Apakah Anda yakin ingin menghapus role " + name + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-delete-role-' + id).submit();
                    }
                });
            });
        });
    });
</script>
</body>
</html>