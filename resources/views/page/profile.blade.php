<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile - BookFinity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-custom {
            background-color: #1f2660;
        }

        .bg-orange {
            background-color: #f57c00;
        }

        .profile-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            position: relative;
            max-width: 480px;
            margin: auto;
        }

        .profile-img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
            border: 5px solid #f57c00;
            margin-bottom: 1rem;
            cursor: pointer;
        }

        .info-list {
            text-align: left;
            margin-top: 2rem;
        }

        .info-list p {
            margin-bottom: 0.8rem;
            font-size: 1rem;
        }

        .info-list i {
            color: #f57c00;
            width: 24px;
        }

        .logout-btn {
            background-color: #dc3545;
            border: none;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .edit-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: #f57c00;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 6px 12px;
            font-size: 14px;
            cursor: pointer;
        }

        .edit-btn:hover {
            background-color: #e06700;
        }

        .form-control[readonly] {
            background-color: #e9ecef;
            opacity: 1;
        }

        #saveBtn,
        #cancelBtn {
            display: none;
        }

        #photoInput {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 px-4">
        <a class="navbar-brand fw-bold text-white me-4" href="#" id="navbarUser">
            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/profileDefault.png') }}"
                class="rounded-circle me-2" width="40" height="40" loading="eager">
            Welcome {{ Auth::user()->name }}
        </a>
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
        <h2 class="fw-bold">Profil Pengguna</h2>
        <p>Informasi akun BookFinity Anda</p>
    </header>

    <!-- Profile Content -->
    <section class="container my-5">
        <div class="profile-card">
            <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal"><i
                    class="bi bi-pencil-square"></i> Edit</button>
            <input type="file" name="photo" accept="image/*" id="photoInput" />

            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/profileDefault.png') }}"
                alt="Foto Profil" class="profile-img" id="profileImg" title="Click to change photo">


            <h4 class="fw-bold" id="nameDisplay">{{ $user->name }}</h4>

            <form id="profileForm" class="mt-4 text-start" method="POST" action="{{ route('profile.update') }}">
                @csrf
                <div class="mb-3">
                    <label for="nameInput" class="form-label">Name</label>
                    <input type="text" id="nameInput" name="name" class="form-control"
                        value="{{ old('name', $user->name) }}" readonly required />
                </div>
                <div class="mb-3">
                    <label for="emailInput" class="form-label">Email</label>
                    <input type="email" id="emailInput" name="email" class="form-control"
                        value="{{ old('email', $user->email) }}" readonly required />
                </div>
                <div class="mb-3">
                    <label for="phoneInput" class="form-label">Phone</label>
                    <input type="text" id="phoneInput" name="phone" class="form-control"
                        value="{{ old('phone', $user->phone) }}" readonly />
                </div>

                <button type="submit" class="btn btn-primary me-2" id="saveBtn">Save</button>
                <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
            </form>


            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn logout-btn text-white mt-4 px-4">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>


        </div>
    </section>

    <!-- Modal Edit Profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Gambar Profil --}}
                        <div class="text-center mb-3">
                            <label for="photo" style="cursor: pointer;">
                                <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/default-avatar.png') }}"
                                    alt="Foto Profil" class="rounded-circle" width="100" height="100">
                            </label>
                            <input type="file" accept="image/*" id="photo" name="photo"
                                class="form-control mt-2">
                        </div>

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $user->name) }}" class="form-control" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $user->email) }}" class="form-control" required>
                        </div>

                        {{-- No. Telepon --}}
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" name="phone" id="phone"
                                value="{{ old('phone', $user->phone) }}" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- <script>
  const editBtn = document.getElementById('editBtn');
  const saveBtn = document.getElementById('saveBtn');
  const cancelBtn = document.getElementById('cancelBtn');
  const profileImg = document.getElementById('profileImg');
  const photoInput = document.getElementById('photoInput');
  const nameDisplay = document.getElementById('nameDisplay');
  const navbarUser = document.getElementById('navbarUser');
  const navbarUserImg = document.getElementById('navbarUserImg');

  const nameInput = document.getElementById('nameInput');
  const emailInput = document.getElementById('emailInput');
  const phoneInput = document.getElementById('phoneInput');

  let originalData = {};
  let currentPhotoDataURL = null;

  function setUserUI(user) {
    const avatar = user.avatar || 'img/default-avatar.png';
    const name = user.name || 'Guest';

    profileImg.src = avatar;
    nameDisplay.textContent = name;

    navbarUser.innerHTML = `
      <img src="${avatar}" class="rounded-circle me-2" width="40" height="40" alt="User photo" />
      Welcome, ${name}
    `;

    navbarUserImg.src = avatar;

    nameInput.value = user.name || '';
    emailInput.value = user.email || '';
    phoneInput.value = user.phone || '';

    originalData = user;
  }

  function clearUserUI() {
    setUserUI({}); // set ke default guest
  }

  async function loadProfile() {
    const userId = localStorage.getItem('userId');
    if (!userId) {
      alert('User belum login!');
      window.location.href = 'login.html';
      return;
    }

    const userData = JSON.parse(localStorage.getItem('userData'));
    if (userData) {
      setUserUI(userData);
      setFormEditable(false);
      return;
    }

    try {
      const res = await fetch(`http://localhost:3000/api/profile/${userId}`);
      if (!res.ok) throw new Error('Gagal memuat profil');

      const data = await res.json();
      localStorage.setItem('userData', JSON.stringify(data));
      setUserUI(data);
      setFormEditable(false);
    } catch (err) {
      console.error(err);
      alert('Gagal memuat data profil.');
    }
  }

  function setFormEditable(editable) {
    nameInput.readOnly = !editable;
    emailInput.readOnly = !editable;
    phoneInput.readOnly = !editable;

    saveBtn.style.display = editable ? 'inline-block' : 'none';
    cancelBtn.style.display = editable ? 'inline-block' : 'none';
    editBtn.style.display = editable ? 'none' : 'inline-block';
  }

  document.getElementById('logoutBtn').addEventListener('click', () => {
    localStorage.removeItem('userData');
    sessionStorage.removeItem('userId');
    window.location.href = 'login.html';
  });

  editBtn.addEventListener('click', () => {
    setFormEditable(true);
  });

  cancelBtn.addEventListener('click', () => {
    setFormEditable(false);
    setUserUI(originalData);
  });

  // Foto Profile Handling
  profileImg.addEventListener('click', () => {
    photoInput.click();
  });

  photoInput.addEventListener('change', async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onloadend = function () {
      currentPhotoDataURL = reader.result;
      profileImg.src = currentPhotoDataURL;
    };
    reader.readAsDataURL(file);
  });

  document.getElementById('profileForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    if (!nameInput.value.trim()) {
      alert("Nama tidak boleh kosong!");
      return;
    }

    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(emailInput.value.trim())) {
      alert("Email tidak valid!");
      return;
    }

    const phonePattern = /^[0-9]{10,12}$/;
    if (!phonePattern.test(phoneInput.value.trim())) {
      alert("Nomor telepon tidak valid!");
      return;
    }

    const userId = localStorage.getItem('userId');
    const formData = new FormData();

    formData.append('name', nameInput.value.trim());
    formData.append('email', emailInput.value.trim());
    formData.append('phone', phoneInput.value.trim());

    const file = photoInput.files[0];
    if (file) {
      formData.append('avatar', file);
    }

    try {
      const res = await fetch(`http://localhost:3000/api/profile/${userId}`, {
        method: 'PUT',
        body: formData
      });

      if (!res.ok) throw new Error('Gagal menyimpan perubahan');

      const result = await res.json();
      originalData = result;
      localStorage.setItem('userData', JSON.stringify(result));
      alert('Profil berhasil diperbarui');
      setFormEditable(false);
      loadProfile();
    } catch (err) {
      console.error(err);
      alert('Terjadi kesalahan saat menyimpan profil');
    }
  });

  loadProfile(); // Load user profile when page loads
</script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
