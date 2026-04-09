<!DOCTYPE html>
<html lang="zxx">
@include('layouts.head')
<style>
    .btn-check:checked + .btn-outline-light {
        background-color: #ff4500 !important;
        border-color: #ff4500 !important;
        color: white !important;
    }
    .icon-selector-wrapper::-webkit-scrollbar {
        width: 6px;
    }
    .icon-selector-wrapper::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
</style>
<body>
@include('components.sidebar')
@include('components.header')

<main class="nxl-container">
    <div class="card-body p-4">
         @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Judul Kegiatan</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <select name="category" class="form-select" required>
                        <option value="pendidikan">Pendidikan & Pelatihan</option>
                        <option value="advokasi">Advokasi & Hukum</option>
                        <option value="kesejahteraan">Kesejahteraan</option>
                        <option value="sosial">Sosial & Kemanusiaan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal</label>
                    <input type="date" name="event_date" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi Kegiatan</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Tuliskan detail atau ringkasan kegiatan di sini..."required></textarea>
                <div class="form-text">Berikan penjelasan singkat mengenai kegiatan yang didokumentasikan.</div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Icon Kegiatan</label>
                <div class="icon-selector-wrapper border rounded p-3" style="max-height: 200px; overflow-y: auto; background: #f8f9fa;">
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        
                        @php
                            $icons = [
                                // Umum & Navigasi
                                'bi-activity', 'bi-award', 'bi-bank', 'bi-book', 'bi-calendar-event', 'bi-camera', 
                                'bi-chat-dots', 'bi-check-circle', 'bi-cloud-sun', 'bi-cup-hot', 'bi-display', 
                                'bi-envelope', 'bi-eye', 'bi-flag', 'bi-gear', 'bi-geo-alt', 'bi-gift', 
                                'bi-graph-up', 'bi-hand-thumbs-up', 'bi-heart', 'bi-house', 'bi-image', 
                                'bi-info-circle', 'bi-key', 'bi-laptop', 'bi-lightbulb', 'bi-link-45deg', 
                                'bi-list-stars', 'bi-magic', 'bi-map', 'bi-megaphone', 'bi-mic', 'bi-mortarboard', 
                                'bi-music-note', 'bi-newspaper', 'bi-palette', 'bi-paperclip', 'bi-patch-check', 
                                'bi-people', 'bi-calendar-event', 'bi-phone', 'bi-piggy-bank', 'bi-play-circle', 
                                'bi-printer', 'bi-puzzle', 'bi-camera2', 'bi-search', 'bi-shield-check', 
                                'bi-shop', 'bi-star', 'bi-suit-heart', 'bi-sun', 'bi-tag', 'bi-telephone', 
                                'bi-terminal', 'bi-tools', 'bi-trash', 'bi-trophy', 'bi-truck', 'bi-umbrella', 
                                'bi-unlock', 'bi-vector-pen', 'bi-wallet2', 'bi-watch', 'bi-wrench',

                                // Pendidikan & Kantor
                                'bi-archive', 'bi-clock', 'bi-file-earmark-person', 'bi-briefcase', 'bi-calculator', 
                                'bi-clipboard-data', 'bi-collection', 'bi-compass', 'bi-cpu', 'bi-diagram-3', 
                                'bi-eraser', 'bi-file-earmark-text', 'bi-folder', 'bi-journal-bookmark', 
                                'bi-lamp', 'bi-pencil-square', 'bi-pen', 'bi-sticky', 'bi-table', 'bi-bank',

                                // Sosial & Kemanusiaan
                                'bi-balloon', 'bi-broadcast', 'bi-building', 'bi-capsule', 'bi-cart', 
                                'bi-emoji-smile', 'bi-flower1', 'bi-fuel-pump', 'bi-globe', 'bi-hand-index-thumb', 
                                'bi-heart-fill', 'bi-infinity', 'bi-lungs', 'bi-send', 'bi-patch-question', 
                                'bi-peace', 'bi-box2-heart', 'bi-person-heart', 'bi-tree', 'bi-water',

                                // Media & Teknologi
                                'bi-app-indicator', 'bi-bluetooth', 'bi-cast', 'bi-code-slash', 'bi-balloon-heart', 
                                'bi-earbuds', 'bi-fingerprint', 'bi-gpu-card', 'bi-headset', 'bi-lightning', 
                                'bi-modem', 'bi-mouse', 'bi-pc-display', 'bi-projector', 'bi-qr-code-scan', 
                                'bi-router', 'bi-sim', 'bi-speaker', 'bi-tablet', 'bi-usb-drive', 'bi-wifi',

                                //  Simbol & Aksi
                                'bi-alarm', 'bi-stars', 'bi-bell', 'bi-bicycle', 'bi-box-seam', 'bi-brightness-high', 
                                'bi-bug', 'bi-camera-video', 'bi-cloud-arrow-up', 'bi-command', 'bi-controller', 
                                'bi-credit-card', 'bi-diamond', 'bi-dice-5', 'bi-fire', 'bi-gem', 'bi-hammer', 
                                'bi-hourglass-split', 'bi-layers', 'bi-mask', 'bi-moon', 'bi-optical-audio', 
                                'bi-palette2', 'bi-pin-map', 'bi-plug', 'bi-safe', 'bi-scissors', 'bi-snow', 
                                'bi-speedometer2', 'bi-stopwatch', 'bi-ticket-perforated', 'bi-translate'
                            ];
                        @endphp

                        @foreach($icons as $icon)
                        <div class="icon-option">
                            <input type="radio" class="btn-check" name="icon" id="icon-{{ $icon }}" value="{{ $icon }}" {{ $loop->first ? 'checked' : '' }}>
                            <label class="btn btn-outline-light border text-dark p-2 d-flex align-items-center justify-content-center" 
                                for="icon-{{ $icon }}" 
                                style="width: 45px; height: 45px;" 
                                title="{{ $icon }}">
                                <i class="{{ $icon }} fs-5"></i>
                            </label>
                        </div>
                        @endforeach

                    </div>
                </div>
                <small class="text-muted mt-2 d-block text-center">Scroll ke bawah untuk melihat lebih banyak icon</small>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Pilih Foto (Hanya 1)</label>
                <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                    <i class="bi bi-image fs-1 text-muted"></i>
                    <p class="mb-0 text-muted">Klik untuk pilih foto</p>
                    <small class="text-muted">Format: JPG, PNG, atau JPEG</small>
                    <input type="file" name="photo" id="fileInput" class="d-none" accept="image/*" onchange="previewImages(event)">
                </div>
                <div id="previewWrapper" class="row g-2 mt-3">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-lg text-white" style="background: #ff4500;">
                    <i class="bi bi-cloud-upload me-2"></i>Simpan Semua Foto
                </button>
            </div>
        </form>
    </div>
</main>
@include('components.script')
<script>
    function previewImages(event) {
        const previewWrapper = document.getElementById("previewWrapper");
        previewWrapper.innerHTML = "";
        
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement("div");
                col.className = "col-6 col-md-4 position-relative";
                col.innerHTML = `
                    <div class="ratio ratio-1x1 shadow-sm rounded overflow-hidden">
                        <img src="${e.target.result}" class="img-fluid object-fit-cover" style="object-fit: cover;">
                    </div>
                `;                    
                previewWrapper.appendChild(col);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
</body>
</html>