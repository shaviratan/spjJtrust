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

<div class="modal fade" id="modalEditRole" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditRole" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Edit Role & Access</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- ROLE -->
                    <div class="mb-3">
                        <label>Nama Role</label>
                        <input type="text" name="role_name" id="edit_role_name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" id="edit_description" class="form-control"></textarea>
                    </div>

                    <!-- ACCESS -->
                    <div class="mb-3">
                        <label class="fw-bold">Hak Akses</label>

                        <div style="max-height:300px; overflow:auto;">
                            @foreach($menus as $menu)
                                <div class="border p-2 mb-2">

                                    <!-- MENU -->
                                    <label>
                                        <input type="checkbox"
                                            class="menu-checkbox"
                                            name="menus[]"
                                            value="{{ $menu->id }}">
                                        <b>
                                            <i class="{{ $menu->icon }}"></i>
                                            {{ $menu->name }}
                                        </b>
                                    </label>

                                    <!-- SUBMENU -->
                                    @foreach($menu->subMenu as $sub)
                                        <div class="ms-4">
                                            <label>
                                                <input type="checkbox"
                                                    class="submenu-checkbox menu-{{ $menu->id }}"
                                                    name="submenus[]"
                                                    value="{{ $sub->id }}">
                                                {{ $sub->name }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-info text-white">Update</button>
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
        modalEditRole.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const desc = button.getAttribute('data-description');
        // set form action
        const form = document.getElementById('formEditRole');
        form.action = "/admin/role/update/" + id;
        // isi input
        document.getElementById('edit_role_name').value = name;
        document.getElementById('edit_description').value = desc;
        // reset checkbox
        document.querySelectorAll('.menu-checkbox, .submenu-checkbox')
            .forEach(cb => cb.checked = false);
        // ambil access dari blade
        const access = @json($access);
        access.forEach(item => {
            if (item.role_id == id) {
                if (item.menu_id) {
                    let menu = document.querySelector(`input[name="menus[]"][value="${item.menu_id}"]`);
                    if (menu) menu.checked = true;
                }
                if (item.sub_menu_id) {
                    let sub = document.querySelector(`input[name="submenus[]"][value="${item.sub_menu_id}"]`);
                    if (sub) sub.checked = true;
                }
            }
            });
        });

        // auto check submenu saat menu dicentang
        document.querySelectorAll('.menu-checkbox').forEach(menu => {
            menu.addEventListener('change', function() {
                let id = this.value;

                document.querySelectorAll('.menu-' + id).forEach(sub => {
                    sub.checked = this.checked;
                });
            });
        });

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