@extends('layouts.app')

@section('content')
<main class="pt-0" style="padding-top:100px;">
  <section class="shop-main container pt-0">
    <form id="filterForm" method="GET" action="{{ route('shop') }}">
      {{-- Giữ lại các query string cũ --}}
      @foreach(request()->except(['color','size','sort','page']) as $key => $value)
        @if(is_array($value))
          @foreach($value as $v)
            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
          @endforeach
        @else
          <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
      @endforeach

      <div class="row g-4">
        {{-- ========== SIDEBAR (BỘ LỌC) ========== --}}
        <div class="col-lg-3 col-md-4">
          <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
            <div class="aside-header d-flex d-lg-none align-items-center">
              <h3 class="text-uppercase fs-6 mb-0">Bộ lọc</h3>
              <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
            </div>

            {{-- ========== DANH MỤC SẢN PHẨM ========== --}}
            <div class="filter-section mb-4">
              <h5 class="text-uppercase mb-3">Danh mục sản phẩm</h5>
              <div class="accordion" id="categoryAccordion">
                @foreach($categories as $cat)
                  <div class="accordion-item border-0 mb-2">
                    <div class="d-flex align-items-center justify-content-between">
                      <a href="{{ route('shop', array_merge(request()->except(['category','group']), ['category' => $cat->id])) }}"
                         class="flex-grow-1 text-start text-dark fw-semibold px-3 py-2 rounded-pill text-decoration-none shadow-sm"
                         style="background-color:#fff; border:1px solid #ddd; font-size:15px;">
                        {{ $cat->ten_danh_muc }}
                      </a>
                      <button class="accordion-toggle-btn ms-2 p-0 border-0 bg-transparent"
                              type="button" data-bs-toggle="collapse"
                              data-bs-target="#collapse-{{ $cat->id }}">
                        <i class="bi bi-chevron-down"></i>
                      </button>
                    </div>

                    <div id="collapse-{{ $cat->id }}" class="accordion-collapse collapse">
                      <div class="accordion-body ps-4 pt-2">
                        @if(isset($groupsByCategory[$cat->id]))
                          <ul class="list-unstyled mb-0">
                            @foreach($groupsByCategory[$cat->id] as $group)
                              <li class="mb-1">
                                <a href="{{ route('shop', array_merge(request()->except(['group']), ['category' => $cat->id, 'group' => $group->id])) }}"
                                   class="text-muted small text-decoration-none">
                                  {{ $group->ten_nhom }}
                                </a>
                              </li>
                            @endforeach
                          </ul>
                        @else
                          <p class="text-muted small mb-0">Chưa có nhóm</p>
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            {{-- ========== MÀU SẮC ========== --}}
            <div class="filter-section mb-4">
              <h5 class="text-uppercase fw-semibold">Màu sắc</h5>
              @php
                $colorMap = [
                  'Đen'=>'#000000','Trắng'=>'#ffffff','Be'=>'#f5f5dc','Kem'=>'#fffdd0','Nâu'=>'#8b4513',
                  'Nâu đất'=>'#7b3f00','Hồng'=>'#ffb6c1','Xanh'=>'#007bff','Xanh dương'=>'#1e90ff',
                  'Xanh pastel'=>'#b3e5fc','Xanh nhạt'=>'#add8e6','Xanh olive'=>'#708238','Xanh rêu'=>'#4b5320',
                  'Ghi'=>'#808080','Kẻ caro'=>'#bfbfbf','Họa tiết'=>'#dcdcdc',
                ];
                $colorGroups = [
                  'Hồng pastel'=>'Hồng','Hồng phấn'=>'Hồng','Hồng nude'=>'Hồng',
                  'Xanh pastel'=>'Xanh','Xanh nhạt'=>'Xanh','Xanh dương'=>'Xanh',
                  'Nâu đất'=>'Nâu','Kem'=>'Be',
                ];
                $uniqueColors = collect($colors)
                  ->flatMap(fn($c)=>array_map('trim',explode(',',$c)))
                  ->map(fn($c)=>$colorGroups[$c]??$c)
                  ->unique()->values();
              @endphp

              <div class="d-flex flex-wrap gap-3 mt-3">
                @foreach($uniqueColors as $color)
                  @php
                    $bgColor = $colorMap[$color] ?? '#ccc';
                    $query = request()->except('color');
                  @endphp
                  <a href="{{ route('shop', array_merge($query, ['color'=>$color])) }}"
                     class="color-swatch {{ request('color')==$color?'active':'' }}"
                     title="{{ $color }}">
                    <span class="color-circle" style="background-color:{{ $bgColor }}"></span>
                  </a>
                @endforeach
              </div>
            </div>

            {{-- ========== KÍCH THƯỚC ========== --}}
            <div class="filter-section mb-4">
              <h5 class="text-uppercase fw-semibold">Kích thước</h5>
              @php
                $uniqueSizes = collect($sizes)
                  ->flatMap(fn($s)=>array_map('trim',explode(',',$s)))
                  ->unique()->values();
              @endphp

              <div class="size-grid">
                @foreach($uniqueSizes as $size)
                  @php $query = request()->except('size'); @endphp
                  <a href="{{ route('shop', array_merge($query, ['size'=>$size])) }}"
                     class="size-swatch {{ request('size')==$size?'active':'' }}">
                    <span>{{ strtoupper($size) }}</span>
                  </a>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        {{-- ========== PHẦN NỘI DUNG SẢN PHẨM ========== --}}
        <div class="col-lg-9 col-md-8">

          {{-- ========== THANH SẮP XẾP ========== --}}
          <div class="d-flex justify-content-between align-items-center mb-4">
            
           <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1 text-uppercase fw-medium">
  <a href="{{ url('/') }}" class="menu-link">Trang chủ</a>
  <span class="px-1">/</span>

  <a href="{{ route('shop') }}" class="menu-link">Cửa hàng</a>

  @if(request('category'))
    @php
      $category = $categories->firstWhere('id', request('category'));
    @endphp
    @if($category)
      <span class="px-1">/</span>
      <a href="{{ route('shop', ['category' => $category->id]) }}" class="menu-link">
        {{ $category->ten_danh_muc }}
      </a>
    @endif
  @endif

  @if(request('group') && isset($groupsByCategory[request('category')]))
    @php
      $group = collect($groupsByCategory[request('category')])->firstWhere('id', request('group'));
    @endphp
    @if($group)
      <span class="px-1">/</span>
      <a href="{{ route('shop', ['category' => request('category'), 'group' => $group->id]) }}" class="menu-link text-warning">
        {{ $group->ten_nhom }}
      </a>
    @endif
  @endif
