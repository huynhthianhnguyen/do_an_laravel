@extends('layouts.app')

@section('content')
<div class="container py-5">

  <h2 class="text-center mb-4 text-uppercase fw-bold">CHÍNH SÁCH VẬN CHUYỂN / ĐÓNG GÓI</h2>
  <p class="text-center text-muted mb-5">
    Áp dụng cho toàn bộ đơn hàng của Quý Khách tại <strong>Olivine.vn</strong>
  </p>

  {{-- 1. Chính sách vận chuyển --}}
  <section class="mb-5">
    <h4 class="h5 fw-bold mb-3">1. Chính Sách Vận Chuyển</h4>
    <p>Olivine Fashion cung cấp dịch vụ giao hàng toàn quốc, giao tận nơi đến địa chỉ mà Quý khách đã cung cấp khi đặt hàng. Thời gian giao hàng dự kiến phụ thuộc vào vị trí kho hàng và địa chỉ nhận hàng của Quý khách.</p>
    <p>Đa phần các đơn hàng được xử lý trong vòng vài giờ làm việc để kiểm tra thông tin và đóng gói. Nếu sản phẩm có sẵn, Olivine sẽ nhanh chóng bàn giao cho đơn vị vận chuyển. Với các sản phẩm đang chờ nhập, chúng tôi sẽ ưu tiên giao phần hàng có sẵn trước.</p>

    <h6 class="fw-semibold mt-4 mb-3">Thời gian giao hàng dự kiến:</h6>

    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>Tuyến</th>
            <th>Khu vực</th>
            <th>Thời gian dự kiến</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Hồ Chí Minh – Hồ Chí Minh / Hà Nội – Hà Nội</td>
            <td>Nội thành</td>
            <td>1 – 2 ngày</td>
          </tr>
          <tr>
            <td>Hồ Chí Minh – Miền Nam / Hà Nội – Miền Bắc</td>
            <td>Trung tâm Tỉnh, Thành phố</td>
            <td>2 ngày</td>
          </tr>
          <tr>
            <td></td>
            <td>Huyện, Xã</td>
            <td>2 – 3 ngày</td>
          </tr>
          <tr>
            <td>Hồ Chí Minh – Miền Trung / Hà Nội – Miền Trung</td>
            <td>Trung tâm Tỉnh, Thành phố</td>
            <td>3 ngày</td>
          </tr>
          <tr>
            <td></td>
            <td>Huyện, Xã</td>
            <td>3 – 4 ngày</td>
          </tr>
          <tr>
            <td>Hồ Chí Minh – Miền Bắc / Hà Nội – Miền Nam</td>
            <td>Trung tâm Tỉnh, Thành phố</td>
            <td>4 ngày</td>
          </tr>
          <tr>
            <td></td>
            <td>Huyện, Xã</td>
            <td>4 – 5 ngày</td>
          </tr>
        </tbody>
      </table>
    </div>

    <p class="fst-italic text-muted mt-2">
      *Lưu ý: Trong một số trường hợp hàng hóa không có sẵn tại kho gần nhất, thời gian giao hàng có thể kéo dài hơn dự kiến. Các khoản phí phát sinh (nếu có) sẽ được Olivine hỗ trợ hoàn toàn.  
      Thời gian làm việc: Thứ Hai – Thứ Sáu, không bao gồm Thứ Bảy, Chủ Nhật và ngày lễ.
    </p>
  </section>

  {{-- 2. Bảng giá vận chuyển --}}
  <section class="mb-5">
    <h4 class="h5 fw-bold mb-3">2. Bảng Giá Dịch Vụ Vận Chuyển</h4>
    <div class="table-responsive">
      <table class="table table-bordered text-center align-middle">
        <thead class="table-light">
          <tr>
            <th>Khu vực giao</th>
            <th>Phí vận chuyển (đã bao gồm VAT)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Nội thành Hồ Chí Minh, Hà Nội</td>
            <td>20.000 VNĐ / 2kg (+2.000 VNĐ mỗi 1kg tiếp theo)</td>
          </tr>
          <tr>
            <td>Các khu vực khác</td>
            <td>32.000 VNĐ / 2kg (+3.000 VNĐ mỗi 1kg tiếp theo)</td>
          </tr>
        </tbody>
      </table>
    </div>
    <p>Quý khách có thể kiểm tra phí vận chuyển tại bước <strong>Thanh toán</strong> trước khi xác nhận đơn hàng.</p>
    <p><strong>Chính sách này có hiệu lực từ ngày 01/06/2025.</strong></p>
  </section>

  {{-- 3. Lưu ý khi nhận hàng --}}
  <section class="mb-5">
    <h4 class="h5 fw-bold mb-3">3. Một Số Lưu Ý Khi Nhận Hàng</h4>
    <ul>
      <li>Trước khi giao hàng, nhân viên giao nhận sẽ liên hệ Quý khách trước 3 – 5 phút để xác nhận giao hàng.</li>
      <li>Nếu không thể liên hệ sau 3 lần, đơn hàng có thể bị hủy. Nếu đã thanh toán, tiền sẽ được hoàn trong vòng 5 – 7 ngày làm việc (trừ phí vận chuyển phát sinh).</li>
      <li>Nếu hàng hóa bị lỗi, giao sai hoặc không đúng mô tả, Quý khách có quyền từ chối nhận hàng và được hoàn tiền 100%.</li>
      <li>Nếu gói hàng có dấu hiệu hư hại (rách, móp, ướt, mất niêm phong...), vui lòng kiểm tra kỹ trước khi nhận hoặc liên hệ hotline để được hỗ trợ.</li>
      <li>Nếu Quý khách thay đổi ý định không nhận hàng, vui lòng thông báo sớm qua hotline hoặc CSKH để hủy đơn hàng. Số tiền hoàn lại sẽ trừ chi phí giao hàng.</li>
    </ul>
    <p class="fst-italic text-muted">
      Trong trường hợp giao hàng trễ, Olivine sẽ thông báo kịp thời và hỗ trợ hủy đơn, hoàn tiền đầy đủ cho khách hàng nếu không còn nhu cầu nhận hàng.
    </p>
    <p>Sản phẩm được đóng gói theo tiêu chuẩn của Olivine. Nếu Quý khách có nhu cầu đóng gói đặc biệt (làm quà tặng, hộp riêng, giấy gói…), vui lòng ghi chú khi đặt hàng. Chi phí thêm (nếu có) sẽ được thông báo trước.</p>
  </section>

  {{-- 4. Tra cứu đơn hàng --}}
  <section class="mb-5">
    <h4 class="h5 fw-bold mb-3">4. Tra Cứu Thông Tin Vận Chuyển</h4>
    <p>Olivine sử dụng dịch vụ của các đối tác vận chuyển uy tín để giao hàng đến Quý khách. Quý khách có thể tra cứu tình trạng đơn hàng qua 2 cách:</p>
    <ol>
      <li>Truy cập website của đối tác vận chuyển và nhập mã vận đơn để kiểm tra.</li>
      <li>Liên hệ tổng đài CSKH Olivine: <strong>090 555 6787</strong> để được hỗ trợ tra cứu.</li>
    </ol>

    <p><strong>Đối tác vận chuyển chính:</strong></p>
    <ul>
      <li>Giao Hàng Nhanh (GHN)</li>
      <li>Giao Hàng Tiết Kiệm (GHTK)</li>
      <li>Ninja Van Việt Nam</li>
    </ul>
  </section>
</div>
@endsection
