<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Read E-Book - BookFinity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
        }

        .navbar-custom {
            background-color: #1f2660;
        }

        .ebook-header {
            background-color: #f57c00;
            color: white;
            padding: 20px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        iframe {
            border: 3px solid #1f2660;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-back {
            background-color: #1f2660;
            color: white;
            border-radius: 20px;
        }

        .btn-back:hover {
            background-color: #141a40;
        }

        .btn-end {
            background-color: #dc3545;
            color: white;
            border-radius: 20px;
        }

        .btn-end:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4 py-2">
        <a class="navbar-brand fw-bold text-white" href="dashboard">
            <img src="img/logo_bookfinity_putih.png" width="40" class="me-2" alt="Logo">
            BookFinity
        </a>
    </nav>

    <!-- Header -->
    <div class="ebook-header text-center">
        <h2 class="fw-bold">Baca Buku</h2>
        <p class="mb-0">Sekarang membaca lebih mudah dan menyenangkan di BookFinity!</p>
    </div>

    <!-- Viewer -->
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="text-dark">📘 <span id="bookTitle" class="fw-bold text-primary">Judul Buku</span></h4>
            <div class="d-flex gap-2">
                <a href="{{ route('book-detail') }}" class="btn btn-back btn-sm"><i class="bi bi-arrow-left"></i>
                    Kembali</a>
                <button class="btn btn-end btn-sm" onclick="endReading()"><i class="bi bi-check-circle"></i> Akhiri
                    Membaca</button>
            </div>
        </div>

        <iframe id="pdfViewer" src="" width="100%" height="650px" title="E-Book Viewer"></iframe>
    </div>

    <script>
        const baseUrl = "{{ asset('') }}";
        const book = JSON.parse(localStorage.getItem("selectedBook"));

        if (book) {
            document.getElementById("bookTitle").textContent = book.title;
            document.getElementById("pdfViewer").src = book.pdf || "pdf/sample-book.pdf";
        } else {
            document.querySelector(".container").innerHTML =
                "<div class='alert alert-danger'>Data buku tidak ditemukan.</div>";
        }

        function endReading() {
            if (book) {
                // Cek properti photo, kalau gak ada coba img
                const bookPhoto = book.photo || book.img || 'img/default-cover.jpg';

                // Simpan ke readHistory
                const history = JSON.parse(localStorage.getItem("readHistory")) || [];
                const alreadyExists = history.some(item => item.id === book.id);

                if (!alreadyExists) {
                    history.push({
                        id: book.id,
                        title: book.title,
                        author: book.author,
                        photo: bookPhoto,
                        timestamp: new Date().toISOString()
                    });
                    localStorage.setItem("readHistory", JSON.stringify(history));
                }

                localStorage.setItem('lastRead', JSON.stringify({
                    id: book.id,
                    title: book.title,
                    author: book.author,
                    photo: bookPhoto,
                    timestamp: Date.now()
                }));

                const lastBook = JSON.parse(localStorage.getItem('lastRead'));
                console.log(lastBook); // Pastikan photo muncul
            }

            alert("Terima kasih telah membaca di BookFinity!");
            window.location.href = "history";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
