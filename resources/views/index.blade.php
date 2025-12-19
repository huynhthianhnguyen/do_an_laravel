@extends('layouts.app')
@section('content')
<main>
<section class="collections-slider">
    <div class="swiper collectionsSwiper">
        <div class="swiper-wrapper">
            @foreach ($collections as $collection)
                <div class="swiper-slide">
                    <div class="collection-hero d-flex align-items-center">
                        <div class="container-fluid px-5">
                            <div class="row align-items-center justify-content-between flex-md-row">
                                <!-- Text bên trái -->
                               <div class="col-md-3 col-12 hero-text text-md-start text-center">
    <p class="text-uppercase text-muted small mb-2">Bộ sưu tập</p>
    <h1 class="fw-bold mb-4">{{ $collection->ten_bo_suu_tap }}</h1>
   <a href="{{ route('showcollection', $collection->id) }}" class="btn hero-btn">
      Xem chi tiết
    </a>
  </div>

                                <!-- Ảnh bên phải -->
                                <div class="col-md-9 col-12 text-center">
    <img src="{{ asset('assets/' . $collection->anh_dai_dien) }}" 
         alt="{{ $collection->ten_bo_suu_tap }}" 
         class="hero-image img-fluid rounded-3 shadow-sm">
        

  </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Nút điều hướng -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- 🔥 SẢN PHẨM KHUYẾN MÃI -->
<section class="section py-5 bg-light hot-deals">
  <div class="container">
    <div class="row align-items-center">
       <h2 class="h3 mb-4 fw-bold text-center">ƯU ĐÃI HẤP DẪN</h2>
      <!-- Cột bên trái (tiêu đề + nút) -->
     <div class="col-lg-3 text-center text-lg-start mb-4 mb-lg-0">
  <div class="promo-box h-100 d-flex flex-column justify-content-center">
    <h2 class="fw-semibold mb-2">Khuyến mãi mùa hè</h2>
    <h3 class="fw-bold fs-3 mb-3 text-dark">Giảm giá tới 60%</h3>
    <p class="text-muted small mb-4">Nhanh tay sở hữu sản phẩm yêu thích với mức giá siêu ưu đãi.</p>
    <button id="load-more-hot" class="btn btn-dark w-100 fw-semibold py-2 rounded-pill">
      Xem thêm
    </button>
  </div>
</div>


      <!-- Cột bên phải (danh sách sản phẩm) -->
      <div class="col-lg-9">
        <div id="hot-deal-container" class="row g-3">
          @foreach($hotDeals as $product)
            @php
              $anh = json_decode($product->anh ?? '', true);
              $anh_chinh = $anh['anh_chinh'] ?? $anh['anh_phu'][0] ?? 'images/default.jpg';
              $anh_chinh = ltrim($anh_chinh, '/');
            @endphp

            <div class="col-6 col-md-4 col-lg-3">
              <div class="card border-0 shadow-sm h-100 product-card position-relative overflow-hidden">
                <a href="{{ route('products.details', $product->id) }}" class="d-block">
                  <img src="{{ asset('assets/' . $anh_chinh) }}"
                       onerror="this.src='{{ asset('assets/images/default.jpg') }}';"
                       class="img-fluid w-100"
                       alt="{{ $product->ten_san_pham }}"  >
                       <div class="p-2 text-center">
                  <h6 class="fw-semibold text-truncate mb-1">{{ $product->ten_san_pham }}</h6>
                  <div class="text-secondary small">
                    <span class="text-decoration-line-through me-1 text-muted">
                      {{ number_format($product->gia, 0, ',', '.') }}₫
                    </span>
                    <span class="fw-bold text-danger">
                      {{ number_format($product->gia_khuyen_mai, 0, ',', '.') }}₫
                    </span>
                  </div>
                </div>
                </a>
              @php $isFav = in_array($product->id, $wishlistIds ?? []); @endphp
<button 
  class="btn-wishlist position-absolute top-0 end-0 m-2 btn btn-light btn-sm rounded-circle shadow-sm {{ $isFav ? 'active' : '' }}" 
  data-id="{{ $product->id }}">
  <i class="{{ $isFav ? 'fa-solid text-danger' : 'fa-regular' }} fa-heart"></i>
</button>



              </div>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</section>


