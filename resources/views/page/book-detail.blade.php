<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book Detail - BookFinity</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar-custom {
      background-color: #1f2660;
    }
    .bg-overlay {
      background: url('book-placeholder.jpg') no-repeat center center;
      background-size: cover;
      position: relative;
    }
    .bg-overlay::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(31, 38, 96, 0.5);
      z-index: 1;
    }
    .book-detail-content {
      position: relative;
      z-index: 2;
    }
    .book-img {
      height: 320px;
      object-fit: cover;
    }
    .btn-orange {
      background-color: #f57c00;
      color: white;
    }
    .btn-orange:hover {
      background-color: #e96e00;
    }
    .book-info p {
      font-size: 0.95rem;
    }
  </style>
</head>
<body>
      @php
        $user = Auth::user();
    @endphp

 <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 px-4">
  <span class="navbar-brand fw-bold text-white me-4" id="navbarUser">
    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/profileDefault.png') }}" class="rounded-circle me-2" width="40" height="40" loading="eager">
    Welcome {{ Auth::user()->name }}
  </span>
  <div class="collapse navbar-collapse">
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
      <form class="d-flex me-3" role="search">
        <input class="form-control me-2" type="search" placeholder="Search books here..." />
      </form>
      <img src="{{ asset('img/logo_bookfinity_putih.png') }}" alt="Logo" width="50">
    </div>
  </nav>

  <!-- Book Detail Section -->
  <section class="bg-overlay text-white py-5">
    <!-- Back Button -->
    <div class="container book-detail-content mb-3">
      <a href="{{ route('book') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left"></i> Back to Books</a>
    </div>

    <div class="container book-detail-content">
      <div class="row align-items-center g-4">
        <!-- Book Image -->
        <div class="col-md-4 text-center">
          <img id="bookImage" src="" alt="Book" class="img-fluid rounded book-img shadow-lg">
        </div>

        <!-- Book Info -->
        <div class="col-md-8 book-info">
          <h2 id="bookTitle" class="fw-bold">Judul Buku</h2>
          <p class="text-light mb-1">Penulis: <strong id="bookAuthor">Penulis</strong></p>
          <p id="bookDesc" class="text-light mb-4">Deskripsi buku akan muncul di sini.</p>

          <!-- Buttons -->
          <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('borrow-detail') }}" class="btn btn-orange"><i class="bi bi-download me-1"></i> Offline Borrowing</a>
            <a href="{{ route('read-ebook') }}" class="btn btn-outline-light"
               onclick="startReading()"><i class="bi bi-book me-1"></i> Read E-Book</a>
          </div>
        </div>
      </div>
    </div>
  </section>

    <!-- Update Navbar with user data -->
<script>
  const userData = JSON.parse(localStorage.getItem('userData'));
  if (userData) {
    document.getElementById('navbarUser').innerHTML = `
      <img src="${userData.avatar || 'img/default-avatar.png'}" class="rounded-circle me-2" width="40" height="40" loading="eager">
      Welcome, ${userData.name}
    `;
  }

  async function loadNavbarUser() {
    try {
      const res = await fetch(`http://localhost:3000/api/profile/${userId}`);
      if (!res.ok) throw new Error("Gagal memuat profil user");
      const data = await res.json();
      localStorage.setItem("userData", JSON.stringify(data));
      document.getElementById('navbarUser').innerHTML = `
        <img src="${data.avatar || 'img/default-avatar.png'}" class="rounded-circle me-2" width="40" height="40" loading="eager">
        Welcome, ${data.name}
      `;
    } catch (err) {
      console.error("Gagal memperbarui navbar user:", err);
    }
  }

  loadNavbarUser();
</script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Book Detail Script -->
  <script>
    const book = JSON.parse(localStorage.getItem("selectedBook"));

    if (book) {
      document.getElementById("bookImage").src = book.img || "img/default-cover.jpg";
      document.getElementById("bookImage").alt = book.title;
      document.getElementById("bookTitle").textContent = book.title;
      document.getElementById("bookAuthor").textContent = book.author;
      document.getElementById("bookDesc").textContent = book.description || "Tidak ada deskripsi.";
    } else {
      document.querySelector(".book-detail-content").innerHTML = "<div class='alert alert-danger'>Buku tidak ditemukan.</div>";
    }

    function startReading() {
      if (!book) return alert("Buku tidak ditemukan.");

      // Kirim data buku lengkap ke halaman read-ebook.html melalui localStorage
      localStorage.setItem("selectedBook", JSON.stringify({
        id: book.id,
        title: book.title,
        pdf: book.pdf || "pdf/sample-book.pdf",
        img: book.img,
      }));
    }
  </script>
</body>
</html>
