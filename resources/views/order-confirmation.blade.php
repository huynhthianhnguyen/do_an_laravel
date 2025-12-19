@extends('layouts.app')
@section('content')
<main class="pt-90">
  <div class="mb-4 pb-4"></div>
  <section class="shop-checkout container">
    <h2 class="page-title">XÁC NHẬN ĐƠN HÀNG</h2>

    {{-- ======== Thanh tiến trình ======== --}}
    <div class="checkout-steps">
      <a href="{{ route('cart') }}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">01</span>
        <span class="checkout-steps__item-title">
          <span>GIỎ HÀNG</span>
          <em>Danh sách sản phẩm</em>
        </span>
      </a>
      <a href="{{ route('checkout') }}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">02</span>
        <span class="checkout-steps__item-title">
          <span>VẬN CHUYỂN VÀ THANH TOÁN</span>
          <em>Kiểm tra đơn hàng của bạn</em>
        </span>
      </a>
      <a href="#" class="checkout-steps__item">
        <span class="checkout-steps__item-number">03</span>
        <span class="checkout-steps__item-title">
          <span>XÁC NHẬN</span>
          <em>Xem lại và xác nhận đơn hàng của bạn</em>
        </span>
      </a>
    </div>

    {{-- ======== Thông báo hoàn tất ======== --}}
    <div class="order-complete">
      <div class="order-complete__message">
        <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="40" fill="#B9A16B" />
          <path
            d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z"
            fill="white" />
        </svg>
        <h3>ĐƠN HÀNG CỦA BẠN ĐÃ HOÀN TẤT!</h3>
        <p>Cảm ơn <strong>{{ $order->name }}</strong>. Đơn hàng của bạn đã được xác nhận.</p>
      </div>

      {{-- ======== Thông tin đơn hàng ======== --}}
      <div class="order-info">
        <div class="order-info__item">
          <label>Mã đơn hàng</label>
          <span>#{{ $order->id }}</span>
        </div>
        <div class="order-info__item">
          <label>Ngày</label>
          <span>{{ $order->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="order-info__item">
          <label>TỔNG</label>
          <span>{{ number_format($order->total, 0, ',', '.') }} VND</span>
        </div>
        <div class="order-info__item">
          <label>Phương thức thanh toán</label>
          <span>{{ ucfirst($order->payment_method) }}</span>
        </div>
      </div>

      {{-- ======== Bảng chi tiết ======== --}}
      <div class="checkout__totals-wrapper">
        <div class="checkout__totals">
          <h3>CHI TIẾT ĐƠN HÀNG</h3>
          <table class="checkout-cart-items">
            <thead>
              <tr>
                <th>SẢN PHẨM</th>
                <th>TỔNG TIỀN</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->items as $item)
                <tr>
                  <td>
                    {{ $item->ten_san_pham }}
                    @if(!empty($item->color)) - Màu: {{ $item->color }} @endif
                    @if(!empty($item->size)) - Size: {{ $item->size }} @endif
                    x {{ $item->quantity }}
                  </td>
                  <td align="right">
                    {{ number_format($item->tong_tien, 0, ',', '.') }} VND
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

         <table class="checkout-totals">
  <tbody>
    <tr>
      <th>TỔNG TIỀN HÀNG</th>
      <td align="right">{{ number_format($order->subtotal, 0, ',', '.') }} VND</td>
    </tr>

    @if(!empty($order->discount) && $order->discount > 0)
    <tr>
      <th>GIẢM GIÁ 
        @if($order->coupon_code)
          <span class="text-muted small">({{ $order->coupon_code }})</span>
        @endif
      </th>
      <td align="right" class="text-success">-{{ number_format($order->discount, 0, ',', '.') }} VND</td>
    </tr>
    @endif

    <tr>
      <th>VẬN CHUYỂN</th>
      <td align="right">
        @if($order->shipping_fee == 0)
          Miễn phí vận chuyển
        @else
          {{ number_format($order->shipping_fee, 0, ',', '.') }} VND
        @endif
      </td>
    </tr>

    <tr>
      <th>THUẾ VAT</th>
      <td align="right">{{ number_format($order->vat, 0, ',', '.') }} VND</td>
    </tr>

    <tr class="fw-bold border-top">
      <th>TỔNG CỘNG</th>
      <td align="right" class="text-danger fs-5">
        {{ number_format($order->total, 0, ',', '.') }} VND
      </td>
    </tr>
  </tbody>
</table>

        </div>
      </div>
    </div>
  </section>
</main>
@endsection
