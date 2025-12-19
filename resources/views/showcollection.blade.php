@extends('layouts.app')
@section('content')
<main class="pt-90">
  <section class="container mb-5">
    
    {{-- Ảnh đại diện bộ sưu tập --}}
    <div class="mb-4 text-center">
      <img src="{{ asset('assets/' . $collection->anh_dai_dien) }}" 
     alt="{{ $collection->ten_bo_suu_tap }}" 
     class="img-fluid rounded shadow-sm w-100"
      style="max-width: 100%; height: auto; object-fit: contain;">
    </div>

    {{-- Tên và mô tả --}}
    <div class="text-center mb-5">
      <h1 class="fw-bold">{{ $collection->ten_bo_suu_tap }}</h1>
      <p class="text-muted">{{ $collection->mo_ta }}</p>
    </div>

  {{-- Danh sách sản phẩm trong bộ sưu tập --}}
<div class="masonry-gallery">
  @forelse($products as $product)
   @php
  $images = is_array($product->anh) 
      ? $product->anh 
      : json_decode($product->anh ?? '{}', true);

  $mainImg = isset($images['anh_chinh']) 
      ? asset('assets/' . $images['anh_chinh']) 
      : asset('assets/images/no-image.png');
@endphp

    <a href="{{ route('products.details', $product->id) }}" class="masonry-item">
      <img src="{{ $mainImg }}" alt="{{ $product->ten_san_pham }}">
    </a>
  @empty
    <p class="text-center text-muted">Chưa có sản phẩm nào trong bộ sưu tập này.</p>
  @endforelse
</div>



  </section>
</main>
@endsection
