<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Borrowing Confirmation - BookFinity</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #1f2660;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      background-color: #2c3370;
      border: none;
      border-radius: 1rem;
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    .btn-back {
      background-color: #f57c00;
      color: white;
      border-radius: 2rem;
      font-weight: bold;
    }
    .btn-back:hover {
      background-color: #e26c00;
    }
    .icon-check {
      font-size: 3rem;
      color: #4caf50;
    }
    .list-unstyled li {
      color: white;
    }
  </style>
</head>
<body>
  <div class="container text-center py-5">
    <img src="img/logo_bookfinity_putih.png" alt="Logo" width="80" class="mb-4">
    <h2 class="text-warning fw-bold mb-3">Borrowing Confirmed!</h2>
    <i class="bi bi-check-circle-fill icon-check mb-4"></i>
    <p class="mb-4 text-light">Thank you! Your borrowing request has been recorded successfully. Please check the details below.</p>

    <div class="card text-start mx-auto p-4 mb-4" style="max-width: 500px;">
      <h5 class="text-white fw-bold mb-3"><i class="bi bi-book-half me-2"></i>Borrowing Details</h5>
     <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('book') ? 'active' : '' }}" href="{{ route('book') }}">
                        <i class="bi bi-book"></i> Books
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('bookmark') ? 'active' : '' }}"
                        href="{{ route('bookmark') }}">
                        <i class="bi bi-bookmark"></i> Bookmarks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('history') ? 'active' : '' }}"
                        href="{{ route('history') }}">
                        <i class="bi bi-clock-history"></i> History
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                        href="{{ route('profile') }}">
                        <i class="bi bi-person-circle"></i> Profile
                    </a>
                </li>
            </ul>
    </div>

    <a href="{{ route('dashboard') }}" class="btn btn-back"><i class="bi bi-house-door-fill me-1"></i> Back to Dashboard</a>
  </div>

  <script>
    // Fungsi untuk menampilkan data konfirmasi
    function setConfirmationDetails() {
      const userData = JSON.parse(localStorage.getItem('userData')); // Ambil data pengguna
      const borrowData = JSON.parse(localStorage.getItem('borrowData')); // Ambil data peminjaman

      if (userData && borrowData) {
        // Menampilkan data pengguna
        document.getElementById('fullName').textContent = userData.name || 'Guest';
        document.getElementById('email').textContent = userData.email || '';
        document.getElementById('phone').textContent = userData.phone || '';

        // Menampilkan data peminjaman
        document.getElementById('borrowDate').textContent = borrowData.borrowDate || 'N/A';
        document.getElementById('returnDate').textContent = borrowData.returnDate || 'N/A';
      }

      // Menyimpan data peminjaman ke dalam history (untuk rekaman)
      const historyData = JSON.parse(localStorage.getItem('historyData')) || [];
      historyData.push(borrowData); // Menambahkan peminjaman baru ke history
      localStorage.setItem('historyData', JSON.stringify(historyData)); // Menyimpan kembali ke localStorage
    }

    // Memanggil fungsi untuk set data konfirmasi
    setConfirmationDetails();
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
