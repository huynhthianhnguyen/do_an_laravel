@extends('layouts.app')

@section('content')
<div class="container">
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>

    <section class="shop-checkout container">
      <h2 class="page-title">Giỏ hàng</h2>

      {{-- ======= BƯỚC THANH TOÁN ======= --}}
      <div class="checkout-steps">
        <a href="{{ route('cart') }}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Giỏ hàng</span>
            <em>Danh sách sản phẩm</em>
          </span>
        </a>
        <a href="{{ route('checkout') }}" class="checkout-steps__item">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Thanh toán & Giao hàng</span>
            <em>Điền thông tin và xác nhận đơn hàng</em>
          </span>
        </a>
        <a href="#" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Xác nhận đơn hàng</span>
            <em>Kiểm tra và gửi đơn hàng</em>
          </span>
        </a>
      </div>

      {{-- ======= GIỎ HÀNG ======= --}}
     <div class="shopping-cart">
  <div class="cart-table__wrapper">
    <table class="cart-table">
      <thead>
        <tr>
          <th>Sản phẩm</th>
          <th>Giá</th>
          <th>Số lượng</th>
          <th>Tạm tính</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @forelse ($cartItems as $item)
          <tr>
            {{-- CỘT: SẢN PHẨM + ẢNH + THÔNG TIN --}}
           <td class="shopping-cart__product-item align-middle">
  <div class="d-flex align-items-center gap-3">
    {{-- ẢNH SẢN PHẨM --}}
    <div class="shopping-cart__product-item__image flex-shrink-0">
    @php
    $anhData = is_string($item['anh'] ?? null)
        ? json_decode($item['anh'], true)
        : (is_array($item['anh'] ?? null) ? $item['anh'] : []);

    $anh_chinh = $anhData['anh_chinh'] ?? ($anhData['anh_phu'][0] ?? 'images/default.jpg');
@endphp

<img
  src="{{ asset('assets/' . ltrim($anh_chinh, '/')) }}"
  alt="{{ $item['ten_san_pham'] }}"
  width="100"
  height="100"
  class="rounded border"
  onerror="this.src='{{ asset('assets/images/default.jpg') }}';"
/>

</div>

    {{-- THÔNG TIN SẢN PHẨM --}}
    <div class="shopping-cart__product-item__detail">
      <h4 class="mb-1 fw-semibold" style="font-size: 1rem;">
        {{ $item['ten_san_pham'] }}
      </h4>
      <p class="mb-0 text-muted" style="font-size: 0.9rem;">
        Màu sắc:
        <span class="text-dark fw-medium">{{ $item['color'] ?? 'Không rõ' }}</span>
      </p>
      <p class="mb-0 text-muted" style="font-size: 0.9rem;">
        Kích thước:
        <span class="text-dark fw-medium">{{ $item['size'] ?? 'Không rõ' }}</span>
      </p>
    </div>
  </div>
</td>
            {{-- CỘT: GIÁ --}}
            <td>
              <span class="shopping-cart__product-price">
                {{ number_format($item['gia'], 0, ',', '.') }}₫
              </span>
            </td>
            {{-- CỘT: SỐ LƯỢNG --}}
            <td>
          <form class="update-cart-form">
  @csrf
  <input type="hidden" name="id" value="{{ $item['product_id'] }}">
  <div class="quantity-control">
    <button type="button" class="qty-control__reduce">-</button>
    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1">
    <button type="button" class="qty-control__increase">+</button>
  </div>
</form>
            </td>
            {{-- CỘT: TẠM TÍNH --}}
            <td>
              <span class="shopping-cart__subtotal">
                {{ number_format($item['gia'] * $item['quantity'], 0, ',', '.') }}₫
              </span>
            </td>

            {{-- CỘT: XOÁ --}}
            <td>
             <form method="POST" action="{{ route('cart.remove', $item['product_id']) }}" class="remove-form">
    @csrf

                <button type="submit" class="remove-cart" style="background:none;border:none;">
                  <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                    <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                  </svg>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Giỏ hàng của bạn đang trống.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
        </div>
      {{-- ======= TỔNG TIỀN & KHUYẾN MÃI ======= --}}
