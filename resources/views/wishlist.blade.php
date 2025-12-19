@extends('layouts.app')

@section('content')
<main class="pt-90">
  <section class="container py-5">
    <h2 class="page-title mb-4 fw-bold text-center">SẢN PHẨM YÊU THÍCH</h2>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4" id="wishlist-container">
      @forelse($wishlistItems as $product)
        @php
            $anhData = is_string($product->anh ?? null)
                ? json_decode($product->anh, true)
                : (is_array($product->anh ?? null) ? $product->anh : []);

            $anh_chinh = $anhData['anh_chinh'] ?? ($anhData['anh_phu'][0] ?? 'images/default.jpg');
        @endphp

        <div class="col wishlist-item" id="wishlist-item-{{ $product->id }}">
          <div class="card border-0 shadow-sm h-100 product-card position-relative overflow-hidden">

            {{-- Link đến chi tiết sản phẩm --}}
            <a href="{{ route('products.details', $product->id) }}" class="d-block">
              <div class="position-relative">
                <img 
                  src="{{ asset('assets/' . ltrim($anh_chinh, '/')) }}" 
                  class="card-img-top product-image" 
                  alt="{{ $product->ten_san_pham }}"
                  onerror="this.src='{{ asset('assets/images/default.jpg') }}'">
              </div>
            {{-- Thông tin sản phẩm --}}
            <div class="card-body text-center">
              <h6 class="fw-semibold mb-1 text-truncate">{{ $product->ten_san_pham }}</h6>

              @php
                  $gia = $product->gia ?? 0;
                  $gia_km = $product->gia_khuyen_mai ?? null;
              @endphp

              @if($gia_km && $gia_km < $gia)
                  <p class="text-danger fw-bold mb-0">
                      {{ number_format($gia_km, 0, ',', '.') }}₫
                      <span class="text-muted text-decoration-line-through ms-1">
                          {{ number_format($gia, 0, ',', '.') }}₫
                      </span>
                  </p>
              @else
                  <p class="fw-bold mb-0">{{ number_format($gia, 0, ',', '.') }}₫</p>
              @endif
            </div>
   </a>
          </div>
        </div>
      @empty
        <div class="col-12 text-center text-muted">
          <p>Không có sản phẩm yêu thích nào.</p>
        </div>
      @endforelse
    </div>
  </section>
</main>

@endsection
