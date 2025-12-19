@extends('layouts.app')

@section('content')
<main class="pt-90">
<section class="product-detail container py-5">
  <div class="row g-5">

    {{-- ========== CỘT TRÁI: GALLERY ẢNH ========== --}}
    <div class="col-lg-6 mb-4 mb-lg-0">
      <div class="product-gallery text-center border rounded p-3 shadow-sm">
        @php
          $allImages = [];
          if (!empty($product->anh['anh_chinh'])) $allImages[] = $product->anh['anh_chinh'];
          if (!empty($product->anh['anh_phu']) && is_array($product->anh['anh_phu']))
            $allImages = array_merge($allImages, $product->anh['anh_phu']);
        @endphp

        {{-- Ảnh chính --}}
        <div class="main-image mb-3 border rounded overflow-hidden bg-white">
          <img id="mainImage"
               src="{{ asset('assets/' . ltrim($allImages[0] ?? 'images/default.jpg', '/')) }}"
               alt="{{ $product->ten_san_pham }}"
               class="img-fluid rounded"
               style="max-height:500px; object-fit:contain;">
               
        </div>

        {{-- Thumbnail --}}
        <div class="thumbnail-list d-flex justify-content-center gap-2 flex-wrap">
          @foreach($allImages as $img)
            @php
              $imgPath = Str::startsWith($img, ['http://', 'https://'])
                  ? $img
                  : asset('assets/' . ltrim($img, '/'));
            @endphp
            <div class="thumb-item border rounded overflow-hidden"
                 style="width:80px;height:80px;cursor:pointer;"
                 onclick="changeMainImage('{{ $imgPath }}', this)">
              <img src="{{ $imgPath }}" class="w-100 h-100" style="object-fit:cover;">
            </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- ========== CỘT PHẢI: THÔNG TIN SẢN PHẨM ========== --}}
    <div class="col-lg-6">
      <div class="product-info">
        <h2 class="fw-bold mb-3">{{ $product->ten_san_pham }}</h2>

        <div class="d-flex align-items-center mb-3">
          <span class="text-warning fs-5">★★★★★</span>
          <small class="text-muted ms-2">8.000 lượt đánh giá</small>
        </div>

        {{-- Giá --}}
        <div class="product-price mb-3">
          @if($product->gia_khuyen_mai)
            <span class="text-danger fw-bold fs-4">{{ number_format($product->gia_khuyen_mai, 0, ',', '.') }}₫</span>
            <span class="text-muted text-decoration-line-through ms-2">{{ number_format($product->gia, 0, ',', '.') }}₫</span>
          @else
            <span class="fw-bold fs-4">{{ number_format($product->gia, 0, ',', '.') }}₫</span>
          @endif
        </div>

        {{-- Mô tả --}}
        <div class="product-desc mb-4">
          <p class="text-muted">{{ $product->mo_ta ?? 'Chưa có mô tả cho sản phẩm này.' }}</p>
        </div>
        {{-- ========== CHỌN MÀU VÀ KÍCH THƯỚC ========== --}}
@php
  $colors = array_filter(array_map('trim', explode(',', $product->mau_sac ?? '')));
  $sizes = array_filter(array_map('trim', explode(',', $product->kich_thuoc ?? '')));
@endphp

{{-- ========== MÀU SẮC ========== --}}
@if(!empty($colors))
  <div class="product-colors mb-4">
    <label class="d-block fw-semibold mb-2">Màu sắc:</label>
    <div class="d-flex flex-wrap gap-2">
      @foreach($colors as $index => $color)
        @php
          $colorMap = [
            'đen' => '#000000','trắng' => '#ffffff','xám' => '#808080',
            'xanh' => '#003366','đỏ' => '#e74c3c','hồng' => '#f5b7b1',
            'be' => '#f5f5dc','tím' => '#b39ddb','xanh olive' => '#708238',
          ];
          $colorCode = $colorMap[mb_strtolower($color)] ?? '#ccc';
        @endphp

        <button type="button"
                class="color-option border rounded-circle {{ $index === 0 ? 'active' : '' }}"
                data-color="{{ $color }}"
                style="width:32px;height:32px;background-color:{{ $colorCode }};"
                onclick="selectColor(this)"
                title="{{ ucfirst($color) }}">
        </button>
      @endforeach
    </div>
  </div>