<div class="shopping-cart__totals-wrapper">

  {{-- ======= PHẦN KHUYẾN MÃI ======= --}}
  <div class="shopping-cart__voucher-wrapper mb-4 p-3 border rounded-4 bg-light">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="fw-semibold mb-0">
        <i class="bi bi-ticket-perforated text-primary me-1"></i> Khuyến mãi
      </h5>
      <a href="#" class="text-decoration-none text-primary small fw-medium" data-bs-toggle="modal" data-bs-target="#voucherModal">
        Xem thêm
      </a>
    </div>

    {{-- Nếu có mã áp dụng --}}
   @if($coupon)
    <div class="p-3 bg-white border rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong class="text-dark">{{ $coupon['title'] ?? $coupon['code'] }}</strong>
                <div class="text-muted small">
                    Giảm {{ number_format($coupon['discount'], 0, ',', '.') }} ₫  
                    <span class="text-success ms-2">Đã áp dụng</span>
                </div>
            </div>
            <a href="{{ route('removeCoupon') }}" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>
    </div>
@endif


    {{-- Gợi ý khuyến mãi đủ điều kiện --}}
    <div class="mt-3">
      <div class="alert alert-info py-2 mb-0">
        <a href="#" class="text-primary text-decoration-none fw-medium" data-bs-toggle="modal" data-bs-target="#voucherModal">
          2 khuyến mãi đủ điều kiện
        </a>
      </div>
    </div>
  </div>

  {{-- ======= TỔNG TIỀN ======= --}}
  <div class="sticky-content">
    <div class="shopping-cart__totals">
      <h3 class="fw-semibold mb-3">Tổng đơn hàng</h3>

      @php
        $subtotal = collect($cartItems)->sum(fn($item) => $item['gia'] * $item['quantity']);
        $coupon = session('coupon');
        $discount = $coupon['discount'] ?? 0;
        $shipping = match(request('shipping')) {
            'flat' => 49000,
            'pickup' => 8000,
            default => 0,
        };
        $freeShippingThreshold = 500000;
        if ($subtotal >= $freeShippingThreshold) $shipping = 0;
        $vat = round(0.1 * ($subtotal - $discount));
        $total = $subtotal - $discount + $shipping + $vat;
      @endphp

      <table class="cart-totals w-100">
        <tbody>
          <tr>
            <th class="text-start">Tạm tính</th>
            <td class="text-end">{{ number_format($subtotal, 0, ',', '.') }} ₫</td>
          </tr>

          @if($discount > 0)
            <tr>
              <th class="text-start">Giảm giá</th>
              <td class="text-end text-success">-{{ number_format($discount, 0, ',', '.') }} ₫</td>
            </tr>
          @endif

          <tr>
            <th class="text-start">Phí vận chuyển</th>
            <td class="text-end">
              @if($shipping === 0)
                <span class="text-success">Miễn phí</span>
              @else
                {{ number_format($shipping, 0, ',', '.') }} ₫
              @endif
            </td>
          </tr>

          <tr>
            <th class="text-start">Thuế VAT (10%)</th>
            <td class="text-end">{{ number_format($vat, 0, ',', '.') }} ₫</td>
          </tr>

          <tr class="fw-bold border-top">
            <th class="text-start">Tổng cộng</th>
            <td class="text-end text-danger fs-5">{{ number_format($total, 0, ',', '.') }} ₫</td>
          </tr>
        </tbody>
      </table>

      <div class="mobile_fixed-btn_wrapper mt-4">
        <div class="button-wrapper container">
          <a href="{{ route('checkout') }}" class="btn btn-primary w-100 btn-checkout py-3 fw-semibold">
            TIẾN HÀNH THANH TOÁN
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ===============================
     MODAL: Danh sách mã khuyến mãi
