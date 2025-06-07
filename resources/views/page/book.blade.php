<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Books - BookFinity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
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

        .filter-bar select {
            max-width: 200px;
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
                <input class="form-control me-2" type="search" placeholder="Search books here..."
                    aria-label="Search books" />
            </form>
                 <img src="{{ asset('img/logo_bookfinity_putih.png') }}" alt="Logo" width="50">
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-orange text-white py-4 text-center">
        <h2 class="fw-bold">Daftar Buku</h2>
        <p>Temukan dan jelajahi koleksi buku digital kami.</p>
    </header>

    <!-- Filter & Sort -->
<section class="container my-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2">
            <select class="form-select" aria-label="Filter by category">
                <option selected>Filter: All</option>
                <option value="1">Science</option>
                <option value="2">Technology</option>
                <option value="3">Religion</option>
                <option value="4">Business</option>
                <option value="5">Fiction</option>
            </select>
            <select class="form-select" aria-label="Sort by">
                <option selected>Sort by: Terbaru</option>
                <option value="1">A - Z</option>
                <option value="2">Popularitas</option>
            </select>
        </div>
    </div>

    <!-- Book Cards -->
    <div class="row g-4">
        @foreach ($books as $book)
        <div class="col-md-3">
            <div class="card book-card">
                <img src="{{ $book->img ?? 'img/default-cover.jpg' }}" class="card-img-top" alt="{{ $book->title }}">
                <div class="card-body">
                    <h6 class="fw-bold">{{ $book->title }}</h6>
                    <p class="mb-1 text-muted">{{ $book->author }}</p>
                    <a href="#" class="btn btn-sm btn-primary detail-btn"
                       data-id="{{ $book->id }}"
                       data-title="{{ $book->title }}"
                       data-author="{{ $book->author }}"
                       data-img="{{ $book->img ?? 'img/default-cover.jpg' }}">Detail</a>
                    <button class="btn btn-sm btn-outline-secondary float-end bookmark-btn"
                            data-id="{{ $book->id }}"
                            data-title="{{ $book->title }}"
                            data-author="{{ $book->author }}"
                            data-img="{{ $book->img ?? 'img/default-cover.jpg' }}">
                        <i class="bi bi-bookmark"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link">Previous</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</section>


    <!-- Script -->
    <script>
        const userId = localStorage.getItem('userId') || "664ede2fbcab96905e0fc44d";

        // Render user from localStorage instantly
        const userData = JSON.parse(localStorage.getItem('userData'));
        if (userData) {
            document.getElementById('navbarUser').innerHTML = `
      <img src="${userData.avatar || 'img/default-avatar.png'}" class="rounded-circle me-2" width="40" height="40" loading="eager" alt="User Avatar">
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
        <img src="${data.avatar || 'img/default-avatar.png'}" class="rounded-circle me-2" width="40" height="40" loading="eager" alt="User Avatar">
        Welcome, ${data.name}
      `;
            } catch (err) {
                console.error(err);
            }
        }

        loadNavbarUser();

        // Tombol detail
        document.querySelectorAll('.detail-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const book = {
                    id: this.dataset.id,
                    title: this.dataset.title,
                    author: this.dataset.author,
                    img: this.dataset.img
                };
                localStorage.setItem('selectedBook', JSON.stringify(book));
                window.location.href = 'book-detail';
            });
        });

        // Tombol bookmark
        document.querySelectorAll('.bookmark-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const book = {
                    id: this.dataset.id,
                    title: this.dataset.title,
                    author: this.dataset.author,
                    img: this.dataset.img
                };
                let bookmarks = JSON.parse(localStorage.getItem('bookmarks')) || [];
                if (!bookmarks.find(b => b.id === book.id)) {
                    bookmarks.push(book);
                    localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
                    alert('Book bookmarked!');
                } else {
                    alert('This book is already bookmarked.');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
