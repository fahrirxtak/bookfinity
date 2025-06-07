<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bookmark - BookFinity</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar-custom {
      background-color: #1f2660;
    }
    .bg-orange {
      background-color: #f57c00;
    }
    .book-card img {
      height: 300px;
      object-fit: cover;
    }
    .book-card .card-body {
      background-color: white;
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

  <!-- Header -->
  <header class="bg-orange text-white py-4 text-center">
    <h2 class="fw-bold">Bookmark Buku</h2>
    <p>Kumpulan buku yang telah Anda tandai.</p>
  </header>

  <!-- Bookmarked Books -->
  <section class="container my-4">
    <div class="row g-4" id="bookmarkList">
      <!-- Bookmarked items will be rendered here -->
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Bookmark Script -->
  <script>
    const container = document.getElementById("bookmarkList");
    let bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];

    function renderBookmarks() {
      container.innerHTML = "";

      if (bookmarks.length === 0) {
        container.innerHTML = '<div class="col-12"><div class="alert alert-warning text-center">Belum ada bookmark buku.</div></div>';
        return;
      }

      bookmarks.forEach((book, index) => {
        const col = document.createElement("div");
        col.className = "col-md-3";
        col.innerHTML = `
          <div class="card book-card shadow-sm">
            <img src="${book.img || 'img/default-cover.jpg'}" class="card-img-top" alt="Book Cover">
            <div class="card-body">
              <h6 class="fw-bold">${book.title}</h6>
              <p class="text-muted mb-1">Penulis: ${book.author}</p>
              <a href="book-detail" class="btn btn-sm btn-primary" onclick="viewDetail(${index})">Detail</a>
              <button class="btn btn-sm btn-outline-danger float-end" title="Hapus Bookmark" onclick="removeBookmark(${index})">
                <i class="bi bi-bookmark-x"></i>
              </button>
            </div>
          </div>
        `;
        container.appendChild(col);
      });
    }

    function viewDetail(index) {
      localStorage.setItem("selectedBook", JSON.stringify(bookmarks[index]));
    }

    function removeBookmark(index) {
      if (confirm("Hapus bookmark ini?")) {
        bookmarks.splice(index, 1);
        localStorage.setItem("bookmarks", JSON.stringify(bookmarks));
        renderBookmarks();
      }
    }

    renderBookmarks();

    // =============================================
    // Script untuk update navbar user info (nama + foto)
    <!-- Script -->
  const userId = localStorage.getItem('userId') || "664ede2fbcab96905e0fc44d";

  // Render user from localStorage instantly
  const userData = JSON.parse(localStorage.getItem('userData'));
  if (userData) {
    document.getElementById('navbarUser').innerHTML = `
      <img src="${userData.avatar || 'img/default-avatar.png'}" class="rounded-circle me-2" width="40" height="40" loading="eager">
      Welcome, ${userData.name}
    `;
  }

    // Fetch updated user info (silent update)
  async function loadNavbarUser() {
    try {
      const res = await fetch(`http://localhost:3000/api/profile/${userId}`);
      if (!res.ok) throw new Error("Gagal memuat profil user");
      const data = await res.json();
      localStorage.setItem("userData", JSON.stringify(data)); // simpan agar cepat load next time

      document.getElementById('navbarUser').innerHTML = `
        <img src="${data.avatar || 'img/default-avatar.png'}" class="rounded-circle me-2" width="40" height="40" loading="eager">
        Welcome, ${data.name}
      `;
    } catch (err) {
      console.error(err);
    }
  }

  loadNavbarUser();
  </script>
</body>
</html>