<!-- DANH MỤC SẢN PHẨM -->
<section class="catogery container py-5">
  <div class="container">
    <h2 class="h3 mb-4 fw-bold text-center">DANH MỤC SẢN PHẨM</h2>

    @php
      $categories = DB::table('danh_muc')->get();
    @endphp

    <div class="row row-cols-2 row-cols-md-5 g-4 justify-content-center">
      @foreach($categories as $cat)
        @php
          // Xử lý đường dẫn ảnh — đảm bảo có "assets/" phía trước
          $imagePath = Str::startsWith($cat->anh_dai_dien, 'assets/')
              ? $cat->anh_dai_dien
              : 'assets/' . ltrim($cat->anh_dai_dien ?? 'images/default.jpg', '/');
        @endphp

        <div class="col text-center">
          <a href="{{ route('shop', ['category' => $cat->id]) }}" class="text-decoration-none text-dark">
            <div class="d-flex flex-column align-items-center">
              <div class="category-icon mb-3" 
                   style="width:120px; height:120px; border-radius:50%; overflow:hidden; border:1px solid #eee;">
                <img src="{{ asset($imagePath) }}" 
                     alt="{{ $cat->ten_danh_muc }}" 
                     class="w-100 h-100 object-fit-cover"
                     onerror="this.src='{{ asset('assets/images/default.jpg') }}';">
              </div>
              <h6 class="fw-semibold mt-2">{{ $cat->ten_danh_muc }}</h6>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- 💎 SẢN PHẨM NỔI BẬT -->
<section class="section py-5 bg-light">
  <div class="container">
    <h2 class="h3 mb-4 fw-bold text-center">Sản phẩm nổi bật</h2>

    <div id="featured-products" class="row row-cols-2 row-cols-md-4 g-4">
      @foreach($featured as $product)
        @php
            $anh = json_decode($product->anh, true);
            $anh_chinh = $anh['anh_chinh'] ?? 'images/default.jpg';
        @endphp
        <div class="col">
          <div class="card border-0 shadow-sm h-100 product-card position-relative overflow-hidden">
            <a href="{{ route('products.details', $product->id) }}" class="d-block">
              <div class="position-relative">
                <img src="{{ asset('assets/' . $anh_chinh) }}"
                     class="card-img-top product-image"
                     alt="{{ $product->ten_san_pham }}">
               <div class="card-body text-center">
              <h6 class="fw-semibold mb-1">{{ $product->ten_san_pham }}</h6>
              @if($product->gia_khuyen_mai)
                  <p class="text-danger fw-bold mb-0">
                      {{ number_format($product->gia_khuyen_mai, 0, ',', '.') }}₫
                      <span class="text-muted text-decoration-line-through ms-1">
                          {{ number_format($product->gia, 0, ',', '.') }}₫
                      </span>
                  </p>
              @else
                  <p class="fw-bold mb-0">{{ number_format($product->gia, 0, ',', '.') }}₫</p>
              @endif
            </div>
              </div>
            </a>
           @php
  $wishlist = session('wishlist', []);
  $isFav = isset($wishlist[$product->id]);
@endphp

<button class="btn-wishlist position-absolute top-0 end-0 m-2 btn btn-light btn-sm rounded-circle shadow-sm {{ $isFav ? 'active' : '' }}"
        data-id="{{ $product->id }}">
  <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
</button> 
          </div>
        </div>
      @endforeach
    </div>

    <!-- Nút tải thêm -->
    <div class="text-center mt-4">
      <button id="load-more" class="btn btn-outline-dark px-4 py-2">Xem thêm</button>
    </div>
  </div>
</section>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Load more sản phẩm nổi bật
  let page = 1;
  const loadMoreBtn = document.getElementById('load-more');
  const container = document.getElementById('featured-products');
  if (!loadMoreBtn) return;

  loadMoreBtn.addEventListener('click', async function () {
    loadMoreBtn.textContent = 'Đang tải...';
    try {
      const res = await fetch(`{{ route('load.more.featured') }}?page=${page + 1}`);
      const html = await res.text();
      if (html.trim()) {
        container.insertAdjacentHTML('beforeend', html);
        page++;
        loadMoreBtn.textContent = 'Tải thêm';
      } else {
        loadMoreBtn.textContent = 'Hết sản phẩm';
        loadMoreBtn.disabled = true;
      }
    } catch {
      loadMoreBtn.textContent = 'Lỗi, thử lại';
    }
  });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  let offset = 4;
  const button = document.getElementById("load-more-hot");
  const container = document.getElementById("hot-deal-container");
  if (!button) return;

  button.addEventListener("click", function() {
    button.disabled = true;
    button.textContent = "Đang tải...";
    fetch(`{{ route('hotdeals.loadMore') }}?offset=${offset}`)
      .then(res => res.text())
      .then(html => {
        if (html.trim()) {
          container.insertAdjacentHTML('beforeend', html);
          offset += 4;
          button.textContent = "Xem thêm";
          button.disabled = false;
        } else {
          button.textContent = "Hết sản phẩm";
          button.disabled = true;
        }
      })
      .catch(() => {
        button.textContent = "Lỗi tải sản phẩm";
        button.disabled = false;
      });
  });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  new Swiper('.collectionsSwiper', {
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });
});
</script>
@endsection

