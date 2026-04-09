<!DOCTYPE html>
<html lang="en">

<head>
  <style>
  /* Menjamin kartu memiliki tinggi yang seragam */
  .kegiatanSwiper .service-item {
    display: flex;
    flex-direction: column;
    height: 100%;
    background: #fff;
    padding: 30px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    transition: 0.3s;
  }
 
  /* Posisi navigasi agar tidak keluar container */
  .kegiatanSwiper {
    padding: 20px 10px 50px 10px;
  }

  .kegiatanSwiper .swiper-button-next,
  .kegiatanSwiper .swiper-button-prev {
    color: #444; /* Sesuaikan warna tema */
    top: 50%;
  }

  /* Container utama kartu */
  .service-item {
    display: flex;
    flex-direction: column;
    height: 100%; /* Memaksa kartu luar sama tinggi */
    background: #fff;
    padding: 15px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    position: relative;
  }

  /* 1. Menyamakan Ukuran Gambar */
  .img-box {
    width: 100%;
    height: 200px; /* Atur tinggi gambar di sini */
    overflow: hidden;
    border-radius: 12px;
  }

  .img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
  }

  /* 2. Menyamakan Kotak Putih (Details) */
  .service-item .details {
    margin-top: -60px; /* Menarik kotak putih ke atas menutupi gambar */
    padding: 40px 20px 20px 20px;
    background: #fff;
    border-radius: 12px;
    margin-left: 15px;
    margin-right: 15px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    
    /* Flexbox untuk konten di dalam kotak putih */
    display: flex;
    flex-direction: column;
    flex-grow: 1; /* Ini yang membuat kotak putih memanjang ke bawah jika teks sedikit */
  }

  /* Memastikan judul punya space yang sama (misal 2 baris) */
  .service-item h3 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 15px;
    min-height: 3em; /* Menjaga agar judul yang 1 baris tidak merusak layout */
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Menyamakan tinggi deskripsi */
  .service-item p {
    font-size: 0.9rem;
    color: #666;
    margin: 0;
    flex-grow: 1; /* Mendorong konten jika ada ruang kosong */
  }

  /* 3. Posisi Ikon Oranye agar Presisi */
  .service-item .icon {
    width: 60px;
    height: 60px;
    background: #ff4500; /* Warna oranye sesuai gambar */
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    border: 4px solid #fff;
    position: absolute;
    top: 110px; /* Menyesuaikan posisi ikon agar di tengah garis potong */
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
  }
  
  .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;  
      overflow: hidden;
      min-height: 3em;
  }

/* Menargetkan wadah gambar di dalam Swiper Slide */
.services .kegiatanSwiper .swiper-slide .img-box {
  width: 100%;
  height: 250px; /* Tentukan tinggi seragam di sini. Sesuaikan jika perlu (misalnya: 200px atau 300px). */
  overflow: hidden; /* Memastikan jika gambar asli lebih besar, tidak akan keluar dari kotak */
  border-top-left-radius: 10px; /* Opsional: menyesuaikan dengan desain service-item kamu */
  border-top-right-radius: 10px;
}

/* Menargetkan gambar asli agar mengisi wadah dengan rapi */
.services .kegiatanSwiper .swiper-slide .img-box img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Ini kuncinya: Memotong gambar agar pas tanpa melar/gepeng */
  object-position: center; /* Memastikan bagian tengah gambar selalu terlihat */
  display: block;
}

/* Memastikan kartu 'service-item' memiliki tinggi penuh di dalam slide */
.services .service-item {
  display: flex;
  flex-direction: column;
  height: 100%;
  background: #fff; /* Pastikan ada background agar terlihat seragam */
  box-shadow: 0px 0 25px rgba(0, 0, 0, 0.1); /* Opsional: Menambahkan bayangan */
  border-radius: 10px; /* Opsional: Menambahkan lengkungan sudut */
}

/* Menata bagian detail di bawah gambar */
.services .service-item .details {
  padding: 20px;
  flex-grow: 1; /* Membuat bagian teks mengisi sisa ruang yang tersedia */
}

