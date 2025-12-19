@extends('layouts.app')

@section('title', 'Chính sách đổi / trả / hoàn tiền')

@section('content')
<main class="pt-90">
  <section class="container py-5">
    <h2 class="text-center mb-4 fw-bold">CHÍNH SÁCH ĐỔI / TRẢ / HOÀN TIỀN</h1>
    <p class="text-center text-muted mb-5">Áp dụng cho toàn bộ đơn hàng của quý khách tại <strong>Olivine Fashion</strong></p>

    {{-- 3 khối hình minh họa --}}
    <div class="row g-4 mb-5">
      <div class="col-md-4 text-center">
        <div class="p-4 border rounded h-100">
          <img src="{{ asset('assets/images/chinh_sach/30days.png') }}" alt="30 ngày đổi trả" width="100" class="mb-3">
          <h5 class="fw-semibold text-danger">ĐĂNG KÝ ĐỔI TRẢ HÀNG</h5>
          <p>Liên hệ hotline <strong>090 555 6787</strong> hoặc email <strong>olivinefashion82@gmail.com</strong> để đăng ký đổi/trả trong vòng 30 ngày kể từ khi giao hàng thành công.</p>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="p-4 border rounded h-100">
          <img src="{{ asset('assets/images/chinh_sach/confirm.png') }}" alt="Xác nhận đăng ký" width="100" class="mb-3">
          <h5 class="fw-semibold text-danger">XÁC NHẬN ĐĂNG KÝ ĐỔI/TRẢ</h5>
          <p>Chúng tôi sẽ tiếp nhận thông tin và xác nhận qua hotline, tin nhắn hoặc email và gửi hướng dẫn chi tiết tới quý khách ngay khi nhận được yêu cầu.</p>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="p-4 border rounded h-100">
          <img src="{{ asset('assets/images/chinh_sach/freeship.png') }}" alt="Miễn phí gửi hàng" width="100" class="mb-3">
          <h5 class="fw-semibold text-danger">MIỄN PHÍ GỬI HÀNG VỀ OLIVINE FASHION</h5>
          <p>Chúng tôi hỗ trợ thu hồi sản phẩm miễn phí tận nơi trên toàn quốc đối với trường hợp lỗi do nhà cung cấp hoặc vận chuyển.</p>
        </div>
      </div>
    </div>

   {{-- Nội dung chi tiết --}}
<section class="mb-5">
  <h4 class="h5 mb-3">1. Thời gian áp dụng đổi/trả</h4>
  <p>Kể từ khi đơn hàng được giao thành công.</p>

  <div class="table-responsive mb-3">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Sản phẩm</th>
          <th>7 ngày đầu tiên</th>
          <th>8-14 ngày</th>
          <th>Sau 14 ngày</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Quần / Áo / Jumpsuit / Đầm / Chân váy</td>
          <td>Đổi mới / Trả không thu phí</td>
          <td>Đổi nếu còn hàng cùng loại hoặc hoàn tiền 80%</td>
          <td>Không hỗ trợ đổi/trả</td>
        </tr>
        <tr>
          <td>Sản phẩm khuyến mãi</td>
          <td>Chỉ hỗ trợ đổi size (nếu còn hàng)</td>
          <td>Không hỗ trợ đổi/trả</td>
          <td>Không hỗ trợ</td>
        </tr>
      </tbody>
    </table>
  </div>
  <p class="small text-muted">Quý khách vui lòng kiểm tra kỹ sản phẩm khi nhận hàng. Nếu sản phẩm có dấu hiệu lỗi, trầy xước hoặc sai mẫu, vui lòng thông báo trong vòng 48 giờ kể từ khi nhận hàng.</p>
  <p class="small text-muted">Olivine Fashion sẽ phản hồi và xử lý trong tối đa 7 ngày làm việc kể từ khi nhận được thông tin đầy đủ.</p>
</section>

<section class="mb-5">
  <h4 class="h5 mb-3">2. Các trường hợp yêu cầu đổi/trả</h4>
  <ul>
    <li>Sản phẩm bị lỗi kỹ thuật (đường may, nút, dây kéo, chất liệu).</li>
    <li>Giao nhầm mẫu, nhầm size, nhầm màu.</li>
    <li>Sản phẩm bị hư hỏng do vận chuyển.</li>
    <li>Không đúng mô tả hoặc hình ảnh trên website Olivine Fashion.</li>
    <li>Khách hàng muốn đổi size hoặc đổi sang sản phẩm khác (cùng giá hoặc cao hơn).</li>
  </ul>
