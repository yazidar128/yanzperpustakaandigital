<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "yazidperpustakaan";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Proses Tambah Data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tambah'])) {
    $judul = mysqli_real_escape_string($conn, $_aPOST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);

    $sql = "INSERT INTO tblbuku (judul, penulis, penerbit, tahun) VALUES ('$judul', '$penulis', '$penerbit', '$tahun')";
    if (mysqli_query($conn, $sql)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Proses Hapus Data
if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($conn, $_GET['hapus']);
    $sql = "DELETE FROM tblbuku WHERE bukuid = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil Data Buku
$sql = "SELECT * FROM tblbuku";
$result = mysqli_query($conn, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(to right, #e3f2fd, #ffffff);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      transition: background-color 0.3s ease-in-out;
    }

    h2 {
      font-weight: 700;
      margin-bottom: 30px;
    }

    .btn i {
      margin-right: 5px;
    }

    .btn {
      transition: all 0.3s ease-in-out;
    }

    .btn:hover {
      transform: scale(1.03);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    tbody tr {
      transition: 0.3s ease-in-out;
      opacity: 0;
      transform: translateY(10px);
      animation: fadeInRow 0.5s forwards;
    }

    tbody tr:hover {
      background-color: #f8f9fa;
      cursor: pointer;
    }

    @keyframes fadeInRow {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .badge-tahun {
      background-color: #6c757d;
      color: white;
      font-size: 0.85rem;
      padding: 5px 10px;
      border-radius: 20px;
    }

    footer {
      background-color: #f8f9fa;
    }

    #searchInput {
      max-width: 400px;
    }

    .dark-mode body {
      background: #121212;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="text-center">📚 Data Buku</h2>
      <!-- Toggle Dark Mode -->
      <button id="toggleThemeBtn" class="btn btn-dark">
        <i class="fas fa-moon"></i> Mode Gelap
      </button>
    </div>

    <!-- Tombol Navigasi -->
    <div class="d-flex flex-wrap gap-2 mb-3 justify-content-between">
      <div class="d-flex gap-2">
        <a href="login.php" class="btn btn-outline-primary">
          <i class="fas fa-sign-in-alt"></i>Kembali ke Login
        </a>
        <a href="../index.php" class="btn btn-outline-secondary">
          <i class="fas fa-home"></i>Dashboard
        </a>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
          <i class="fas fa-plus-circle"></i>Tambah Buku
        </button>
      </div>
      <!-- Live Search -->
      <input type="text" id="searchInput" class="form-control" placeholder="🔍 Cari judul / penulis / penerbit..." />
    </div>

    <!-- Filter Tahun -->
    <div class="mb-3">
      <label for="filterTahun" class="form-label">Filter Tahun Terbit</label>
      <select id="filterTahun" class="form-select" aria-label="Filter Tahun Terbit">
        <option value="">Pilih Tahun</option>
        <?php 
          $years = array_column($books, 'tahun');
          $years = array_unique($years);
          sort($years);
          foreach ($years as $year):
        ?>
          <option value="<?= $year; ?>"><?= $year; ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Tabel -->
    <div class="table-responsive">
      <table class="table table-bordered shadow-sm" id="bukuTable">
        <thead class="table-dark">
          <tr>
            <th id="idBuku" style="cursor: pointer;">ID Buku <i class="fas fa-sort"></i></th>
            <th id="judul" style="cursor: pointer;">Judul <i class="fas fa-sort"></i></th>
            <th id="penulis" style="cursor: pointer;">Penulis <i class="fas fa-sort"></i></th>
            <th id="penerbit" style="cursor: pointer;">Penerbit <i class="fas fa-sort"></i></th>
            <th id="tahun" style="cursor: pointer;">Tahun Terbit <i class="fas fa-sort"></i></th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($books as $book): ?>
          <tr>
            <td><?= $book['bukuid']; ?></td>
            <td><?= $book['judul']; ?></td>
            <td><?= $book['penulis']; ?></td>
            <td><?= $book['penerbit']; ?></td>
            <td><span class="badge-tahun"><?= $book['tahun']; ?></span></td>
            <td>
              <a href="edit_buku.php?bukuid=<?= $book['bukuid']; ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>Edit
              </a>
              <a href="?hapus=<?= $book['bukuid']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                <i class="fas fa-trash-alt"></i>Hapus
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Tambah Buku -->
  <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="tambahModalLabel">
              <i class="fas fa-book-medical"></i> Tambah Buku Baru
            </h5>
            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="judul" class="form-label">Judul</label>
              <input type="text" class="form-control" id="judul" name="judul" required />
            </div>
            <div class="mb-3">
              <label for="penulis" class="form-label">Penulis</label>
              <input type="text" class="form-control" id="penulis" name="penulis" required />
            </div>
            <div class="mb-3">
              <label for="penerbit" class="form-label">Penerbit</label>
              <input type="text" class="form-control" id="penerbit" name="penerbit" required />
            </div>
            <div class="mb-3">
              <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
              <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="fas fa-times"></i> Batal
            </button>
            <button type="submit" name="tambah" class="btn btn-primary">
              <i class="fas fa-save"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center mt-5 py-3 bg-light">
    <p class="mb-0">Project by <strong>Yazid</strong> | PPLG @2 &copy; 2025</p>
  </footer>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script>
    // Live Search
    document.getElementById("searchInput").addEventListener("keyup", function () {
      let keyword = this.value.toLowerCase();
      let rows = document.querySelectorAll("#bukuTable tbody tr");

      rows.forEach((row) => {
        const rowText = row.innerText.toLowerCase();
        row.style.display = rowText.includes(keyword) ? "" : "none";
      });
    });

    // Dark Mode Toggle
    const toggleBtn = document.getElementById("toggleThemeBtn");
    const htmlEl = document.documentElement;

    if (localStorage.getItem("theme") === "dark") {
      htmlEl.setAttribute("data-bs-theme", "dark");
      toggleBtn.innerHTML = '<i class="fas fa-sun"></i> Mode Terang';
      toggleBtn.classList.remove('btn-dark');
      toggleBtn.classList.add('btn-light');
    }

    toggleBtn.addEventListener("click", function () {
      const isDark = htmlEl.getAttribute("data-bs-theme") === "dark";
      htmlEl.setAttribute("data-bs-theme", isDark ? "light" : "dark");
      localStorage.setItem("theme", isDark ? "light" : "dark");
      this.innerHTML = isDark ? '<i class="fas fa-moon"></i> Mode Gelap' : '<i class="fas fa-sun"></i> Mode Terang';
      this.classList.toggle("btn-dark");
      this.classList.toggle("btn-light");
    });

    // Sort Columns
    document.querySelectorAll("th").forEach((header) => {
      header.addEventListener("click", () => {
        const index = Array.from(header.parentNode.children).indexOf(header);
        const rows = Array.from(document.querySelectorAll("#bukuTable tbody tr"));
        const isAsc = header.classList.contains("asc");

        rows.sort((rowA, rowB) => {
          const cellA = rowA.children[index].innerText.trim();
          const cellB = rowB.children[index].innerText.trim();

          if (isNaN(cellA) || isNaN(cellB)) {
            return (cellA > cellB) === isAsc ? -1 : 1;
          }

          return (parseInt(cellA) > parseInt(cellB)) === isAsc ? -1 : 1;
        });

        rows.forEach((row) => document.querySelector("#bukuTable tbody").appendChild(row));
        header.classList.toggle("asc", !isAsc);
        header.classList.toggle("desc", isAsc);
      });
    });

    // Filter Year
    document.getElementById("filterTahun").addEventListener("change", function() {
      const yearFilter = this.value;
      const rows = document.querySelectorAll("#bukuTable tbody tr");

      rows.forEach((row) => {
        const yearCell = row.querySelector("td:nth-child(5)").innerText.trim();
        row.style.display = yearFilter && yearCell !== yearFilter ? "none" : "";
      });
    });
  </script>
</body>
</html>