.btn-readmore {
    background: none;
    border: none;
    color: #f82249; /* Samakan dengan tema warna websitemu */
    font-weight: 600;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: 0.3s;
}

.btn-readmore:hover {
    color: #c81b3a;
    letter-spacing: 0.5px;
}
</style>
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

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="#" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">SP Jtrust Bank</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">Profile</a></li>
          <li><a href="#services">Kegiatan</a></li>
          <li><a href="#portfolio">Galery</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="cta-btn" href="{{ route('login') }}">Login/Register</a>

    </div>
</header>

<main class="main">

<!-- Hero Section -->
<section id="hero" class="hero section dark-background">
  <img src="{{ asset('frontendpartials/assets/img/corporate1.jpg') }}" class="hero-bg" alt="" data-aos="fade-in">
  <div class="container d-flex flex-column align-items-center">
    <h2 data-aos="fade-up" data-aos-delay="100">PLAN. SOLIDARITY. GROW.</h2>
    <p data-aos="fade-up" data-aos-delay="200">Kami adalah serikat pekerja yang berdedikasi untuk melindungi, memperjuangkan, dan meningkatkan kesejahteraan seluruh anggota.</p>
    <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
      <a href="#about" class="btn-get-started">Get Started</a>
      <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center">
        <i class="bi bi-play-circle"></i><span>Watch Video</span>
      </a>
    </div>
  </div>

</section>
<!-- /Hero Section -->

<!-- About Section -->
<section id="about" class="about section">

  <div class="container">

    <div class="row gy-4">
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
        <h3>Profile</h3>
        <img src="{{ asset('frontendpartials/assets/img/about.jpg') }}" class="img-fluid rounded-4 mb-4" alt="">
        <p>{{ $compro[0]->profile_description }}
        </p>
      </div>

        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
        <div class="content ps-0 ps-lg-5">
            <h4 class="mb-3">Visi</h4>
            <p class="fst-italic">
           {{ $compro[0]->visi }}
            </p>
            <h4 class="mt-4 mb-3">Misi</h4>
            <ul>
              @if(is_array($compro[0]->misi) || is_object($compro[0]->misi))
                  @foreach($compro[0]->misi as $misi)
                      <li>
                          <i class="bi bi-check-circle-fill"></i> {{ $misi }}
                      </li>
                  @endforeach
              @else
                  <li><i class="bi bi-check-circle-fill"></i> {{ $compro[0]->misi }}</li>
              @endif
            </ul>
            <div class="position-relative mt-4">
            <img src="{{ asset('frontendpartials/assets/img/about-2.jpg') }}"
                class="img-fluid rounded-4" alt="Tentang Kami">
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
            </div>

        </div>
        </div>

    </div>

  </div>

</section>
<!-- /About Section -->
     <!-- Stats Section -->
    <section id="stats" class="stats section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="bi bi-person-check-fill color-blue flex-shrink-0"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                <p>Pengurus</p>
              </div>
            </div>
          </div><!-- End Stats Item -->
          <div class="col-lg-4 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="bi bi-people-fill color-orange flex-shrink-0"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
                <p>Anggota</p>
              </div>
            </div>
          </div><!-- End Stats Item -->
          <div class="col-lg-4 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="bi bi-headset color-green flex-shrink-0"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="1463" data-purecounter-duration="1" class="purecounter"></span>
                <p>Pengaduan</p>
              </div>
            </div>
          </div><!-- End Stats Item -->
        </div>
      </div>
    </section>
<!-- /Stats Section -->

