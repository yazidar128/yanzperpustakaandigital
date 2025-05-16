<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: view/login.php");
    exit();
}

// Koneksi database (tambahkan ini)
$servername = "localhost";
$dbusername = "root"; // sesuaikan dengan user database kamu
$dbpassword = "";     // sesuaikan dengan password database kamu
$dbname = "yazidperpustakaan"; // sesuaikan dengan nama database

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data user
$username = $_SESSION['username'];
$initials = strtoupper(substr($username, 0, 1));

// Hitung total buku
$result = $conn->query("SELECT COUNT(*) as total FROM tblbuku");
$jumlah_buku = $result->fetch_assoc()['total'] ?? 0;

// Hitung total peminjam (misal di tabel peminjaman ada kolom id_peminjam)
$result = $conn->query("SELECT COUNT(DISTINCT id_peminjam) as total FROM peminjaman");
$jumlah_peminjam = $result->fetch_assoc()['total'] ?? 0;

// Hitung buku yang sedang dipinjam (status = 'dipinjam')
$result = $conn->query("SELECT COUNT(*) as total FROM peminjaman WHERE status = 'dipinjam'");
$jumlah_dipinjam = $result->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Yazid</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5//bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;font700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f7f9fc;
      transition: background-color 0.3s;
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }
    .card {
      border-radius: 24px;
      background: white;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      animation: fadeIn 1s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    h2 {
      font-weight: 700;
      color: #3f51b5;
    }
    .welcome {
      font-weight: 500;
      color: #5f6368;
    }
    .btn-modern {
      padding: 12px 16px;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease-in-out;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .btn-modern-success {
      background-color: #4caf50;
      color: white;
    }
    .btn-modern-success:hover {
      background-color: #43a047;
    }
    .btn-modern-danger {
      background-color: #e53935;
      color: white;
    }
    .btn-modern-danger:hover {
      background-color: #d32f2f;
    }
    .btn-icon {
      font-size: 1.1rem;
    }
    .time {
      font-size: 0.9rem;
      color: #888;
    }
    .avatar {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background-color: #3f51b5;
      color: white;
      font-size: 28px;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      height: 100%;
      background-color: #2a2a40;
      color: white;
      padding-top: 20px;
      transition: all 0.3s;
      z-index: 1000;
    }
    .sidebar .nav-link {
      color: #ddd;
      font-weight: 500;
    }
    .sidebar .nav-link:hover {
      color: #fff;
      background-color: #4caf50;
    }
    .sidebar .nav-link i {
      margin-right: 10px;
    }
    .sidebar.collapsed {
      width: 60px;
    }
    .sidebar.collapsed .nav-link {
      text-align: center;
      padding: 10px 0;
    }
    .sidebar.collapsed .nav-link span {
      display: none;
    }
    .toggle-btn {
      position: absolute;
      top: 10px;
      right: -25px;
      background-color: #4caf50;
      color: white;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      padding: 20px;
      width: 100%;
      transition: margin-left 0.3s;
    }
    .main-content.collapsed {
      margin-left: 60px;
    }

    /* Dark Mode */
    .dark-mode {
      background-color: #1e1e2f !important;
      color: #eee;
    }
    .dark-mode .card {
      background-color: #2a2a40;
      color: #eee;
    }
    .dark-mode h2 {
      color: #f3f4f6;
    }
    .dark-mode .welcome,
    .dark-mode .time {
      color: #ccc;
    }
    .dark-mode .btn-modern-success {
      background-color: #66bb6a;
    }
    .dark-mode .btn-modern-danger {
      background-color: #ef5350;
    }
    .card {
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

  </style>
</head>
<body id="mainBody">
  <div class="sidebar" id="sidebar">
    <div class="toggle-btn" id="toggleSidebar">
      <i class="bi bi-list"></i>
    </div>
    <div class="text-center">
      <div class="avatar"><?php echo $initials; ?></div>
      <h4 id="usernameText"><?php echo $username; ?></h4>
    </div>
    <ul class="nav flex-column mt-4">
      <li class="nav-item">
        <a class="nav-link active" href="view/buku.php">
          <i class="bi bi-book-half"></i> <span>Data Buku</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view/logout.php">
          <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="toggleDark">
          <i class="bi bi-moon-stars"></i> <span>Toggle Dark Mode</span>
        </a>
      </li>
    </ul>
  </div>

  <div class="main-content" id="mainContent">
    <div class="card p-5 text-center">
      <h2 id="greeting">👋 Selamat Datang</h2>
      <p class="welcome">Halo, <strong><?php echo htmlspecialchars($username); ?></strong>!</p>
      <p class="time" id="clock">⏰ </p>
      <p id="date">📅 </p>


      <div class="d-grid gap-3 mt-4">
        <a href="view/buku.php" class="btn btn-modern btn-modern-success">
          <i class="bi bi-book-half btn-icon"></i> Lihat Data Buku
        </a>
        <a href="view/logout.php" class="btn btn-modern btn-modern-danger">
          <i class="bi bi-box-arrow-right btn-icon"></i> Logout
        </a>
      </div>
  </div>
  <div class="row mt-4 text-center">
  <div class="col-md-4 mb-3">
    <div class="card bg-primary text-white p-3">
      <h5>📚 Total Buku</h5>
      <p class="fs-3"><?= $jumlah_buku ?></p>
    </div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card bg-success text-white p-3">
      <h5>👥 Total Peminjam</h5>
      <p class="fs-3"><?= $jumlah_peminjam ?></p>
    </div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card bg-warning text-dark p-3">
      <h5>📖 Buku Sedang Dipinjam</h5>
      <p class="fs-3"><?= $jumlah_dipinjam ?></p>
    </div>
  </div>
</div>

</div>
    </div>
  </div>

  <script>
    // Greeting berdasarkan waktu
    const greeting = document.getElementById("greeting");
    const hour = new Date().getHours();
    if (hour >= 5 && hour < 12) {
      greeting.innerText = "🌅 Selamat Pagi";
    } else if (hour >= 12 && hour < 17) {
      greeting.innerText = "☀️ Selamat Siang";
    } else if (hour >= 17 && hour < 20) {
      greeting.innerText = "🌇 Selamat Sore";
    } else {
      greeting.innerText = "🌙 Selamat Malam";
    }

    // Jam realtime
    function updateClock() {
      const now = new Date();
      const time = now.toLocaleTimeString("id-ID", {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
      document.getElementById("clock").innerText = "⏰ " + time;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Dark mode toggle
    const body = document.getElementById("mainBody");
    const toggleBtn = document.getElementById("toggleDark");

    function setDarkMode(enabled) {
      if (enabled) {
        body.classList.add("dark-mode");
        localStorage.setItem("theme", "dark");
        toggleBtn.innerHTML = `<i class="bi bi-sun-fill"></i> <span>Toggle Light Mode</span>`;
      } else {
        body.classList.remove("dark-mode");
        localStorage.setItem("theme", "light");
        toggleBtn.innerHTML = `<i class="bi bi-moon-stars"></i> <span>Toggle Dark Mode</span>`;
      }
    }

    toggleBtn.addEventListener("click", () => {
      const isDark = body.classList.contains("dark-mode");
      setDarkMode(!isDark);
    });

    // Load theme from localStorage
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
      setDarkMode(true);
    }

    // Sidebar toggle
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");
    const toggleSidebarBtn = document.getElementById("toggleSidebar");

    toggleSidebarBtn.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed");
      mainContent.classList.toggle("collapsed");
    });

    // Notifikasi toastr (hapus kalau tidak diperlukan)
    toastr.success('Data berhasil disimpan!', 'Sukses');
    toastr.error('Terjadi kesalahan, coba lagi!', 'Error');
    
    
  </script>
</body>
</html>
