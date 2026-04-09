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
        /* Fix Z-Index agar modal selalu di atas backdrop */
        .modal { z-index: 10055 !important; }
        .modal-backdrop { z-index: 10050 !important; }
    </style>
</head>

<body>
    @include('components.sidebar')
    @include('components.header')

    <main class="nxl-container">
        <div class="container mt-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white"><i class="bi bi-journal-text me-2"></i> RIWAYAT ASPIRASI SAYA</h5>
                    <a href="{{ route('member.aspirasi.index') }}" class="btn btn-light btn-sm">+ Buat Aspirasi Baru</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Subjek</th>
                                    <th class="text-center">Anonim</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($aspirasi as $item)
                                    <tr>
                                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge {{ $item->type == 'Pengaduan' ? 'bg-danger' : 'bg-info' }}">
                                                {{ strtoupper($item->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ $item->subject }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if($item->is_anonymous)
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            @else
                                                <i class="bi bi-x-circle text-muted"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $badgeColor = [
                                                    'Pending' => 'bg-secondary',
                                                    'Diproses' => 'bg-warning text-dark',
                                                    'Selesai' => 'bg-success',
                                                    'Ditolak' => 'bg-danger'
                                                ];
                                            @endphp
                                            <span class="badge {{ $badgeColor[$item->status] ?? 'bg-secondary' }}">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary-soft d-flex align-items-center gap-1 mx-auto" 
                                                    onclick="showDetail({{ $item->id }})" 
                                                    style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; border: none; padding: 5px 12px; border-radius: 6px;">
                                                <i class="bi bi-eye-fill"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data aspirasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $aspirasi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="modal-title fw-bold text-primary">
                        <i class="bi bi-file-earmark-lock2-fill me-2"></i> DATA ASPIRASI
                    </h5>
                    <div>
                        <span class="badge bg-light text-secondary border me-2">READ ONLY</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small d-block">JENIS</label>
                            <span id="det-type" class="badge"></span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <label class="text-muted small d-block">TANGGAL LAPORAN</label>
                            <p id="det-date" class="fw-bold mb-0"></p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">SUBJEK</label>
                        <h5 id="det-subject" class="fw-bold"></h5>
                    </div>
                    <div class="mb-3 p-3 bg-light rounded border">
                        <label class="text-muted small d-block mb-1">DESKRIPSI / ISI LAPORAN</label>
                        <p id="det-description" class="mb-0" style="white-space: pre-wrap;"></p>
                    </div>
                    <div id="section-attachment" class="mb-4" style="display:none;">
                        <label class="text-muted small d-block mb-1">LAMPIRAN</label>
                        <div id="det-attachment"></div>
                    </div>
                    <hr>
                    <div class="p-3 rounded border border-info bg-info bg-opacity-10">
                        <label class="text-primary fw-bold small d-block mb-1">TANGGAPAN ADMIN</label>
                        <p id="det-response" class="mb-0"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @include('components.script')

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
                    document.getElementById('det-date').innerText = new Date(data.created_at).toLocaleString('id-ID');
                    document.getElementById('det-subject').innerText = data.subject;
                    document.getElementById('det-description').innerText = data.description;
                    
                    const attachmentBox = document.getElementById('section-attachment');
                    const attachmentDiv = document.getElementById('det-attachment');
                    if (data.attachment) {
                        attachmentBox.style.display = 'block';
                        attachmentDiv.innerHTML = `<a href="{{ asset('uploads/aspirasi') }}/${data.attachment}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i> Lihat Lampiran</a>`;
                    } else {
                        attachmentBox.style.display = 'none';
                    }

                    const respElement = document.getElementById('det-response');
                    if (data.admin_response) {
                        respElement.innerText = data.admin_response;
                        respElement.classList.remove('text-muted', 'fst-italic');
                        respElement.style.color = ''; 
                    } else {
                        respElement.innerText = "Belum ada tanggapan dari admin.";
                        respElement.classList.add('text-muted', 'fst-italic');
                    }
                    myModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengambil data: ' + error.message);
                });
        }
    </script>
</body>
</html>