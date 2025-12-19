@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
      <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link nav-link_underscore active" id="register-tab" data-bs-toggle="tab"
            href="#tab-item-register" role="tab" aria-controls="tab-item-register" aria-selected="true">ĐĂNG KÝ</a>
        </li>
      </ul>
      <div class="tab-content pt-2" id="login_register_tab_content">
        <div class="tab-pane fade show active" id="tab-item-register" role="tabpanel" aria-labelledby="register-tab">
          <div class="register-form">
            <form method="POST" action="#" name="register-form" class="needs-validation" novalidate="">
              <div class="form-floating mb-3">
                <input class="form-control form-control_gray " name="name" value="" required="" autocomplete="name"
                  autofocus="">
                <label for="name">Họ và tên</label>
              </div>
              <div class="pb-3"></div>
              <div class="form-floating mb-3">
                <input id="email" type="email" class="form-control form-control_gray " name="email" value="" required=""
                  autocomplete="email">
                <label for="email">Địa chỉ Email *</label>
              </div>

              <div class="pb-3"></div>

              <div class="form-floating mb-3">
                <input id="mobile" type="text" class="form-control form-control_gray " name="mobile" value=""
                  required="" autocomplete="mobile">
                <label for="mobile">Số điện thoại *</label>
              </div>

              <div class="pb-3"></div>

              <div class="form-floating mb-3">
                <input id="password" type="password" class="form-control form-control_gray " name="password" required=""
                  autocomplete="new-password">
                <label for="password">Mật khẩu *</label>
              </div>

              <div class="form-floating mb-3">
                <input id="password-confirm" type="password" class="form-control form-control_gray"
                  name="password_confirmation" required="" autocomplete="new-password">
                <label for="password">Xác nhận lại mật khẩu *</label>
              </div>

              <div class="d-flex align-items-center mb-3 pb-2">
                <p class="m-0">Dữ liệu cá nhân của bạn sẽ được sử dụng để hỗ trợ trải nghiệm của bạn trên toàn bộ trang web này, 
                    để quản lý quyền truy cập vào tài khoản của bạn và cho các mục đích khác được mô tả trong chính sách bảo mật của chúng tôi.</p>
              </div>

              <button class="btn btn-primary w-100 text-uppercase" type="submit">ĐĂNG KÝ</button>

              <div class="customer-option mt-4 text-center">
                <span class="text-secondary">Quên mật khẩu?</span>
                <a href="{{ route('login') }}" class="btn-text js-show-register">Đăng nhập</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection