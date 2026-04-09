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
                <h3 class="fw-bold mb-0">Manajemen User</h3>
                <p class="text-muted">Kelola data pengguna sistem di sini.</p>
            </div>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah User
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
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Role / Jabatan</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td class="fw-bold">{{ $user->fullname }}</td>
                                <td>{{ $user->email }}</td> <td>
                                    @if($user->role == 1)
                                        <span class="badge bg-soft-primary text-primary">Admin</span>
                                    @elseif($user->role == 2)
                                        <span class="badge bg-soft-info text-info">Member</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-success">Aktif</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-icon btn-light"><i class="bi bi-pencil" data-bs-toggle="modal" data-bs-target="#modalEditUser" data-id="{{ $user->id }}" data-role="{{ $user->role }}"data-name="{{ $user->fullname }}">></i></button>
                                    <button type="button" class="btn btn-sm btn-icon btn-light text-danger btn-delete" data-id="{{ $user->id }}" data-name="{{ $user->fullname }}"><i class="bi bi-trash"></i></button>
                                    <button type="button" class="btn btn-sm btn-icon btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalResetPassword" data-id="{{ $user->id }}"data-name="{{ $user->fullname }}"><i class="bi bi-key"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data user.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTambahUserLabel">Tambah User Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIK</label>
                        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                            placeholder="Masukkan nama NIK" value="{{ old('nik') }}" required>
                        @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                            placeholder="Masukkan nama user" value="{{ old('name') }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                            placeholder="nama@email.com" value="{{ old('email') }}" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor WhatsApp / HP</label>
                        <div class="input-group">
                            <select name="kode_negara" class="form-select" style="max-width: 100px;">
                                <option value="+62" {{ old('kode_negara') == '+62' ? 'selected' : '' }}>🇮🇩 +62</option>
                                <option value="+60" {{ old('kode_negara') == '+60' ? 'selected' : '' }}>🇲🇾 +60</option>
                            </select>
                            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                                placeholder="812345678xx" value="{{ old('no_hp') }}" required>
                        </div>
                        <small class="text-muted d-block mt-1">Jika mengetik "0812...", angka "0" otomatis terhapus.</small>
                        @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role / Akses</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Member</option>
                        </select>
                        @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                            placeholder="Minimal 8 karakter" required>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Role User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditUser" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama User</label>
                        <input type="text" id="edit_name" class="form-control bg-light" readonly>
                        <small class="text-muted">Nama tidak dapat diubah.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role / Akses</label>
                        <select name="role" id="edit_role" class="form-select" required>
                            <option value="1">Admin</option>
                            <option value="2">Member</option>
                        </select>
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

<!-- DELETE -->
 <form id="form-delete-{{ $user->id }}" 
      action="{{ route('admin.users.delete', $user->id) }}" 
      method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<!-- RESET PASSWORD USER -->
<div class="modal fade" id="modalResetPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Reset Password User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formResetPassword" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Mereset password untuk: <strong id="reset_name"></strong></p>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('components.script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Logika Auto-Open Modal jika ada Error Validasi
        @if ($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('modalTambahUser'));
            myModal.show();
        @endif
        // 2. Logika Input HP (Hanya Angka & Hapus 0 di depan)
        const inputNoHp = document.getElementById('no_hp');
        if(inputNoHp) {
            inputNoHp.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }
                this.value = value;
            });
        }
        // Edit 
        const modalEdit = document.getElementById('modalEditUser');
        if (modalEdit) {
            modalEdit.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const role = button.getAttribute('data-role');
                const name = button.getAttribute('data-name');
                const form = modalEdit.querySelector('#formEditUser');
                const inputName = modalEdit.querySelector('#edit_name');
                const selectRole = modalEdit.querySelector('#edit_role');
                form.action = "{{ url('admin/users/update') }}/" + id;
                inputName.value = name;
                selectRole.value = role;
            });
        }
    });
const deleteButtons = document.querySelectorAll('.btn-delete');
deleteButtons.forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "User " + name + " akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        });
    });
});
// Reset Password
const modalReset = document.getElementById('modalResetPassword');
if (modalReset) {
    modalReset.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        
        const form = modalReset.querySelector('#formResetPassword');
        const textName = modalReset.querySelector('#reset_name');

        form.action = "{{ url('admin/users/reset-password') }}/" + id; 
        textName.textContent = name;
    });
}
</script>

</body>
</html>