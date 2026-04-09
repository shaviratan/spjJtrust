<!DOCTYPE html>
@php
    $pengumuman = [
        (object)[
            'judul' => 'Pemeliharaan Sistem',
            'isi' => 'Aplikasi akan mengalami pemeliharaan pada hari Minggu pukul 22:00 - 23:59.',
            'kategori' => 'Sistem',
            'created_at' => now(),
        ],
        (object)[
            'judul' => 'Update Fitur Baru',
            'isi' => 'Kami telah menambahkan fitur aspirasi baru untuk meningkatkan pelayanan.',
            'kategori' => 'Informasi',
            'created_at' => now()->subDay(),
        ],
    ];
@endphp

<html lang="zxx">

@include('layouts.head')

<body>

@include('components.sidebar')
@include('components.header')

<main class="nxl-container">
    <div class="container mt-5">
        <div class="card shadow-sm border-0 text-center p-5">
            <div class="display-1 mb-3">
                @php
                    $hour = date('H');
                    if ($hour < 12) {
                        $greeting = 'Good Morning';
                        $icon = 'bi-brightness-high-fill text-warning';
                    } elseif ($hour < 12 and $hour >= 18) {
                        $greeting = 'Good Afternoon';
                        $icon = 'bi-sun-fill text-orange';
                    } else {
                        $greeting = 'Good Night';
                        $icon = 'bi-moon-stars-fill text-primary';
                    }
                @endphp
                <i class="bi {{ $icon }}" style="font-size: 100px;"></i>
            </div>
            <h2 class="fw-bold">{{ $greeting }}, {{ Str::upper(Auth::user()->fullname) }}!</h2>
            <p class="text-muted fs-5">Welcome back to your account.</p>
        </div>
    </div>

    <!-- Pengumuman untuk Member -->
    <div class="container mt-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: white;">📢 Pengumuman</h5>
                <span class="badge bg-light text-primary">{{ count($pengumuman ?? []) }} baru</span>
            </div>

            <div class="card-body">
                @if (!empty($pengumuman) && count($pengumuman) > 0)
                    <ul class="list-group list-group-flush">
                        @foreach ($pengumuman as $item)
                            <li class="list-group-item py-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $item->judul }}</h6>
                                        <p class="mb-1 text-muted" style="font-size: 14px;">
                                            {!! nl2br(e($item->isi)) !!}
                                        </p>
                                        <small class="text-secondary">
                                            <i class="bi bi-calendar-event"></i>
                                            {{ date('d M Y', strtotime($item->created_at)) }}
                                        </small>
                                    </div>

                                    <span class="badge bg-info text-dark">
                                        {{ $item->kategori ?? 'Info' }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center mb-0">Belum ada pengumuman terbaru.</p>
                @endif
            </div>
        </div>
    </div>

    @include('components.script')
</main>

</body>
</html>