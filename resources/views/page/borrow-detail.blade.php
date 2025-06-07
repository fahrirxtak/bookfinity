<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Borrowing Details - BookFinity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #1f2660;
            color: white;
        }

        .form-control,
        .form-control:focus {
            background-color: transparent;
            color: white;
            border: 2px solid #fff;
            border-radius: 2rem;
        }

        .form-control::placeholder {
            color: #d0d0d0;
        }

        .form-label {
            margin-left: 0.5rem;
        }

        .btn-orange {
            background-color: #f57c00;
            color: white;
            border-radius: 1.5rem;
            padding: 10px 24px;
            font-weight: bold;
        }

        .btn-orange:hover {
            background-color: #e26c00;
        }

        .avatar {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
        }

        .back-btn {
            position: absolute;
            left: 20px;
            top: 20px;
            font-size: 1.5rem;
            color: white;
        }
    </style>
</head>

<body>
    @php
        $user = Auth::user();
    @endphp

    <div class="container text-center py-5 position-relative">
        <a href="{{ route('book-detail') }}" class="back-btn"><i class="bi bi-arrow-left-circle-fill"></i></a>

        <img src="{{ asset('img/logo_bookfinity_putih.png') }}" alt="Logo" width="80" class="mb-2">
        <h6 class="text-white-50">Borrowing Details</h6>
        <h4 class="text-warning fw-bold mb-4">BookFinity Library Services</h4>

        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/profileDefault.png') }}"
            class="rounded-circle me-2" width="40" height="40" loading="eager" alt="User Photo">
        <h5 id="userName" class="fw-bold mb-0">{{ $user->name }}</h5>

        <form id="borrowForm" class="mt-4 text-start mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-person-fill me-2"></i>Full Name</label>
                <input type="text" id="fullName" class="form-control" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-envelope-fill me-2"></i>Email</label>
                <input type="email" id="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-telephone-fill me-2"></i>Phone Number</label>
                <input type="text" id="phone" class="form-control" placeholder="Enter Your Phone Number"
                    required value="{{ $user->phone }}">
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-calendar-date-fill me-2"></i>Borrow Date</label>
                <input type="date" id="borrowDate" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label"><i class="bi bi-calendar-check-fill me-2"></i>Return Date</label>
                <input type="date" id="returnDate" class="form-control" required>
            </div>

            {{-- Foto Buku (readonly) --}}
            <div class="mb-4">
                <label class="form-label"><i class="bi bi-book-fill me-2"></i>Book Cover</label><br>
                <img src="{{ $book->photo ?? asset('img/default-cover.jpg') }}" alt="Book Cover" id="bookCover"
                    style="max-width: 100%; height: auto;">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-orange">CONFIRMATION</button>
            </div>
        </form>
    </div>


    <script>
        // Mengambil data user dari localStorage
        function setUserProfile() {
            const userData = JSON.parse(localStorage.getItem('userData'));
            if (userData) {
                const {
                    name,
                    email,
                    phone,
                    avatar
                } = userData;

                // Menampilkan data user ke dalam elemen HTML
                document.getElementById('userName').textContent = name || 'Guest';
                document.getElementById('fullName').value = name || '';
                document.getElementById('email').value = email || '';
                document.getElementById('phone').value = phone || '';

                // Mengatur foto profil
                document.getElementById('profileImg').src = avatar || 'img/default-avatar.png';
            }
        }

        // Saat form disubmit, simpan data ke localStorage dan arahkan ke confirmation.html
        document.getElementById('borrowForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const borrowData = {
                name: document.getElementById('fullName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                borrowDate: document.getElementById('borrowDate').value,
                returnDate: document.getElementById('returnDate').value
            };



            // Ambil data lama dari localStorage (jika ada), atau buat array kosong
            let borrowHistory = JSON.parse(localStorage.getItem('borrowHistory')) || [];

            // Tambahkan data baru ke array
            borrowHistory.push(borrowData);

            // Simpan kembali ke localStorage
            localStorage.setItem('borrowHistory', JSON.stringify(borrowHistory));
            console.log('borrowHistory', JSON.stringify(borrowHistory));

            // Redirect ke halaman history
            window.location.href = 'confirmation';
        });


        // Memanggil fungsi untuk set profile user
        setUserProfile();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
