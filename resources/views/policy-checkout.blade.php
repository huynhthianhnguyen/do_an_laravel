@extends('layouts.app')

@section('title', 'Chính Sách Bảo Mật Thanh Toán | Olivine Fashion')

@section('content')
<div class="container my-5">
  <h2 class="text-center fw-bold mb-4">CHÍNH SÁCH BẢO MẬT THANH TOÁN</h2>

  <h4>1. Sự Chấp Thuận</h4>
  <p>Hệ thống thanh toán của <strong>Olivine Fashion</strong> được vận hành thông qua các <strong>Đối tác cổng thanh toán</strong> đã được cấp phép hoạt động hợp pháp tại Việt Nam. Tất cả quy trình thanh toán đều tuân thủ các tiêu chuẩn bảo mật cao nhất trong ngành tài chính – ngân hàng.</p>

  <h4 class="mt-4">2. Quy định bảo mật</h4>
  <p><strong>Olivine Fashion</strong> cam kết áp dụng đầy đủ các quy chuẩn bảo mật theo quy định của các đối tác thanh toán và pháp luật Việt Nam, bao gồm:</p>
  <ul>
    <li>Thông tin tài chính của khách hàng được bảo vệ bằng giao thức <strong>SSL (Secure Sockets Layer)</strong> – mã hóa toàn bộ dữ liệu trong suốt quá trình giao dịch.</li>
    <li>Tuân thủ tiêu chuẩn bảo mật dữ liệu thanh toán quốc tế <strong>PCI DSS</strong>.</li>
    <li>Sử dụng <strong>Mật khẩu dùng một lần (OTP)</strong> xác nhận qua SMS để bảo vệ tài khoản người dùng.</li>
    <li>Áp dụng cơ chế mã hóa dữ liệu nâng cao (<strong>MD5 12-bit</strong>).</li>
    <li>Thực hiện đúng các quy định bảo mật của Ngân hàng Nhà nước Việt Nam.</li>
  </ul>

  <p><strong>Chính sách bảo mật trong thanh toán của Olivine Fashion</strong> được áp dụng như sau:</p>
  <ul>
    <li>Olivine chỉ lưu trữ <strong>Token</strong> – chuỗi mã hóa được cung cấp bởi đối tác cổng thanh toán, không trực tiếp lưu giữ thông tin thẻ của khách hàng.</li>
    <li>Đối với <strong>thẻ quốc tế</strong>: Thông tin thẻ được lưu trữ và bảo mật bởi đối tác cổng thanh toán.</li>
    <li>Đối với <strong>thẻ nội địa (Internet Banking)</strong>: Olivine chỉ lưu lại mã đơn hàng, mã giao dịch và tên ngân hàng.</li>
    <li>Trong trường hợp phát sinh sự cố (thông tin bị thay đổi, xóa, sao chép hoặc chiếm đoạt), Olivine sẽ phối hợp với đối tác thanh toán để điều tra và xử lý nhanh chóng, đảm bảo quyền lợi cho khách hàng.</li>
  </ul>

  <p>Olivine Fashion cam kết thực hiện nghiêm túc mọi biện pháp cần thiết để đảm bảo an toàn cho hoạt động thanh toán trên website/ứng dụng của chúng tôi.</p>
  <p>Chính Sách Bảo Mật Dữ Liệu Cá Nhân của Olivine cũng được áp dụng song song để đảm bảo an toàn tuyệt đối cho thông tin thanh toán của khách hàng.</p>

  <h4 class="mt-4">3. Hiệu Lực</h4>
  <p>Chính Sách Bảo Mật Thanh Toán này có hiệu lực từ ngày <strong>01/06/2024</strong>.</p>
  <p><strong>Olivine Fashion</strong> có quyền cập nhật, chỉnh sửa nội dung chính sách này bất kỳ lúc nào. Mọi thay đổi sẽ được công khai trên website <a href="/">olivine.vn</a>. Việc Quý khách tiếp tục sử dụng dịch vụ của Olivine sau khi có thay đổi đồng nghĩa với việc chấp thuận các điều chỉnh đó.</p>
</div>
@endsection
