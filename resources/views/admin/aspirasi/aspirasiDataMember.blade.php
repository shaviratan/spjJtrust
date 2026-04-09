<!DOCTYPE html>
<html lang="zxx">

<head>
    @include('layouts.head')
<style>
    .pagination svg, nav[role="navigation"] svg, .pagination .w-5, .pagination .h-5 {
        width: 18px !important;
        height: 18px !important;
        stroke-width: 2 !important;
    }
    .modal { z-index: 10055 !important; }
    .modal-backdrop { z-index: 10050 !important; }
    .table-responsive {
        overflow: visible !important;
    }
    
    .card-body.p-0 {
        overflow: visible !important;
    }
    .dropdown-menu {
        z-index: 1050 !important;
    }
    .btn-group .dropdown-toggle-split {
        padding-right: 0.7rem;
        padding-left: 0.7rem;
    }
</style>
</head>

<body>
    @include('components.sidebar')
    @include('components.header')

    <main class="nxl-container">
        <div class="nxl-content">

            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <h4 class="page-header-title">Manajemen Aspirasi & Pengaduan</h4>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="Pending">Menunggu</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Daftar Masuk</h5>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Pengirim</th>
                                            <th>Tipe & Kategori</th>
                                            <th>Subjek</th>
                                            <th>Status</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($aspirasi as $item)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                            <td>
                                                @if($item->is_anonymous)
                                                    <span class="badge bg-soft-secondary text-secondary">Anonim</span>
                                                @else
                                                    <div class="fw-bold">{{ $item->user_name }}</div>
                                                    <small class="text-muted">{{ $item->email }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-soft-primary text-primary">{{ $item->type }}</span><br>
                                                <small class="text-muted">{{ $item->category }}</small>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;">
                                                    <strong>{{ $item->subject }}</strong><br>
                                                    <small>{{ Str::limit($item->description, 50) }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($item->status == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($item->status == 'Diproses')
                                                    <span class="badge bg-info">Diproses</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <button class="btn btn-sm d-flex align-items-center gap-1" 
                                                            onclick="showDetail({{ $item->id }})" 
                                                            style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; border: none; padding: 5px 12px; border-radius: 6px;">
                                                        <i class="bi bi-eye-fill"></i> Detail
                                                    </button>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light-brand dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @if($item->status != 'Diproses')
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="openStatusModal({{ $item->id }}, 'Diproses')">
                                                                    <i class="bi bi-arrow-repeat me-2"></i> Proses Laporan
                                                                </a>
                                                            </li>
                                                            @endif.
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="openStatusModal({{ $item->id }}, 'Selesai')">
                                                                    <i class="bi bi-check-circle me-2"></i> Tandai Selesai
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $aspirasi->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Aspirasi & Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small text-muted d-block">Jenis & Kategori</label>
                            <span id="det-type" class="badge"></span>
                            <span id="det-category" class="ms-1 fw-bold"></span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <label class="small text-muted d-block">Tanggal Masuk</label>
                            <span id="det-date" class="fw-bold"></span>
                        </div>
                        <hr>
                        <div class="col-12">
                            <label class="small text-muted d-block">Pengirim</label>
                            <p id="det-sender" class="fw-bold mb-0"></p>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted d-block">Subjek</label>
                            <p id="det-subject" class="fw-bold mb-0"></p>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted d-block">Isi Pesan</label>
                            <div class="p-3 bg-light rounded" id="det-description" style="white-space: pre-line;"></div>
                        </div>
                        <div class="col-12" id="section-attachment">
                            <label class="small text-muted d-block">Lampiran</label>
                            <div id="det-attachment"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formUpdateStatus" action="{{ route('admin.aspirasi.updateStatus') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="status-id">
                    <input type="hidden" name="status" id="status-value">
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="status-title">Update Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan / Tanggapan Admin</label>
                            <textarea name="admin_response" class="form-control" rows="4" placeholder="Berikan catatan atau alasan perubahan status..." required></textarea>
                            <small class="text-muted">Catatan ini akan dapat dilihat oleh pengirim aspirasi.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btn-submit-status">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.script')\

<script>
let myModal = null;
function showDetail(id) {
    const modalElement = document.getElementById('detailModal');
    if (!myModal) {
        myModal = new bootstrap.Modal(modalElement, {
            focus: false,
            backdrop: 'static'
        });
    }
    fetch(`{{ url('member/aspirasi/detail') }}/${id}`)
        .then(response => {
            if (!response.ok) throw new Error('Data tidak ditemukan');
            return response.json();
        })
        .then(data => {
            document.getElementById('det-type').innerText = data.type.toUpperCase();
            document.getElementById('det-type').className = data.type === 'Pengaduan' ? 'badge bg-danger' : 'badge bg-info';
            document.getElementById('det-category').innerText = `| ${data.category}`;
            document.getElementById('det-date').innerText = new Date(data.created_at).toLocaleString('id-ID');
            document.getElementById('det-sender').innerText = data.is_anonymous ? 'ANONIM' : (data.user_name || data.nik);
            document.getElementById('det-subject').innerText = data.subject;
            document.getElementById('det-description').innerText = data.description;
            const attachmentBox = document.getElementById('section-attachment');
            const attachmentDiv = document.getElementById('det-attachment');
            if (data.attachment) {
                attachmentBox.style.display = 'block';
                attachmentDiv.innerHTML = `<a href="{{ asset('uploads/aspirasi') }}/${data.attachment}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-arrow-down"></i> Lihat Lampiran</a>`;
            } else {
                attachmentBox.style.display = 'none';
            }

            myModal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data: ' + error.message);
        });
}

let statusModal = null;
function openStatusModal(id, status) {
    const modalElement = document.getElementById('statusModal');
    if (!statusModal) {
        statusModal = new bootstrap.Modal(modalElement);
    }
    document.getElementById('status-id').value = id;
    document.getElementById('status-value').value = status;
    const title = document.getElementById('status-title');
    const btn = document.getElementById('btn-submit-status');
    if (status === 'Diproses') {
        title.innerText = 'Proses Laporan Aspirasi';
        btn.className = 'btn btn-warning text-dark';
        btn.innerText = 'Mulai Proses';
    } else {
        title.innerText = 'Selesaikan Laporan Aspirasi';
        btn.className = 'btn btn-success';
        btn.innerText = 'Selesaikan';
    }

    statusModal.show();
}
</script>
    </body>
</html>