@endif

{{-- ========== KÍCH THƯỚC ========== --}}
@if(!empty($sizes))
  <div class="product-sizes mb-4">
    <label class="d-block fw-semibold mb-2">Kích thước:</label>
    <div class="d-flex flex-wrap gap-2">
      @foreach($sizes as $index => $size)
        <button type="button"
                class="size-option btn border rounded px-3 py-2 fw-bold {{ $index === 0 ? 'active' : '' }}"
                data-size="{{ $size }}"
                onclick="selectSize(this)">
          {{ strtoupper($size) }}
        </button>
      @endforeach
    </div>
  </div>
@endif

{{-- Ẩn input để lưu giá trị đã chọn --}}
<input type="hidden" id="selectedColor" value="{{ $colors[0] ?? 'Không rõ' }}">
<input type="hidden" id="selectedSize" value="{{ $sizes[0] ?? 'Không rõ' }}">

       {{-- Nút mua hàng --}}
<div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
  <button type="button" class="btn-buy-now d-flex align-items-center gap-2"
          onclick="buyNow({{ $product->id }})">
    <i class="fa-solid fa-bolt"></i> <span>Mua ngay</span>
  </button>
  <button type="button" class="btn-add-cart d-flex align-items-center gap-2"
          onclick="addToCartAjax({{ $product->id }})">
    <i class="fa-solid fa-cart-plus"></i> <span>Thêm vào giỏ hàng</span>
  </button>

  
</div>

{{-- Yêu thích + chia sẻ + số lượng --}}
<div class="d-flex flex-wrap align-items-center gap-3 mb-4">
  <div class="quantity-control">
    <button type="button" onclick="changeQty(-1)">−</button>
    <input type="number" name="quantity" value="1" min="1" readonly>
    <button type="button" onclick="changeQty(1)">+</button>
  </div>

  <button type="button" class="btn-outline d-flex align-items-center gap-2"
          onclick="navigator.clipboard.writeText('{{ url()->current() }}'); showToast('success','🔗 Đã sao chép link!')">
    <i class="fa-solid fa-share-nodes"></i><span>Chia sẻ</span>
  </button>
</div>


        {{-- Meta --}}
        <div class="product-meta text-muted small">
          <div><strong>Mã sản phẩm:</strong> {{ $product->ma_sp ?? 'N/A' }}</div>
          <div><strong>Danh mục:</strong> {{ $product->ten_danh_muc ?? 'Không rõ' }}</div>
        </div>
      </div>
    </div>
  </div>
