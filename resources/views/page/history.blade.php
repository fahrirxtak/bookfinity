<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>History - BookFinity</title>
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

        .history-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .history-card img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .nav-tabs .nav-link.active {
            background-color: #f57c00;
            color: white;
            font-weight: bold;
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

    <!-- Header -->
    <header class="bg-orange text-white py-4 text-center">
        <h2 class="fw-bold">Riwayat Membaca</h2>
        <p>Lacak buku yang telah kamu baca sebelumnya.</p>
    </header>

    <!-- Tabs -->
    <div class="container my-4">
        <ul class="nav nav-tabs mb-3" id="historyTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="ebook-tab" data-bs-toggle="tab" data-bs-target="#ebook"
                    type="button" role="tab">History E-Book</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="borrow-tab" data-bs-toggle="tab" data-bs-target="#borrow" type="button"
                    role="tab">History Borrowing Offline</button>
            </li>
        </ul>

        <div class="tab-content" id="historyTabsContent">
            <!-- Tab 1: History E-Book -->
            <div class="tab-pane fade show active" id="ebook" role="tabpanel">
                <div class="d-flex justify-content-end mb-2">
                    <button id="clearAllBtn" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus Semua
                        Riwayat</button>
                </div>
                <div class="row g-3" id="ebookHistoryContainer">
                    <!-- Riwayat akan dimuat lewat JavaScript -->
                </div>
            </div>

            <!-- Tab 2: History Borrowing Offline -->
            <div class="tab-pane fade" id="borrow" role="tabpanel">
                <div class="d-flex justify-content-end mb-2">
                    <button id="clearOfflineHistoryBtn" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus
                        Semua Riwayat</button>
                </div>
                <div class="row g-3" id="historyList">
                    <!-- Riwayat peminjaman offline akan dimuat lewat JavaScript -->
                </div>

                <div id="noHistory" class="text-center text-white-50" style="display:none;">
                    <p>No borrowing history found.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const borrowHistory = JSON.parse(localStorage.getItem('borrowHistory')) || [];
            const historyList = document.getElementById('historyList');

            if (borrowHistory.length === 0) {
                historyList.innerHTML = '<p>Tidak ada data peminjaman.</p>';
                return;
            }

            let html = '<div class="row">';
            borrowHistory.forEach(borrow => {

                html += `
        <div class="col-md-10">
          <div class="d-flex align-items-center history-card mb-3 p-3 border rounded shadow-sm">
            <div class="flex-grow-1">
              <p class="mb-1"><strong>Nama:</strong> ${borrow.name}</p>
              <p class="mb-1 text-muted">Dipinjam pada: ${borrow.borrowDate}</p>
              <p class="mb-1 text-muted">Harus dikembalikan pada: ${borrow.returnDate}</p>
            </div>
          </div>
        </div>
        `;
            });
            html += '</div>';

            historyList.innerHTML = html;
        });


        // Menampilkan riwayat peminjaman offline
        function loadOfflineHistory() {
            const historyData = JSON.parse(localStorage.getItem('historyData')) || [];
            const offlineHistoryContainer = document.getElementById('historyList');
            const noHistoryDiv = document.getElementById('noHistory');

            offlineHistoryContainer.innerHTML = ""; // reset container

            if (historyData.length === 0) {
                noHistoryDiv.style.display = "block";
                return;
            } else {
                noHistoryDiv.style.display = "none";
            }

            historyData.forEach((borrow) => {
                const cardHTML = `
        <div class="col-md-12">
          <div class="d-flex align-items-center history-card mb-3">
            <img src="${borrow.bookImage || 'img/default-cover.jpg'}" alt="Cover buku ${borrow.bookTitle}" class="me-3">
            <div class="flex-grow-1">
              <h6 class="fw-bold mb-1">${borrow.bookTitle}</h6>
              <p class="mb-1 text-muted">Dipinjam pada: ${borrow.borrowDate}</p>
              <p class="mb-1 text-muted">Harus dikembalikan pada: ${borrow.returnDate}</p>
              <a href="book-detail.html" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-info-circle"></i> Detail Buku</a>
            </div>
          </div>
        </div>
      `;
                offlineHistoryContainer.innerHTML += cardHTML;
            });
        }


        // Memanggil fungsi untuk menampilkan riwayat peminjaman offline
        loadOfflineHistory();

        // Menambahkan event listener untuk tombol hapus semua riwayat peminjaman offline
        document.getElementById("clearOfflineHistoryBtn").addEventListener("click", function() {
            if (confirm("Yakin ingin menghapus semua riwayat peminjaman offline?")) {
                localStorage.removeItem("historyData");
                loadOfflineHistory(); // Memuat ulang setelah dihapus
            }
        });
    </script>

    <script>
        const container = document.getElementById("ebookHistoryContainer");
        let history = JSON.parse(localStorage.getItem("readHistory")) || [];

        function renderHistory() {
            container.innerHTML = "";
            if (history.length === 0) {
                container.innerHTML = "<div class='alert alert-info'>Belum ada riwayat membaca.</div>";
                return;
            }

            // Render history terbaru di atas
            history.slice().reverse().forEach((book, index) => {
                const date = new Date(book.timestamp).toLocaleDateString("id-ID", {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                // Gunakan fallback image jika image tidak ada
                const imageSrc = book.photo || "img/default-cover.jpg";
                console.log(imageSrc)

                const item = document.createElement("div");
                item.className = "col-md-12";
                item.innerHTML = `
        <div class="d-flex align-items-center history-card">
          <img src="${imageSrc}" alt="Cover buku ${book.title}" class="me-3">
          <div class="flex-grow-1">
            <h6 class="fw-bold mb-1">${book.title}</h6>
            <p class="mb-1 text-muted">Dibaca pada: ${date}</p>
            <a href="read-ebook.html" class="btn btn-sm btn-primary me-2 btn-continue" data-index="${index}"><i class="bi bi-book"></i> Lanjutkan Membaca</a>
            <a href="book-detail?id=${book.id}" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-info-circle"></i> Detail</a>
            <button class="btn btn-sm btn-danger btn-delete" data-index="${index}"><i class="bi bi-x-circle"></i> Hapus</button>
          </div>
        </div>
      `;
                container.appendChild(item);
            });

            // Event tombol hapus
            document.querySelectorAll(".btn-delete").forEach(btn => {
                btn.addEventListener("click", function() {
                    const indexToDelete = history.length - 1 - this.dataset.index;
                    history.splice(indexToDelete, 1);
                    localStorage.setItem("readHistory", JSON.stringify(history));
                    renderHistory();
                });
            });

            // Event tombol lanjutkan membaca untuk mengirim data buku ke halaman read-ebook
            document.querySelectorAll(".btn-continue").forEach(btn => {
                btn.addEventListener("click", function(event) {
                    event.preventDefault();
                    const idx = this.dataset.index;
                    const bookToRead = history[idx];
                    if (!bookToRead) {
                        alert("Buku tidak ditemukan.");
                        return;
                    }
                    // Simpan data buku untuk dibaca di halaman read-ebook.html
                    localStorage.setItem("selectedBook", JSON.stringify({
                        id: bookToRead.id,
                        title: bookToRead.title,
                        pdf: bookToRead.pdf || "pdf/sample-book.pdf",
                        image: bookToRead.image || "img/default-cover.jpg"
                    }));
                    // Redirect ke halaman baca ebook
                    window.location.href = "read-ebook";
                });
            });
        }

        // Tombol hapus semua
        document.getElementById("clearAllBtn").addEventListener("click", function() {
            if (confirm("Yakin ingin menghapus semua riwayat membaca?")) {
                localStorage.removeItem("readHistory");
                history = [];
                renderHistory();
            }
        });

        renderHistory();
    </script>

    <script>
        const userId = localStorage.getItem('userId') || "664ede2fbcab96905e0fc44d";

        // Render user dari localStorage secara langsung
        const userData = JSON.parse(localStorage.getItem('userData'));
        if (userData) {
            document.getElementById('navbarUser').innerHTML = `
      <img src="${userData.avatar || 'img/default-avatar.png'}" class="rounded-circle me-2" width="40" height="40" loading="eager" alt="Avatar">
      Welcome, ${userData.name}
    `;
        }

        // Fetch update user info (silent update)
        async function loadNavbarUser() {
            try {
                const res = await fetch(`http://localhost:3000/api/profile/${userId}`);
                if (!res.ok) throw new Error("Gagal memuat profil user");
                const data = await res.json();
                localStorage.setItem("userData", JSON.stringify(data)); // simpan agar cepat load next time

                document.getElementById('navbarUser').innerHTML = `
        <img src="${data.avatar || 'img/default-avatar.png'}" class="rounded-circle me-2" width="40" height="40" loading="eager" alt="Avatar">
        Welcome, ${data.name}
      `;
            } catch (err) {
                console.error(err);
            }
        }

        loadNavbarUser();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
