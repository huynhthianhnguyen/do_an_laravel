@extends('layouts.app')
@section('content')
<main class="pt-90">
  <div class="mb-4 pb-4"></div>
  <section class="shop-checkout container">
    <h2 class="page-title">VẬN CHUYỂN VÀ THANH TOÁN</h2>

    {{-- ======= CÁC BƯỚC THANH TOÁN ======= --}}
    <div class="checkout-steps">
      <a href="{{ route('cart') }}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">01</span>
        <span class="checkout-steps__item-title">
          <span>Giỏ hàng</span>
          <em>Danh sách sản phẩm</em>
        </span>
      </a>
      <a href="{{ route('checkout') }}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">02</span>
        <span class="checkout-steps__item-title">
          <span>VẬN CHUYỂN VÀ THANH TOÁN</span>
          <em>Kiểm tra sản phẩm và nhập thông tin</em>
        </span>
      </a>
      <a href="#" class="checkout-steps__item">
        <span class="checkout-steps__item-number">03</span>
        <span class="checkout-steps__item-title">
          <span>XÁC NHẬN</span>
          <em>Xem lại và gửi đơn hàng</em>
        </span>
      </a>
    </div>

    {{-- ======= FORM THANH TOÁN ======= --}}
   <form method="POST" action="{{ route('order.store') }}">
  @csrf
  <div class="checkout-form">

    {{-- ================= THÔNG TIN KHÁCH HÀNG ================= --}}
     <div class="col-lg-7">
      <div class="p-4 border rounded-4 bg-white shadow-sm">
        <h4 class="fw-semibold border-bottom pb-3 mb-3">CHI TIẾT VẬN CHUYỂN</h4>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Họ và tên *</label>
            <input type="text" class="form-control" name="name"
                   value="{{ old('name', auth()->user()->name ?? '') }}" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Số điện thoại *</label>
            <input type="text" class="form-control" name="phone"
                   value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
          </div>

          
          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Tỉnh / Thành phố *</label>
            <input type="text" class="form-control" name="city"
                   value="{{ old('city', auth()->user()->city ?? '') }}" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Thị trấn / Quận / Huyện *</label>
            <input type="text" class="form-control" name="district"
                   value="{{ old('district', auth()->user()->district ?? '') }}" required>
          </div>

          <div class="col-12 mb-3">
            <label class="form-label fw-medium">Địa chỉ cụ thể *</label>
            <input type="text" class="form-control" name="address"
                   value="{{ old('address') }}" required>
          </div>
          <div class="col-md-12 mb-3">
    <label class="form-label fw-medium">Email *</label>
    <input type="email" class="form-control" name="email"
           value="{{ old('email', auth()->user()->email ?? '') }}" required>
</div>

        </div>
      </div>
    </div>

    {{-- ================= GIỎ HÀNG & TỔNG TIỀN ================= --}}
    <div class="col-lg-4">
      <div class="p-4 border rounded-4 bg-white shadow-sm position-sticky" style="top: 90px;">
        <h4 class="fw-semibold mb-4 border-bottom pb-3">ĐƠN HÀNG CỦA BẠN</h4>
        @php
          $subtotal = collect($cartItems)->sum(fn($item) => $item['gia'] * $item['quantity']);
          $coupon = session('coupon');
          $discount = $coupon['discount'] ?? 0;
          $shipping = session('shipping', 0);
          $vat = round(0.1 * max(0, $subtotal - $discount));
          $total = $subtotal - $discount + $shipping + $vat;
        @endphp

        <table class="checkout-cart-items w-100 mb-3">
          <tbody>
            @foreach($cartItems as $item)
              <tr>
                <td>{{ $item['ten_san_pham'] }} x {{ $item['quantity'] }}</td>
                <td class="text-end">{{ number_format($item['gia'] * $item['quantity'], 0, ',', '.') }} ₫</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <table class="checkout-totals w-100">
          <tr><th>Tạm tính:</th><td class="text-end">{{ number_format($subtotal, 0, ',', '.') }} ₫</td></tr>
          @if($discount > 0)
            <tr><th>Giảm giá:</th><td class="text-end text-success">-{{ number_format($discount, 0, ',', '.') }} ₫</td></tr>
          @endif
          <tr><th>VAT (10%):</th><td class="text-end">{{ number_format($vat, 0, ',', '.') }} ₫</td></tr>
          <tr class="fw-bold border-top">
            <th>Tổng cộng:</th>
            <td class="text-end text-danger fs-5">{{ number_format($total, 0, ',', '.') }} ₫</td>
          </tr>
        </table>

        {{-- ================= PHƯƠNG THỨC THANH TOÁN ================= --}}
        <div class="checkout__payment-methods mt-4">
          <h5 class="fw-semibold mb-3">
            <i class="bi bi-wallet2 text-primary me-2"></i> Phương thức thanh toán
          </h5>

          @foreach([
            'cod' => 'Thanh toán khi nhận hàng (COD)',
            'vnpay' => 'Thanh toán qua VNPay'
          ] as $method => $label)
            <div class="form-check mb-2">
              <input class="form-check-input form-check-input_fill"
                     type="radio"
                     name="payment_method"
                     id="method_{{ $method }}"
                     value="{{ $method }}"
                     {{ old('payment_method') === $method ? 'checked' : '' }} required>
              <label class="form-check-label" for="method_{{ $method }}">
                {{ $label }}
              </label>
            </div>
          @endforeach
        </div>

        <button type="submit" class="btn btn-primary btn-checkout mt-4 w-100 py-3 fw-semibold shadow-sm">
          <i class="bi bi-cart-check me-2"></i> ĐẶT HÀNG NGAY
        </button>
      </div>
    </div>

  </div>
</form>
  </section>
</main>
@endsection