</div>


            <form method="GET" action="{{ route('shop') }}" class="d-flex align-items-center">
              @foreach(request()->except('sort') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
              @endforeach
              <select class="form-select w-auto border-0" name="sort" onchange="this.form.submit()">
                <option value="">Sắp xếp mặc định</option>
                <option value="az" {{ request('sort')=='az'?'selected':'' }}>Tên (A-Z)</option>
                <option value="za" {{ request('sort')=='za'?'selected':'' }}>Tên (Z-A)</option>
                <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Giá tăng dần</option>
                <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Giá giảm dần</option>
                <option value="newest" {{ request('sort')=='newest'?'selected':'' }}>Mới nhất</option>
                <option value="oldest" {{ request('sort')=='oldest'?'selected':'' }}>Cũ nhất</option>
              </select>
            </form>
          </div>

          {{-- ========== DANH SÁCH SẢN PHẨM ========== --}}
          {{-- Hiển thị từ khóa tìm kiếm (nếu có) --}}
@if(request('keyword'))
  <div class="search">
    <p class="mb-0 text-muted">
      Kết quả tìm kiếm cho: 
      <strong class="text-dark">"{{ request('keyword') }}"</strong>
    </p>
  </div>
@endif
          <div id="products-grid" class="row row-cols-2 row-cols-md-4 g-4">
            @foreach($products as $product)
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
    </form>
  </section>
</main>

@endsection
