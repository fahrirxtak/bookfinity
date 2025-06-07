<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - BookFinity</title>
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

        .category-btn {
            margin: 0.2rem;
        }

        .book-card img {
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <script>
        const userId = "664ede2fbcab96905e0fc44d";

        // Load categories
        fetch('http://localhost:5000/api/books/categories')
            .then(res => res.json())
            .then(data => {
                const container = document.getElementById('category-list');
                data.forEach(cat => {
                    const btn = document.createElement('button');
                    btn.className = 'btn btn-outline-light category-btn';
                    btn.textContent = cat;
                    btn.onclick = () => loadBooks(cat);
                    container.appendChild(btn);
                });
            });

        // Load books
        function loadBooks(category = '') {
            const url = category ? `http://localhost:5000/api/books/category/${category}` :
                `http://localhost:5000/api/books`;
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('book-list');
                    container.innerHTML = '';
                    data.forEach(book => {
                        container.innerHTML += `
            <div class="col-md-3">
              <div class="card book-card">
                <img src="${book.coverUrl}" class="card-img-top" alt="${book.title}">
                <div class="card-body bg-white">
                  <h6 class="fw-bold text-dark">${book.title}</h6>
                  <p class="mb-1 text-muted">${book.author}</p>
                  <a href="book-detail.html?id=${book._id}" class="btn btn-sm btn-primary">Detail</a>
                  <button onclick="bookmark('${book._id}')" class="btn btn-sm btn-outline-secondary float-end"><i class="bi bi-bookmark"></i></button>
                </div>
              </div>
            </div>
          `;
                    });
                });
        }

        // Bookmark book
        function bookmark(bookId) {
            fetch(`http://localhost:5000/api/bookmarks/${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    bookId
                })
            }).then(() => alert("Book bookmarked!"));
        }

        // Initial Load
        loadBooks();
    </script>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 px-4">
        <span class="navbar-brand fw-bold text-white me-4" id="navbarUser">
            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/profileDefault.png') }}"
                class="rounded-circle me-2" width="40" height="40" loading="eager">
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

    <!-- Last Read -->
    <section class="bg-primary text-white p-4">
        <div class="container">
            <h4 class="fw-bold mb-3">Last Read</h4>
            <div class="row g-3" id="lastReadContainer">
                <!-- Buku terakhir dibaca akan dimunculkan di sini lewat JS -->
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="bg-orange text-white p-4">
        <div class="container">
            <h4 class="fw-bold mb-3">Categories</h4>
            <div class="d-flex flex-wrap" id="category-list">
                <button class="btn btn-light category-btn">All</button>
                <button class="btn btn-outline-light category-btn">Science Fiction</button>
                <button class="btn btn-outline-light category-btn">Fantasy</button>
                <button class="btn btn-outline-light category-btn">Business</button>
                <button class="btn btn-outline-light category-btn">Programming</button>
                <button class="btn btn-outline-light category-btn">AI</button>
                <button class="btn btn-outline-light category-btn">Political</button>
                <button class="btn btn-outline-light category-btn">Religion</button>
                <button class="btn btn-outline-light category-btn">Law</button>
                <button class="btn btn-outline-light category-btn">Medical</button>
                <button class="btn btn-outline-light category-btn">Biography</button>
                <button class="btn btn-outline-light category-btn">Children</button>
                <button class="btn btn-outline-light category-btn">Technology</button>
                <button class="btn btn-outline-light category-btn">Education</button>
                <button class="btn btn-outline-light category-btn">Self-Help</button>
            </div>
        </div>
    </section>

    <!-- Books Section -->
    <section class="p-4 bg-orange">
        <div class="container">
            <div class="row g-4" id="book-list">
                @foreach ($books as $book)
                    <div class="col-md-3">
                        <div class="card book-card">
                            <img src="{{ asset($book->img) }}" class="card-img-top" alt="{{ $book->title }}">
                            <div class="card-body">
                                <h6 class="fw-bold">{{ $book->title }}</h6>
                                <p class="mb-1 text-muted">{{ $book->author }}</p>
                                <a href="#" class="btn btn-sm btn-primary detail-btn"
                                    data-id="{{ $book->id }}" data-title="{{ $book->title }}"
                                    data-author="{{ $book->author }}" data-img="{{ asset($book->img) }}">
                                    Detail
                                </a>
                                <button class="btn btn-sm btn-outline-secondary float-end bookmark-btn"
                                    data-id="{{ $book->id }}" data-title="{{ $book->title }}"
                                    data-author="{{ $book->author }}" data-img="{{ asset($book->img) }}">
                                    <i class="bi bi-bookmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Update Navbar with user data -->
    <script>
        const assetBaseUrl = "{{ asset('') }}";

        const navbarUser = document.getElementById('navbarUser');

        const userData = JSON.parse(localStorage.getItem('userData'));
        if (userData) {
            document.getElementById('navbarUser').innerHTML = `
      <img src="${userData.avatar || 'img/default-avatar.png'}" class="rounded-circle me-2" width="40" height="40" loading="eager">
      Welcome, ${userData.name}
    `;
        }

        // Fungsi untuk ambil data user dari API
        async function loadNavbarUser() {
            try {
                const userId = userData?.id || 1; // Ganti 1 jika kamu punya logic userId lain
                const res = await fetch(`http://localhost:3000/api/profile/${userId}`);
                if (!res.ok) throw new Error("Gagal memuat profil user");

                const data = await res.json();

                // Simpan ke localStorage
                localStorage.setItem("userData", JSON.stringify(data));

                // Update tampilan navbar
                navbarUser.innerHTML = `
          <img src="${data.avatar || 'img/default-avatar.png'}" class="rounded-circle me-2" width="40" height="40" loading="eager">
          Welcome, ${data.name}
        `;
            } catch (err) {
                console.error("Gagal memperbarui navbar user:", err);
            }
        }

        // Jalankan saat halaman selesai dimuat
        window.addEventListener('DOMContentLoaded', loadNavbarUser);

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

        // Render Last Read section dari readHistory di localStorage
        function renderLastRead() {
            const container = document.getElementById('lastReadContainer');
            const history = JSON.parse(localStorage.getItem('readHistory')) || [];

            container.innerHTML = '';

            if (history.length === 0) {
                container.innerHTML = '<p class="text-white">Belum ada buku yang dibaca.</p>';
                return;
            }

            // Urutkan berdasarkan timestamp descending, ambil yang terbaru
            const sortedHistory = history.slice().sort((a, b) => b.timestamp - a.timestamp);
            const lastBook = sortedHistory[0];

            const dateRead = new Date(lastBook.timestamp).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            let imageSrc = '';

            if (lastBook.photo) {
                if (lastBook.photo.startsWith('http://') || lastBook.photo.startsWith('https://')) {
                    imageSrc = lastBook.photo; // sudah full URL, pakai langsung
                } else {
                    imageSrc = assetBaseUrl + lastBook.photo.replace(/^\/+/, ''); // path relatif, tambahkan base url
                }
            } else {
                imageSrc = assetBaseUrl + 'img/buku1.png'; // default image
            }


            console.log('lastBook.photo:', lastBook.photo);




            container.innerHTML = `
      <div class="col-md-3">
        <div class="card">
          <img src="${imageSrc}" class="card-img-top" alt="${lastBook.title}" style="height: 180px; object-fit: cover;">
          <div class="card-body text-dark">
            <small class="text-muted">Last Read ${dateRead}</small>
            <h6 class="fw-bold mb-0">${lastBook.title}</h6>
            <p class="mb-0">${lastBook.author || ''}</p>
            <a href="read-ebook" class="btn btn-sm btn-primary mt-2 btn-continue">Lanjutkan Membaca</a>
          </div>
        </div>
      </div>
    `;

            // Event tombol lanjutkan membaca
            container.querySelector('.btn-continue').addEventListener('click', (e) => {
                e.preventDefault();
                localStorage.setItem('selectedBook', JSON.stringify({
                    id: lastBook.id,
                    title: lastBook.title,
                    pdf: lastBook.pdf || 'pdf/sample-book.pdf',
                    photo: lastBook.photo || 'img/buku1.png'
                }));
                window.location.href = 'read-ebook';
            });
        }

        // Panggil renderLastRead saat halaman load
        renderLastRead();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