<section id="services" class="services section">

  <div class="container section-title" data-aos="fade-up">
    <h2>Kegiatan</h2>
    <p>Kegiatan & Program Kerja Serikat Pekerja</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="swiper kegiatanSwiper pb-5"> 
      <div class="swiper-wrapper">

        @foreach($kegiatan as $item)
        <div class="swiper-slide">
          <div class="service-item h-100">
            <div class="img-box">
              @if($item->photo)
                <img src="{{ asset('frontendpartials/assets/img/gallery/' . $item->photo) }}" alt="{{ $item->title }}">
              @else
                <img src="{{ asset('frontendpartials/assets/img/news/default.jpeg') }}" alt="Default Image">
              @endif
            </div>
            <div class="details">
              <div class="icon">
                <i class="bi {{ $item->icon ?? 'bi-activity' }}"></i>
              </div>
              <h3>{{ $item->title }}</h3>
              <small class="text-muted">{{ \Carbon\Carbon::parse($item->event_date)->format('d M Y') }}</small>
              <p>{{ Str::limit($item->description, 80) }}</p>
              <button type="button" class="btn-readmore" data-bs-toggle="modal" data-bs-target="#modalKegiatan{{ $item->id }}">
                  Read More <i class="bi bi-book"></i>
              </button>
            </div>
          </div>
        </div>
        @endforeach

      </div>

      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>
    @foreach($kegiatan as $item)
      <div class="modal fade" id="modalKegiatan{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalLabel{{ $item->id }}">{{ $item->title }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-md-5">
                      <img src="{{ asset('frontendpartials/assets/img/gallery/' . $item->photo) }}" class="img-fluid rounded shadow-sm">
                  </div>
                  <div class="col-md-7">
                      <div class="mb-3">
                          <span class="badge bg-primary">{{ $item->category }}</span>
                          <span class="text-muted ms-2 small"><i class="bi bi-calendar-event"></i> {{ $item->event_date }}</span>
                      </div>
                      <h5>Deskripsi Kegiatan:</h5>
                      <p style="white-space: pre-line;">{{ $item->description }}</p>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>

  <!-- Section Berita Title -->
  <section class="news-section py-5">
      <div class="container">
          <div class="d-flex justify-content-between align-items-end mb-4">
              <div>
                  <small class="text-uppercase fw-bold" style="color: #ff4500; letter-spacing: 2px;">Update Terbaru</small>
                  <h2 class="fw-bold mt-2">BERITA & INFORMASI</h2>
              </div>
              <a href="{{ route('news.index') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4">Lihat Semua Berita</a>
          </div>

          <div class="row g-4">
              @foreach($news as $item)
              <div class="col-md-4">
                  <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                      <div class="position-relative">
                          <div style="width: 100%; height: 220px; overflow: hidden;">
                              <img src="{{ asset('frontendpartials/assets/img/news/' . $item->gambar) }}" 
                                  class="card-img-top" 
                                  alt="{{ $item->judul }}"
                                  style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                          </div>
                          
                          @if($item->is_important)
                              <span class="badge position-absolute top-0 start-0 m-3 py-2 px-3" style="background: #ff4500; z-index: 10;">Penting</span>
                          @endif
                      </div>
                      
                      <div class="card-body p-4 d-flex flex-column">
                          <div class="d-flex align-items-center mb-2 text-muted small">
                              <i class="bi bi-calendar3 me-2"></i> 
                              {{ \Carbon\Carbon::parse($item->created_date)->format('d M Y') }}
                              <span class="mx-2">|</span>
                              <i class="bi bi-person me-2"></i>Admin
                          </div>
                          
                          <h5 class="card-title fw-bold mb-3">
                              <a href="{{ route('news.show', $item->slug) }}" class="text-decoration-none text-dark line-clamp-2">
                                  {{ $item->judul }}
                              </a>
                          </h5>
                          
                          <p class="card-text text-muted small mb-4">
                              {{ Str::limit(strip_tags($item->isi), 90) }}
                          </p>

                          <div class="mt-auto">
                            <a href="javascript:void(0)" class="fw-bold text-decoration-none" style="color: #ff4500;" data-bs-toggle="modal" data-bs-target="#modalNews{{ $item->id }}">
                              Read More <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                          </div>
                      </div>
                  </div>
              </div>
              @endforeach
          </div>
      @foreach($news as $item) {{-- Ganti $news sesuai variabel dari controller kamu --}}
      <div class="modal fade" id="modalNews{{ $item->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                  
                  <div class="modal-header border-0 pb-0">
                      <h5 class="modal-title fw-bold" style="color: #333;">{{ $item->judul }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body p-4">
                      <div class="row">
                          <div class="col-lg-5 mb-3">
                              @if($item->gambar)
                                  <img src="{{ asset('frontendpartials/assets/img/news/' . $item->gambar) }}" 
                                      class="img-fluid rounded shadow-sm w-100" 
                                      alt="{{ $item->judul }}">
                              @else
                                  <img src="{{ asset('frontendpartials/assets/img/news/default.jpg') }}" class="img-fluid rounded">
                              @endif
                              
                              <div class="mt-3 small text-muted">
                                  <p class="mb-1"><i class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::parse($item->created_date)->format('d M Y') }}</p>
                                  <p class="mb-0"><i class="bi bi-person me-2"></i>Oleh: Admin</p>
                              </div>
                          </div>

                          <div class="col-lg-7">
                              @if($item->is_important)
                                  <span class="badge bg-danger mb-2">Penting</span>
                              @endif
                              
                              <div class="content-text" style="line-height: 1.7; color: #555; max-height: 400px; overflow-y: auto; padding-right: 10px;">
                                  {!! $item->isi !!} 
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="modal-footer border-0">
                      <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 5px;">Tutup</button>
                  </div>
              </div>
          </div>
      </div>
      @endforeach
      </div>
  </section>

  <!-- End Section Title -->

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Galery</h2>
        <p>CHECK OUR GALERY PHOTOS</p>
      </div><!-- End Section Title -->
      <div class="container">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <li data-filter=".filter-app">App</li>
            <li data-filter=".filter-product">Product</li>
            <li data-filter=".filter-branding">Branding</li>
            <li data-filter=".filter-books">Books</li>
          </ul><!-- End Portfolio Filters -->
          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/app-1.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>App 1</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/app-1.jpg')}}" title="App 1" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/product-1.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Product 1</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/product-1.jpg')}}" title="Product 1" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/branding-1.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Branding 1</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/branding-1.jpg')}}" title="Branding 1" data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-books">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/books-1.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Books 1</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/books-1.jpg')}}" title="Branding 1" data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/app-2.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>App 2</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/app-2.jpg')}}" title="App 2" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/product-2.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Product 2</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/product-2.jpg')}}" title="Product 2" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/branding-2.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Branding 2</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/branding-2.jpg')}}" title="Branding 2" data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-books">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/books-2.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Books 2</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/books-2.jpg')}}" title="Branding 2" data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/app-3.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>App 3</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/app-3.jpg')}}" title="App 3" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/product-3.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Product 3</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/product-3.jpg')}}" title="Product 3" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/branding-3.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Branding 3</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/branding-3.jpg')}}" title="Branding 2" data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-books">
              <div class="portfolio-content h-100">
                <img src="{{ asset('frontendpartials/assets/img/portfolio/books-3.jpg')}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Books 3</h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="{{ asset('frontendpartials/assets/img/portfolio/books-3.jpg')}}" title="Branding 3" data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

          </div><!-- End Portfolio Container -->

        </div>

      </div>

    </section><!-- /Portfolio Section -->
        <!-- Contact Section -->
    <section id="contact" class="contact section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>silakan menghubungi kami melalui kontak di bawah ini</p>
      </div><!-- End Section Title -->
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-12 ">
            <div class="row gy-4">
              <div class="col-lg-12">
                <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="200">
                  <i class="bi bi-geo-alt"></i>
                  <h3>Address</h3>
                  <p>{{$compro[0]->address}}</p>
                </div>
              </div><!-- End Info Item -->
              <div class="col-md-6">
                <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-telephone"></i>
                  <h3>Call Us</h3>
                  <p>Phone {{$compro[0]->phone}} or whatsapp {{$compro[0]->whatsapp}}</p>
                </div>
              </div><!-- End Info Item -->
              <div class="col-md-6">
                <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-envelope"></i>
                  <h3>Email Us</h3>
                  <p>{{$compro[0]->email}}</p>
                </div>
              </div><!-- End Info Item -->
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Contact Section -->

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.kegiatanSwiper', {
      speed: 600,
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false
      },
      slidesPerView: 'auto', // Default jika tidak kena breakpoint
      spaceBetween: 30,
      pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 20
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 20
        },
        1200: {
          slidesPerView: 3,
          spaceBetween: 30
        }
      }
    });
  });
</script>

</body>
</html>