</section>


  {{-- ========== TAB CHI TIẾT, BỔ SUNG, ĐÁNH GIÁ ========== --}}
  <div class="product-single__details-tab">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
           href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Mô tả</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab"
           href="#tab-additional-info" role="tab" aria-controls="tab-additional-info" aria-selected="false">
           Thông tin bổ sung
        </a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab"
           href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false">
           Đánh giá 
        </a>
      </li>
    </ul>

    <div class="tab-content">
      {{-- TAB 1: MÔ TẢ --}}
      <div class="tab-pane fade show active" id="tab-description" role="tabpanel">
        <div class="product-single__description">
          <h3 class="block-title mb-4">Tinh tế trong từng đường nét – phong cách từ chất liệu.</h3>
          <p class="content">
            Sản phẩm của <strong>Olivine Fashion</strong> được thiết kế hướng đến sự thoải mái và tự tin cho người mặc.
            Với phom dáng hiện đại, chất vải mềm mại và đường may tỉ mỉ, mỗi chi tiết đều thể hiện sự chỉn chu và tinh thần thời trang đương đại.
          </p>

          <div class="row">
            <div class="col-lg-6">
              <h3 class="block-title">Vì sao nên chọn Olivine Fashion?</h3>
              <ul class="list text-list">
                <li>Chất liệu cotton pha polyester mềm mịn, thoáng khí, phù hợp khí hậu Việt Nam.</li>
                <li>Thiết kế linh hoạt: có thể chọn nhiều size, màu sắc và kiểu dáng khác nhau.</li>
                <li>Được may cắt thủ công, đảm bảo độ bền và form dáng chuẩn.</li>
              </ul>
            </div>

            <div class="col-lg-6">
              <h3 class="block-title mb-0">Thành phần vải (Lining)</h3>
              <ul class="list text-list">
                <li>Chất liệu chính: 100% Polyester.</li>
                <li>Lót trong: 100% Cotton mềm nhẹ, thân thiện với da.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      {{-- TAB 2: THÔNG TIN BỔ SUNG --}}
      <div class="tab-pane fade" id="tab-additional-info" role="tabpanel">
  <div class="product-single__addtional-info">

    <div class="item">
      <label class="h6">Khối lượng</label>
      <span>Khoảng 1.25 kg</span>
    </div>

    <div class="item">
      <label class="h6">Kích thước đóng gói</label>
      <span>90 x 60 x 90 cm</span>
    </div>

    {{-- ========== KÍCH THƯỚC ========== --}}
    @php
        $sizes = array_filter(array_map('trim', explode(',', $product->kich_thuoc ?? '')));
    @endphp
    @if (!empty($sizes))
      <div class="item">
        <label class="h6">Kích thước có sẵn</label>
        <span>{{ implode(', ', $sizes) }}</span>
      </div>
    @endif

    {{-- ========== MÀU SẮC ========== --}}
    @php
        $colors = array_filter(array_map('trim', explode(',', $product->mau_sac ?? '')));
    @endphp
    @if (!empty($colors))
      <div class="item">
        <label class="h6">Màu sắc</label>
        <span>{{ implode(', ', $colors) }}</span>
      </div>
    @endif

    <div class="item">
      <label class="h6">Bảo quản</label>
      <span>Giặt nhẹ ở nhiệt độ dưới 30°C, không tẩy, phơi nơi thoáng mát, ủi ở nhiệt độ thấp.</span>
    </div>

  </div>
