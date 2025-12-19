  @extends('layouts.app')
@section('content')
   <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">LIÊN HỆ VỚI CHÚNG TÔI</h2>
      </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
      <div class="mw-930">
        <div class="contact-us__form">
          <form name="contact-us-form" method="POST" action="{{ route('contact.submit') }}">
  @csrf
  <h3 class="mb-5">LIÊN HỆ</h3>

  {{-- Tên --}}
  <div class="form-floating my-4">
    <input type="text" class="form-control @error('name') is-invalid @enderror"
           name="name" value="{{ old('name') }}" placeholder="Tên *" required>
    <label for="contact_us_name">Tên *</label>
    @error('name')
      <span class="text-danger">{{ $message }}</span>
    @enderror
  </div>

  {{-- Số điện thoại --}}
  <div class="form-floating my-4">
    <input type="text" class="form-control @error('phone') is-invalid @enderror"
           name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại *" required>
    <label for="contact_us_phone">Số điện thoại *</label>
    @error('phone')
      <span class="text-danger">{{ $message }}</span>
    @enderror
  </div>

  {{-- Email --}}
  <div class="form-floating my-4">
    <input type="email" class="form-control @error('email') is-invalid @enderror"
           name="email" value="{{ old('email') }}" placeholder="Email *" required>
    <label for="contact_us_email">Địa chỉ Email *</label>
    @error('email')
      <span class="text-danger">{{ $message }}</span>
    @enderror
  </div>

  {{-- Lời nhắn --}}
  <div class="my-4">
    <textarea class="form-control @error('comment') is-invalid @enderror"
              name="comment" placeholder="Lời nhắn của bạn" rows="8" required>{{ old('comment') }}</textarea>
    @error('comment')
      <span class="text-danger">{{ $message }}</span>
    @enderror
  </div>

  <div class="my-4">
    <button type="submit" class="btn btn-primary">Nộp</button>
  </div>
</form>
@if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif

        </div>
      </div>
    </section>
  </main>

@endsection