================================== -->
<div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom bg-light">
        <h5 class="modal-title fw-semibold">
          <i class="bi bi-ticket-perforated text-primary me-2"></i>
          Chọn mã khuyến mãi
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>

      <div class="modal-body">
        {{-- Ô nhập mã thủ công --}}
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nhập mã khuyến mãi / Gift Card...">
          <button class="btn btn-primary">Áp dụng</button>
        </div>

        <h6 class="fw-semibold mb-2">Mã giảm giá</h6>

        {{-- Danh sách mã giảm giá --}}
        @php
          $subtotal = collect($cartItems)->sum(fn($item) => $item['gia'] * $item['quantity']);
          $vouchers = [
            ['code' => 'SALE10K', 'title' => 'Mã Giảm 10K - Toàn Sàn', 'min' => 130000, 'discount' => 10000, 'expiry' => '30/11/2025', 'color' => '#FFD580'],
            ['code' => 'SALE20K', 'title' => 'Mã Giảm 20K - Toàn Sàn', 'min' => 249000, 'discount' => 20000, 'expiry' => '30/11/2025', 'color' => '#B0B0B0'],
          ];
        @endphp

        @foreach ($vouchers as $voucher)
          @php
            $enough = $subtotal >= $voucher['min'];
            $progress = min(100, ($subtotal / $voucher['min']) * 100);
          @endphp

          <div class="border rounded-3 p-3 mb-3 bg-white shadow-sm">
            <div class="d-flex align-items-start justify-content-between">
              {{-- Icon mã --}}
              <div class="me-3 flex-shrink-0 text-center" style="width:80px;">
                <div class="rounded-3 py-3" style="background-color:{{ $voucher['color'] }}">
                  <i class="bi bi-percent fs-4"></i><br>
                  <small>Mã giảm</small>
                </div>
              </div>

              {{-- Nội dung --}}
              <div class="flex-grow-1">
                <div class="fw-semibold">{{ $voucher['title'] }}</div>
                <small class="text-muted d-block">Đơn từ {{ number_format($voucher['min'], 0, ',', '.') }}₫</small>
                <small class="text-muted d-block">HSD: {{ $voucher['expiry'] }}</small>

                <div class="progress my-2" style="height:6px;">
                  <div class="progress-bar bg-primary" style="width: {{ $progress }}%"></div>
                </div>

                @if(!$enough)
                  <small class="text-muted">Mua thêm {{ number_format($voucher['min'] - $subtotal, 0, ',', '.') }}₫ để đủ điều kiện</small>
                @endif
              </div>

              {{-- Nút áp dụng --}}
              <form method="POST" action="{{ route('applyCoupon') }}">
                @csrf
                <input type="hidden" name="coupon" value="{{ $voucher['code'] }}">
                <button type="submit"
                        class="btn btn-sm {{ $enough ? 'btn-primary' : 'btn-outline-secondary' }} ms-2"
                        {{ $enough ? '' : 'disabled' }}>
                  {{ $enough ? 'Áp dụng' : 'Mua thêm' }}
                </button>
              </form>
            </div>
          </div>
        @endforeach

        <h6 class="fw-semibold mt-4 mb-2">Mã vận chuyển</h6>
        <div class="border rounded-3 p-3 bg-white shadow-sm">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="fw-semibold">Mã Giảm 25K - Giao hàng nhanh</div>
              <small class="text-muted">Đơn hàng từ 210k</small><br>
              <small class="text-muted">HSD: 30/11/2025</small>
            </div>
            <button class="btn btn-outline-primary btn-sm">Áp dụng</button>
          </div>
        </div>
      </div>

      <div class="modal-footer border-0">
        <small class="text-muted">
          <i class="bi bi-info-circle me-1"></i>Hướng dẫn sử dụng Gift Card và mã giảm giá
        </small>
      </div>
    </div>
  </div>
</div>

    </section>
  </main>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.update-cart-form').forEach(form => {
    const hiddenId = form.querySelector('input[name="id"]');
    const inputQty = form.querySelector('input[name="quantity"]');
    const btnInc = form.querySelector('.qty-control__increase');
    const btnDec = form.querySelector('.qty-control__reduce');

    const productId = hiddenId?.value;
    if (!productId || !inputQty) return; // tránh null

    async function updateCart(id, quantity) {
      const token = document.querySelector('meta[name="csrf-token"]').content;

      const res = await fetch(`/cart/update/${id}`, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token,
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ quantity })
      });

      if (!res.ok) {
        console.error('Update failed', await res.text());
        return false;
      }
      const data = await res.json();
      return data.success ?? true;
    }

    btnInc?.addEventListener('click', async () => {
      inputQty.stepUp();
      const ok = await updateCart(productId, inputQty.value);
      if (ok) location.reload();
    });

    btnDec?.addEventListener('click', async () => {
      if (parseInt(inputQty.value) > 1) {
        inputQty.stepDown();
        const ok = await updateCart(productId, inputQty.value);
        if (ok) location.reload();
      }
    });

    inputQty?.addEventListener('change', async () => {
      if (parseInt(inputQty.value) < 1) inputQty.value = 1;
      await updateCart(productId, inputQty.value);
      location.reload();
    });
  });
});
</script>



@endsection
