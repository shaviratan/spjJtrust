<!DOCTYPE html>
<html lang="zxx">

@include('layouts.head')

<body>

    @include('components.sidebar')
    @include('components.header')

    <main class="nxl-container">
        <div class="nxl-content">

            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <h4 class="page-header-title">Aspirasi & Pengaduan</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-white">Kirim Aspirasi Baru</h5>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card-body">
                            <form action="{{ route('member.aspirasi.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Jenis Laporan</label>
                                    <select name="type" name = "type" class="form-control" required>
                                        <option value="Saran">Saran / Masukan</option>
                                        <option value="Pengaduan">Pengaduan / Keluhan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="category" class="form-control" required>
                                        <option value="Kesejahteraan">Kesejahteraan & Benefit</option>
                                        <option value="Hubungan Industrial">Hubungan Industrial / PKB</option>
                                        <option value="Fasilitas">Fasilitas & Lingkungan Kerja</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Subjek</label>
                                    <input type="text" name="subject" class="form-control" placeholder="Judul singkat..." required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Isi Pesan</label>
                                    <textarea name="description" class="form-control" rows="4" placeholder="Detail aspirasi Anda..." required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Lampiran <small class="text-muted">(Opsional)</small></label>
                                    <input type="file" name="attachment" class="form-control" accept=".jpg,.png,.pdf">
                                </div>

                                <!-- <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_anonymous" value="1" id="anonCheck" style="cursor: pointer;">
                                        <label class="form-check-label fw-bold" for="anonCheck" style="cursor: pointer;">
                                            Kirim Sebagai ANONIM
                                        </label>
                                    </div>
                                </div>
                                <div id="anonNotice" class="alert alert-info border-0 shadow-sm" style="display: none;">
                                    <div class="d-flex">
                                        <i class="bi bi-incognito fs-4 me-3"></i>
                                        <div>
                                            <strong>Mode Anonim Aktif:</strong><br>
                                            Anda memilih mode pengiriman anonim jadi para pengurus tidak mengetahui identitas anda tetapi anda dapat memantau status aspirasi anda.
                                        </div>
                                    </div>
                                </div> -->

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary w-100">Kirim Aspirasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('components.script')

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const anonCheck = document.getElementById('anonCheck');
        const anonNotice = document.getElementById('anonNotice');
        anonCheck.addEventListener('change', function() {
            if (this.checked) {
                // Tampilkan keterangan dengan efek sederhana
                anonNotice.style.display = 'block';
            } else {
                // Sembunyikan keterangan
                anonNotice.style.display = 'none';
            }
        });
    });
    </script>

</body>
</html>