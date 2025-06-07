<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - BookFinity</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }
    .left-side {
      background: linear-gradient(270deg, #ff7300, #ff8c42, #1f2660, #1f2660);
      background-size: 800% 800%;
      animation: gradientMove 8s ease infinite;
      color: white;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
    }
    .left-side img {
      width: 200px;
      margin-bottom: 10px;
    }
    .left-side h1 { font-size: 2.5rem; font-weight: bold; margin-bottom: 10px; }
    .left-side h4 { font-size: 1.5rem; }
    .left-side p { margin-top: 1rem; font-size: 1.1rem; }
    .login-form {
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 100vh;
    }
    .form-control {
      border: 2px solid #FFA500;
      border-radius: 8px;
      font-size: 1rem;
      padding: 12px;
    }
    .form-label { color: #B45F22; font-weight: 600; }
    .btn-orange {
      background-color: #FFA500;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
    }
    .btn-orange:hover { background-color: #e69500; }
    .forgot-password {
      text-align: right;
      font-size: 0.9rem;
      color: #B45F22;
      margin-top: 5px;
      margin-bottom: 20px;
    }
    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
  </style>
</head>
<div class="container-fluid">
  <div class="row">
    <!-- Kiri -->
    <div class="col-md-6 left-side">
      <img src="{{ asset('img/logo_bookfinity_putih.png') }}" alt="BookFinity Logo" />
      <h1>BookFinity</h1>
      <h4 class="mt-3">Hello, <br /><strong>welcome!</strong></h4>
      <p>Perpustakaan digital <br /> kebutuhan Anda</p>
    </div>

    <!-- Kanan -->
    <div class="col-md-6 login-form">
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
          <label for="email" class="form-label">Email Address</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" />
          @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-2">
          <label for="password" class="form-label">Password</label>
          <input id="password" type="password" name="password" required class="form-control" />
          @error('password')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>

        <div class="forgot-password">
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot password?</a>
          @endif
        </div>

        <div class="d-flex justify-content-between">
          <button type="submit" class="btn btn-orange w-50 me-2">Login</button>
          <a href="{{ route('register') }}" class="btn btn-orange w-50 text-center">Sign Up</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Optional modal untuk notifikasi -->
@if(session('status'))
<div class="modal fade show d-block" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title">Pesan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="this.closest('.modal').remove()"></button>
      </div>
      <div class="modal-body">{{ session('status') }}</div>
    </div>
  </div>
</div>
@endif


@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
/* ... paste all your <style> content here ... */
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
</html>