</section>

<section class="mb-5">
  <h4 class="h5 mb-3">3. Điều kiện đổi/trả</h4>
  <p>Sản phẩm được hỗ trợ đổi/trả nếu đáp ứng đủ các điều kiện sau:</p>
  <ul>
    <li>Sản phẩm còn nguyên tem, tag, bao bì và chưa qua sử dụng.</li>
    <li>Không bị dơ, rách, dính mùi hoặc đã giặt.</li>
    <li>Có hóa đơn mua hàng hoặc mã đơn hàng điện tử.</li>
    <li>Áp dụng cho các sản phẩm thuộc danh mục: Quần, Áo, Đầm, Chân Váy, Jumpsuit.</li>
  </ul>
</section>

<section class="mb-5">
  <h4 class="h5 mb-3">4. Quy trình đổi/trả</h4>
  <p>Vui lòng liên hệ <strong>Olivine Fashion</strong> qua hotline <strong>090 555 6787</strong> hoặc email <strong>olivinefashion82@gmail.com</strong> với tiêu đề “Đổi Trả Đơn Hàng [Mã đơn hàng]”.</p>
  <p>Khách hàng cần cung cấp hình ảnh hoặc video thể hiện tình trạng sản phẩm, bao bì, tem mác và lỗi cụ thể (nếu có).</p>

  <div class="table-responsive mt-3">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>STT</th>
          <th>Nội dung</th>
          <th>Giải quyết</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Sản phẩm bị lỗi từ nhà sản xuất</td>
          <td>Đổi mới miễn phí hoặc hoàn tiền 100%.</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Sản phẩm bị hư do vận chuyển</td>
          <td>Gửi lại sản phẩm mới hoặc hoàn tiền toàn bộ.</td>
        </tr>
        <tr>
          <td>3</td>
          <td>Giao sai mẫu, sai size hoặc sai màu</td>
          <td>Đổi miễn phí, Olivine chịu phí vận chuyển 2 chiều.</td>
        </tr>
        <tr>
          <td>4</td>
          <td>Khách hàng muốn đổi size hoặc mẫu khác</td>
          <td>Hỗ trợ đổi nếu còn hàng, khách hàng chịu phí vận chuyển 1 chiều.</td>
        </tr>
        <tr>
          <td>5</td>
          <td>Sản phẩm khuyến mãi</td>
          <td>Chỉ hỗ trợ đổi size nếu còn hàng, không hoàn tiền.</td>
        </tr>
      </tbody>
    </table>
  </div>
    </section>

    <section class="mb-5">
      <h4 class="h5 mb-3">5. Cách thức chuyển sản phẩm đổi/trả</h4>
      <p>Khi yêu cầu đổi/trả được chấp nhận, quý khách đóng gói sản phẩm như hiện trạng khi nhận hàng – bao gồm sản phẩm, phụ kiện, quà tặng, hóa đơn (nếu có) và gửi về địa chỉ mà chúng tôi hướng dẫn.</p>
      <p>Sau khi nhận và kiểm tra sản phẩm, <strong>Olivine Fashion</strong> sẽ phản hồi và cập nhật thông qua email/điện thoại.</p>
    </section>

    <section class="mb-5">
      <h4 class="h5 mb-3">6. Thời gian hoàn tiền</h4>
      <p>Thời gian hoàn tiền tùy thuộc vào phương thức thanh toán:</p>
      <ul>
        <li>ATM nội địa / cổng thanh toán: 5-7 ngày làm việc.</li>
        <li>Chuyển khoản: 5-7 ngày làm việc.</li>
        <li>Thẻ Visa/Master/JCB: 5-7 ngày (có thể dao động 1-3 tuần theo ngân hàng).</li>
        <li>Ví điện tử: 1-3 ngày làm việc.</li>
      </ul>
      <p class="small text-muted">Thời gian này tính từ khi chúng tôi xác nhận đã nhận hàng và đủ điều kiện hoàn tiền.</p>
    </section>

    <p class="text-center text-muted small">Chính sách này có hiệu lực từ <strong>01/08/2025</strong>. Olivine Fashion có quyền cập nhật mà không cần báo trước.</p>
  </section>
</main>
@endsection

@push('styles')
@endpush
