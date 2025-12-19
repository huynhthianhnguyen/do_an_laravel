@extends('layouts.app')

@section('content')
<div class="container py-5">
  <h2 class="text-center mb-4 text-uppercase fw-bold">Chính Sách Bảo Mật Dữ Liệu Cá Nhân</h2>
  <p class="text-center text-muted mb-5">
    Cập nhật lần cuối: 01/06/2025 – Áp dụng cho toàn bộ khách hàng của Olivine Fashion
  </p>

  {{-- Giới thiệu --}}
  <section class="mb-5">
    <p>Olivine Fashion mong muốn mang đến cho khách hàng một trải nghiệm mua sắm thời trang trực tuyến
      <strong>an toàn, tiện lợi và đáng tin cậy</strong>. Chúng tôi cam kết bảo vệ dữ liệu cá nhân của quý khách
      khi truy cập và mua sắm tại website <strong>olivine.vn</strong>.
    </p>
    <p>Chính sách này mô tả cách thức chúng tôi thu thập, xử lý và bảo vệ thông tin cá nhân của khách hàng.</p>
  </section>

  {{-- 1 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">1. Sự Chấp Thuận</h4>
    <p>Khi truy cập, đăng ký tài khoản hoặc mua sắm tại <strong>olivine.vn</strong>, khách hàng được xem là đã
      đồng ý cho phép Olivine Fashion thu thập, xử lý và lưu trữ dữ liệu cá nhân của mình theo nội dung trong
      Chính sách này.</p>
    <p>Nếu khách hàng không đồng ý, vui lòng ngừng sử dụng dịch vụ hoặc liên hệ bộ phận chăm sóc khách hàng để được hỗ trợ.</p>
  </section>

  {{-- 2 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">2. Phạm Vi Thu Thập Dữ Liệu</h4>
    <p>Olivine chỉ thu thập thông tin cần thiết phục vụ cho hoạt động giao dịch và chăm sóc khách hàng, bao gồm:</p>
    <ul>
      <li>Họ tên, số điện thoại, email</li>
      <li>Địa chỉ giao hàng, địa chỉ thanh toán</li>
      <li>Lịch sử đơn hàng, sản phẩm yêu thích</li>
      <li>Dữ liệu tương tác trên website (cookie, tìm kiếm, hành vi mua sắm)</li>
      <li>Thông tin tài khoản Olivine (trừ mật khẩu)</li>
    </ul>
    <p class="text-muted">Olivine không thu thập dữ liệu cá nhân nhạy cảm như tài khoản ngân hàng, thông tin chính trị hoặc tôn giáo.</p>
  </section>

  {{-- 3 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">3. Mục Đích Xử Lý Dữ Liệu</h4>
    <ul>
      <li>Xử lý đơn hàng, xác nhận và giao hàng.</li>
      <li>Quản lý tài khoản khách hàng.</li>
      <li>Hỗ trợ chăm sóc khách hàng, khiếu nại, phản hồi.</li>
      <li>Cá nhân hóa trải nghiệm mua sắm, gợi ý sản phẩm phù hợp.</li>
      <li>Phân tích và cải thiện chất lượng dịch vụ.</li>
      <li>Đảm bảo an ninh, ngăn chặn gian lận và truy cập trái phép.</li>
      <li>Thực hiện yêu cầu của cơ quan nhà nước khi cần thiết.</li>
    </ul>
  </section>

  {{-- 4 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">4. Cách Thức Xử Lý Dữ Liệu</h4>
    <p>Dữ liệu cá nhân của khách hàng được thu thập và xử lý theo các phương thức sau:</p>
    <ul>
      <li><strong>Thu thập:</strong> trực tiếp khi khách hàng đăng ký, đặt hàng hoặc gián tiếp qua cookie.</li>
      <li><strong>Lưu trữ:</strong> trên hệ thống máy chủ bảo mật tại Việt Nam.</li>
      <li><strong>Chỉnh sửa/xóa:</strong> khách hàng có thể yêu cầu thay đổi hoặc xóa dữ liệu qua tài khoản cá nhân.</li>
      <li><strong>Chia sẻ:</strong> chỉ thực hiện khi có sự đồng ý hoặc theo quy định pháp luật.</li>
    </ul>
  </section>

  {{-- 5 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">5. Thời Gian Lưu Trữ</h4>
    <p>Dữ liệu cá nhân được lưu trữ trong suốt thời gian khách hàng có tài khoản hoặc giao dịch tại Olivine.</p>
    <p>Khi khách hàng yêu cầu xóa tài khoản, thông tin sẽ được xóa hoặc ẩn danh sau <strong>06 tháng</strong>, trừ khi pháp luật yêu cầu lưu giữ lâu hơn.</p>
  </section>

  {{-- 6 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">6. Không Chia Sẻ Dữ Liệu Cá Nhân Cho Bên Thứ Ba</h4>
    <p>Olivine không chia sẻ dữ liệu cá nhân của khách hàng, ngoại trừ:</p>
    <ul>
      <li>Đơn vị vận chuyển (để giao hàng đúng địa chỉ).</li>
      <li>Đối tác thanh toán (MoMo, VNPay, ZaloPay,...).</li>
      <li>Cơ quan quản lý nhà nước khi có yêu cầu hợp pháp.</li>
      <li>Đối tác công nghệ được ủy quyền (phải tuân thủ cam kết bảo mật).</li>
    </ul>
  </section>

  {{-- 7 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">7. An Toàn Dữ Liệu</h4>
    <ul>
      <li>Sử dụng mã hóa SSL và tường lửa bảo vệ hệ thống.</li>
      <li>Giới hạn quyền truy cập nội bộ chỉ cho nhân viên có thẩm quyền.</li>
      <li>Sao lưu dữ liệu định kỳ để phòng ngừa sự cố.</li>
      <li>Thông báo kịp thời cho khách hàng và cơ quan chức năng nếu có rò rỉ dữ liệu.</li>
    </ul>
  </section>

  {{-- 8 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">8. Rủi Ro Và Biện Pháp Xử Lý</h4>
    <p>Trong trường hợp xảy ra sự cố rò rỉ hoặc mất dữ liệu, Olivine sẽ:</p>
    <ul>
      <li>Thông báo công khai đến khách hàng bị ảnh hưởng.</li>
      <li>Phối hợp với cơ quan chức năng để điều tra, khắc phục.</li>
      <li>Áp dụng biện pháp kỹ thuật nhằm ngăn ngừa tái diễn.</li>
    </ul>
  </section>

  {{-- 9 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">9. Quyền Và Nghĩa Vụ Của Khách Hàng</h4>
    <h6 class="fw-semibold">Quyền của khách hàng:</h6>
    <ul>
      <li>Yêu cầu xem, chỉnh sửa hoặc xóa dữ liệu cá nhân của mình.</li>
      <li>Rút lại sự đồng ý cho phép xử lý dữ liệu.</li>
      <li>Khiếu nại hoặc yêu cầu bồi thường khi có vi phạm.</li>
    </ul>

    <h6 class="fw-semibold mt-3">Nghĩa vụ của khách hàng:</h6>
    <ul>
      <li>Cung cấp thông tin chính xác khi đăng ký tài khoản hoặc đặt hàng.</li>
      <li>Tự bảo vệ mật khẩu và thông tin cá nhân của mình.</li>
      <li>Tôn trọng quyền riêng tư của người khác.</li>
    </ul>
  </section>

  {{-- 10 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">10. Thông Tin Liên Hệ</h4>
    <p>Trường hợp có bất kỳ câu hỏi hoặc yêu cầu nào, vui lòng liên hệ:</p>
    <p><strong>CÔNG TY TNHH OLIVINE VIỆT NAM</strong><br>
      Website: <a href="https://olivine.vn" target="_blank">https://olivine.vn</a><br>
      Hotline: <strong>090 555 6787</strong><br>
      Email: <strong>cskh@olivine.vn</strong><br>
      Địa chỉ: 12 Nguyễn Văn Linh, Quận 7, TP. Hồ Chí Minh
    </p>
  </section>

  {{-- 11 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">11. Các Đơn Vị Liên Quan Đến Việc Xử Lý Dữ Liệu</h4>
    <ul>
      <li>Đơn vị vận chuyển: Giao Hàng Nhanh, Giao Hàng Tiết Kiệm</li>
      <li>Đối tác thanh toán: MoMo, VNPay, ZaloPay</li>
      <li>Đơn vị lưu trữ hệ thống: Cloud Việt Nam</li>
    </ul>
  </section>

  {{-- 12 --}}
  <section class="mb-5">
    <h4 class="h5 mb-3 fw-bold">12. Hiệu Lực</h4>
    <p>Chính sách này có hiệu lực kể từ ngày <strong>01/06/2025</strong>.</p>
    <p>Olivine có quyền thay đổi, bổ sung nội dung chính sách bất kỳ lúc nào và sẽ thông báo công khai trên website. Việc khách hàng tiếp tục sử dụng dịch vụ sau khi có bản cập nhật được xem như đã đồng ý với các thay đổi đó.</p>
  </section>
</div>

@endsection