</div>



      {{-- TAB 3: ĐÁNH GIÁ --}}
      <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
    <h2 class="product-single__reviews-title">Đánh giá từ khách hàng</h2>

    <div class="product-single__reviews-list">

        @if($reviews->count() > 0)
            @foreach($reviews as $review)
                <div class="product-single__reviews-item">
                    <div class="customer-avatar">
                        <img loading="lazy" src="{{ asset('assets/images/user-default.png') }}" alt="">
                    </div>

                    <div class="customer-review">
                        <div class="customer-name">
                            <h6>{{ $review->name }}</h6>

                            <div class="reviews-group d-flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="review-star" viewBox="0 0 9 9"
                                         style="fill: {{ $i <= $review->rating ? '#ffc107' : '#ccc' }}">
                                        <use href="#icon_star" />
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <div class="review-date">
                            {{ \Carbon\Carbon::parse($review->created_at)->format('d/m/Y') }}
                        </div>

                        <div class="review-text">
                            <p>{{ $review->review }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
        @endif
    </div>

    <div class="product-single__review-form mt-4">
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="rating" id="form-input-rating">

            <h5>Hãy là người đầu tiên đánh giá sản phẩm này!</h5>
            <p>Địa chỉ email của bạn sẽ được bảo mật. Các trường bắt buộc được đánh dấu *</p>

            <div class="form-action mb-4">
                <span class="star-rating" id="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <svg data-value="{{ $i }}" class="star-rating__star-icon"
     width="18" height="18" fill="#ccc" viewBox="0 0 24 24">
     <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 
              1.48 8.276L12 18.896l-7.416 4.514 
              1.48-8.276L0 9.306l8.332-1.151z"/>
</svg>

                    @endfor
                </span>
            </div>

            <script>
                document.querySelectorAll('#rating-stars svg').forEach(star => {
                    star.addEventListener('click', function () {
                        let value = this.getAttribute('data-value');
                        document.getElementById('form-input-rating').value = value;

                        document.querySelectorAll('#rating-stars svg').forEach(s => {
                            s.style.fill = (s.getAttribute('data-value') <= value) ? '#ffc107' : '#ccc';
                        });
                    });
                });
            </script>

            <div class="mb-4">
                <textarea name="review" class="form-control form-control_gray"
                          placeholder="Nhận xét của bạn" cols="30" rows="8" required></textarea>
            </div>

            <div class="form-label-fixed mb-4">
                <label class="form-label">Tên *</label>
                <input name="name" class="form-control form-control-md form-control_gray" required>
            </div>

            <div class="form-label-fixed mb-4">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control form-control-md form-control_gray" required>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input form-check-input_fill" type="checkbox">
                <label class="form-check-label">
                    Lưu tên và email cho lần bình luận tiếp theo.
                </label>
            </div>

            <div class="form-action">
                <button type="submit" class="btn btn-primary">Gửi</button>
            </div>
        </form>
    </div>
</div>

  {{-- ========== SẢN PHẨM LIÊN QUAN ========== --}}
  <section class="related-products container py-5">
    <h2 class="h4 fw-bold text-uppercase mb-4 text-center">
      Sản phẩm <span class="text-primary">liên quan</span>
    </h2>

    <div class="row g-4">
      @forelse($related as $item)
        @php
          $anh = is_array($item->anh) ? $item->anh : json_decode($item->anh ?? '{}', true);
          $anh_chinh = $anh['anh_chinh'] ?? ($anh['anh_phu'][0] ?? 'images/default.jpg');
          $anh_chinh = ltrim($anh_chinh, '/');
        @endphp

        <div class="col-6 col-md-3">
          <div class="card border-0 shadow-sm h-100 product-card position-relative overflow-hidden">
            <a href="{{ route('products.details', $item->id) }}" class="d-block">
              <img src="{{ asset('assets/' . $anh_chinh) }}"
                   onerror="this.src='{{ asset('assets/images/default.jpg') }}';"
                   class="img-fluid w-100 rounded-top"
                   alt="{{ $item->ten_san_pham }}"
                   style="height:250px; object-fit:cover;">

              <button class="btn-wishlist position-absolute top-0 end-0 m-2 btn btn-light btn-sm rounded-circle shadow-sm"
                      data-id="{{ $item->id }}">
                <i class="fa-regular fa-heart"></i>
              </button>
            </a>

            <div class="card-body text-center py-3">
              <h6 class="card-title text-truncate mb-2">{{ $item->ten_san_pham }}</h6>

              <div class="product-card__price">
                @if(!empty($item->gia_khuyen_mai) && $item->gia_khuyen_mai < $item->gia)
                  <span class="text-danger fw-bold">
                    {{ number_format($item->gia_khuyen_mai, 0, ',', '.') }}₫
                  </span>
                  <span class="text-muted text-decoration-line-through small ms-1">
                    {{ number_format($item->gia, 0, ',', '.') }}₫
                  </span>
                @else
                  <span class="fw-bold">{{ number_format($item->gia, 0, ',', '.') }}₫</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center text-muted py-4">
          Không có sản phẩm liên quan nào.
        </div>
      @endforelse
    </div>
  </section>
</main>
{{-- ========== SWIPER & JS ========== --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function changeMainImage(src, el) {
  const main = document.getElementById('mainImage');
  if (!main) return;

  // Nếu ảnh trùng thì không làm gì
  if (main.src === src) return;

  // Hiệu ứng fade-out
  main.classList.add('fade-out');
  setTimeout(() => {
    main.src = src;
    main.classList.remove('fade-out');
  }, 200);

  // Đổi active thumbnail
  document.querySelectorAll('.thumbnail-list .thumb-item')
    .forEach(i => i.classList.remove('active'));
  el.classList.add('active');
}

// Tăng / giảm số lượng sản phẩm
function changeQty(delta) {
  const input = document.querySelector('input[name="quantity"]');
  if (!input) return;
  let value = parseInt(input.value) || 1;
  value = Math.max(1, value + delta);
  input.value = value;
}
</script>

<script>
function getQuantity() {
  const input = document.querySelector('input[name="quantity"]');
  return input ? parseInt(input.value) : 1;
}

function changeQty(delta) {
  const input = document.querySelector('input[name="quantity"]');
  let value = parseInt(input.value);
  value = Math.max(1, value + delta);
  input.value = value;
}

/* === Mua ngay === */
function buyNow(productId) {
  const quantity = getQuantity();
  const color = document.getElementById('selectedColor')?.value || 'Không rõ';
  const size = document.getElementById('selectedSize')?.value || 'Không rõ';

  fetch(`/cart/add`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ product_id: productId, quantity, color, size })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      // ✅ Kiểm tra có đăng nhập hay không (Laravel cung cấp biến toàn cục)
      @if(Auth::check())
        window.location.href = '/checkout';
      @else
        showPopup(true, '🎉 Sản phẩm đã được thêm vào giỏ hàng! Đăng nhập để thanh toán.');
        window.location.href = '/cart';
      @endif
    } else {
      showPopup(false, data.message || 'Không thể mua ngay!');
    }
  })
  .catch(() => showPopup(false, '⚠️ Lỗi hệ thống!'));
}


