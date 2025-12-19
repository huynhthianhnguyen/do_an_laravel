@extends('layouts.app')

@section('title', 'Câu Hỏi Thường Gặp | Olivine Fashion')

@section('content')
<div class="container my-5">
  <h2 class="text-center fw-bold mb-4 text-uppercase" style="color:#b65c60;">
    Câu Hỏi Thường Gặp
  </h2>
  <p class="text-center mb-5 text-muted">
    Dưới đây là những câu hỏi phổ biến mà khách hàng của <strong>Olivine Fashion</strong> thường thắc mắc.  
    Nếu bạn cần hỗ trợ thêm, vui lòng liên hệ qua hotline <strong>1900 636 467</strong> hoặc email <strong>cskh@olivine.vn</strong>.
  </p>

  <div class="accordion" id="faqAccordion">

    <!-- Câu 1 -->
    <div class="accordion-item mb-3 border rounded shadow-sm">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          1. Làm thế nào để tôi đặt hàng tại Olivine Fashion?
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Bạn có thể đặt hàng trực tiếp tại website <a href="/">olivine.vn</a> bằng cách:
          <ol>
            <li>Chọn sản phẩm bạn yêu thích.</li>
            <li>Chọn size, màu sắc và nhấn “Thêm vào giỏ hàng”.</li>
            <li>Kiểm tra giỏ hàng, nhập thông tin giao hàng và chọn phương thức thanh toán.</li>
            <li>Nhấn “Đặt hàng” để hoàn tất.</li>
          </ol>
        </div>
      </div>
    </div>

    <!-- Câu 2 -->
    <div class="accordion-item mb-3 border rounded shadow-sm">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          2. Tôi có thể thanh toán bằng những hình thức nào?
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          <p>Olivine hỗ trợ các hình thức thanh toán sau:</p>
          <ul>
            <li>Thanh toán khi nhận hàng (COD).</li>
            <li>Thanh toán trực tuyến bằng thẻ nội địa (Internet Banking).</li>
            <li>Thanh toán bằng thẻ quốc tế (Visa, MasterCard, JCB,...).</li>
            <li>Thanh toán qua ví điện tử (Momo, ZaloPay, VNPay,…).</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Câu 3 -->
    <div class="accordion-item mb-3 border rounded shadow-sm">
      <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          3. Tôi có thể đổi trả sản phẩm trong bao lâu?
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Quý khách có thể <strong>đổi hoặc trả hàng trong vòng 7 ngày</strong> kể từ ngày nhận hàng, với điều kiện:
          <ul>
            <li>Sản phẩm còn nguyên tem, tag, chưa qua sử dụng hoặc giặt.</li>
            <li>Hóa đơn mua hàng hoặc mã đơn hàng được cung cấp đầy đủ.</li>
          </ul>
          Chi tiết vui lòng xem tại <a href="/chinh-sach-doi-tra" class="text-decoration-none" style="color:#b65c60;">Chính sách đổi trả</a>.
        </div>
      </div>
    </div>

    <!-- Câu 4 -->
    <div class="accordion-item mb-3 border rounded shadow-sm">
      <h2 class="accordion-header" id="headingFour">
        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          4. Làm sao để kiểm tra tình trạng đơn hàng của tôi?
        </button>
      </h2>
      <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Bạn có thể kiểm tra đơn hàng bằng 2 cách:
          <ul>
            <li>Đăng nhập tài khoản Olivine → mục <strong>Đơn hàng của tôi</strong>.</li>
            <li>Liên hệ hotline hoặc email CSKH kèm mã đơn hàng để được hỗ trợ tra cứu nhanh.</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Câu 5 -->
    <div class="accordion-item mb-3 border rounded shadow-sm">
      <h2 class="accordion-header" id="headingFive">
        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
          5. Tôi có thể hủy đơn hàng đã đặt không?
        </button>
      </h2>
      <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Quý khách có thể yêu cầu hủy đơn hàng trước khi đơn được xác nhận giao.  
          Vui lòng liên hệ sớm qua hotline hoặc email CSKH để được hỗ trợ nhanh nhất.  
          Nếu đơn hàng đã được giao cho đơn vị vận chuyển, chúng tôi rất tiếc không thể hủy nhưng bạn có thể **từ chối nhận hàng khi bưu tá liên hệ**.
        </div>
      </div>
    </div>

    <!-- Câu 6 -->
    <div class="accordion-item mb-3 border rounded shadow-sm">
      <h2 class="accordion-header" id="headingSix">
        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
          6. Olivine có chương trình ưu đãi hoặc giảm giá nào không?
        </button>
      </h2>
      <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          <p>Olivine thường xuyên có các chương trình khuyến mãi, ưu đãi đặc biệt cho khách hàng thân thiết và thành viên mới.</p>
          <p>Hãy đăng ký tài khoản và theo dõi fanpage <a href="#" class="text-decoration-none" style="color:#b65c60;">Facebook Olivine</a> hoặc mục <a href="/khuyen-mai" class="text-decoration-none" style="color:#b65c60;">Khuyến mãi</a> để không bỏ lỡ ưu đãi nhé!</p>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
