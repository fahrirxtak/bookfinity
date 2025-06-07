
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - BookFinity</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }
    .right-side {
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
    .right-side img {
      width: 200px;
      margin-bottom: 10px;
    }
    .register-form {
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
    .form-label {
      color: #B45F22;
      font-weight: 600;
    }
    .btn-orange {
      background-color: #FFA500;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      padding: 10px 20px;
      border: none;
      transition: background-color 0.3s ease;
    }
    .btn-orange:hover { background-color: #e69500; }
    a { color: #B45F22; }
    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 register-form">
        <form id="registerForm" action="{{ route('register') }}" method="POST" novalidate>
          @csrf

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="mb-4">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required />
          </div>
          <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required />
          </div>
          <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required />
          </div>
          <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required />
          </div>
          <button type="submit" class="btn btn-orange w-100">Sign Up</button>
          <div class="text-center mt-3">
            <small>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></small>
          </div>
        </form>
      </div>

      <div class="col-md-6 right-side">
        <img src="{{ asset('img/logo_bookfinity_putih.png') }}" alt="BookFinity Logo" />
        <h1>BookFinity</h1>
        <h4 class="mt-3">Create your account</h4>
        <p>Daftar dan nikmati layanan <br /> perpustakaan digital kami</p>
      </div>
    </div>
  </div>
</body>
</html>