/* === Thêm vào giỏ === */
function addToCartAjax(productId) {
  const quantity = getQuantity();
  const color = document.getElementById('selectedColor')?.value || 'Không rõ';
  const size = document.getElementById('selectedSize')?.value || 'Không rõ';

  fetch("/cart/add", {
    method: "POST",
    credentials: "same-origin",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      product_id: productId,
      quantity: quantity,
      color: color,
      size: size
    })
  })
  .then(res => res.json())
  .then(data => {
    console.log('🛒 Server trả về:', data);
    if (data.status === "success") {
      showPopup(true, data.message || "🎉 Thêm vào giỏ hàng thành công!");
      // ✅ Cập nhật số lượng trên icon giỏ hàng (nếu có)
      const badge = document.querySelector(".cart-count");
      if (badge) {
        badge.textContent = data.cart_count || parseInt(badge.textContent || 0) + 1;
        badge.classList.remove("d-none");
      }
    } else {
      showPopup(false, data.message || "Không thể thêm vào giỏ hàng.");
    }
  })
  .catch(err => {
    console.error("❌ Lỗi fetch:", err);
    showPopup(false, "Lỗi hệ thống, vui lòng thử lại!");
  });
}


/* === Hiệu ứng rung icon giỏ hàng === */
function animateCartIcon() {
  const icon = document.getElementById('cartIcon');
  if (!icon) return;
  icon.classList.add('cart-shake');
  setTimeout(() => icon.classList.remove('cart-shake'), 600);
}
// ===== POPUP THÔNG BÁO =====
// ===== POPUP SWEETALERT =====
function showPopup(success = true, message = 'Đã thực hiện thành công!') {
  Swal.fire({
    icon: success ? 'success' : 'error',
    title: success ? '🎉 Thông báo' : '❌ Lỗi',
    text: message,
    confirmButtonText: 'Đóng',
    customClass: {
      popup: 'popup-cart-success'
    }
  });
}

function selectColor(btn) {
  document.querySelectorAll('.color-option').forEach(el => el.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('selectedColor').value = btn.dataset.color;

  // Gợi ý hiển thị màu đã chọn
  console.log('Chọn màu:', btn.dataset.color);
}

function selectSize(btn) {
  document.querySelectorAll('.size-option').forEach(el => el.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('selectedSize').value = btn.dataset.size;

  console.log('Chọn size:', btn.dataset.size);
}
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('#rating-stars svg');
    const ratingInput = document.getElementById('form-input-rating');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const rating = this.dataset.value;
            ratingInput.value = rating;

            stars.forEach(s => s.style.fill = '#ccc');

            for (let i = 0; i < rating; i++) {
                stars[i].style.fill = '#ffc107';
            }
        });
    });
});
</script>

@endsection
