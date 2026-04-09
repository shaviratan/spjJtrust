<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SP Jtrust</title>

  <!-- Favicons -->
  <link href="{{ asset('frontendpartials/assets/img/spjlogo.png') }}" rel="icon">
  <link href="{{ asset('frontendpartials/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('frontendpartials/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontendpartials/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontendpartials/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('frontendpartials/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontendpartials/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('frontendpartials/assets/css/main.css') }}" rel="stylesheet">

</head>

<body class="index-page">

<header id="header" class="header d-flex align-items-center fixed-top dark-background" style="background-color: #495057ab">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="#" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">SP Jtrust Bank</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}" class="active">Home</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="cta-btn" href="{{ route('login') }}">Login/Register</a>

    </div>
</header>

<main class="main" style="margin-top: 100px;"> <div class="container section-title" data-aos="fade-up">
    <h2>Semua Berita</h2>
    <p>Daftar lengkap berita Serikat Pekerja Jtrust Bank</p>
  </div>

  <div class="container">
    <div class="row gy-4">
      @foreach($news as $item)
      <div class="col-xl-4 col-md-6" data-aos="fade-up">
        <article class="service-item position-relative h-100 shadow-sm border rounded p-3">
          
          <div class="post-img position-relative overflow-hidden rounded mb-3">
            @if($item->gambar)
              <img src="{{ asset('frontendpartials/assets/img/news/' . $item->gambar) }}" class="img-fluid" alt="{{ $item->judul }}">
            @else
              <img src="{{ asset('frontendpartials/assets/img/news/default.jpg') }}" class="img-fluid">
            @endif
          </div>

          <div class="post-content">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary small">{{ $item->status }}</span>
                <small class="text-muted"><i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($item->created_date)->format('d M Y') }}</small>
            </div>

            <h3 class="post-title h5 fw-bold">{{ $item->judul }}</h3>
            
            <p class="text-secondary small">
                {{ Str::limit(strip_tags($item->isi), 120) }}
            </p>

            <hr>

            <a href="javascript:void(0)" 
               class="readmore fw-bold text-decoration-none" 
               style="color: #ff4500;" 
               data-bs-toggle="modal" 
               data-bs-target="#modalBerita{{ $item->id }}">
               Baca Selengkapnya <i class="bi bi-arrow-right"></i>
            </a>
          </div>

        </article>
      </div>
      @endforeach
    </div>

    @foreach($news as $item)
<div class="modal fade" id="modalBerita{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 15px; border: none; overflow: hidden;">
      
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="modalLabel{{ $item->id }}">{{ $item->judul }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <div class="row">
          <div class="col-lg-5 mb-3">
            @if($item->gambar)
              <img src="{{ asset('frontendpartials/assets/img/news/' . $item->gambar) }}" class="img-fluid rounded shadow-sm w-100" alt="{{ $item->judul }}">
            @else
              <img src="{{ asset('frontendpartials/assets/img/news/default.jpg') }}" class="img-fluid rounded">
            @endif
            
            <div class="mt-3 p-3 bg-light rounded">
                <p class="mb-1 small text-muted"><i class="bi bi-calendar3 me-2"></i> {{ \Carbon\Carbon::parse($item->created_date)->format('d F Y') }}</p>
                <p class="mb-0 small text-muted"><i class="bi bi-person me-2"></i> Post by: Admin</p>
            </div>
          </div>

          <div class="col-lg-7">
            <span class="badge bg-primary mb-3">{{ $item->status }}</span>
            <div class="content-detail" style="max-height: 450px; overflow-y: auto; line-height: 1.8; color: #444;">
                {{-- Gunakan {!! !!} jika isi berita mengandung tag HTML --}}
                {!! $item->isi !!}
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>
@endforeach

    <div class="d-flex justify-content-center mt-5">
        {{ $news->links('pagination::bootstrap-5') }}
    </div>
  </div>

</main>

<footer id="footer" class="footer dark-background">

  <div class="container copyright text-center mt-4">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">Serikat Pekerja Jtrust</strong> <span>All Rights Reserved</span></p>
  </div>

</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Vendor JS Files -->
<script src="{{ asset('frontendpartials/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontendpartials/assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('frontendpartials/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('frontendpartials/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('frontendpartials/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('frontendpartials/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('frontendpartials/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('frontendpartials/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('frontendpartials/assets/js/main.js') }}"></script>

</body>
</html>