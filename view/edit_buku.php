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

// Ambil data buku berdasarkan ID
if (isset($_GET['bukuid'])) {
    $id = mysqli_real_escape_string($conn, $_GET['bukuid']);
    $sql = "SELECT * FROM tblbuku WHERE bukuid = '$id'";
    $result = mysqli_query($conn, $sql);
    $book = mysqli_fetch_assoc($result);
}

// Proses Update Data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $id = mysqli_real_escape_string($conn, $_POST['bukuid']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);

    $sql = "UPDATE tblbuku SET judul='$judul', penulis='$penulis', penerbit='$penerbit', tahun='$tahun' WHERE bukuid='$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: buku.php"); // Redirect ke halaman utama setelah update
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<?php
// Contoh dummy data jika belum ada dari database
// $book = ['bukuid' => 1, 'judul' => 'Buku Hebat', 'penulis' => 'Penulis Top', 'penerbit' => 'Penerbit A', 'tahun' => 2023];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background: #f3f4f6;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .form-label {
      font-weight: 600;
    }
    .btn-custom {
      padding: 10px 20px;
      font-weight: 600;
      border-radius: 12px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .btn-primary {
      background-color: #4f46e5;
      border: none;
    }
    .btn-primary:hover {
      background-color: #4338ca;
    }
    .btn-secondary {
      background-color: #9ca3af;
      border: none;
    }
    .btn-secondary:hover {
      background-color: #6b7280;
    }
    .form-control:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }
    .preview-box {
      background-color: #e0e7ff;
      border-left: 4px solid #4f46e5;
      padding: 1rem;
      border-radius: 10px;
      margin-bottom: 1.5rem;
    }
    .preview-box h6 {
      margin-bottom: 0.5rem;
      color: #3730a3;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card p-4">
        <h3 class="text-center mb-4">✏️ Edit Data Buku</h3>

        <div class="preview-box">
          <h6>Preview Judul:</h6>
          <p id="judulPreview"><?php echo htmlspecialchars($book['judul']); ?></p>
        </div>

        <form method="POST" action="">
          <input type="hidden" name="bukuid" value="<?php echo htmlspecialchars($book['bukuid']); ?>">

          <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($book['judul']); ?>" required>
          </div>

          <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo htmlspecialchars($book['penulis']); ?>" required>
          </div>

          <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo htmlspecialchars($book['penerbit']); ?>" required>
          </div>

          <div class="mb-3">
  <label for="tahun_terbit" class="form-label">Tanggal Terbit</label>
  <input type="date" class="form-control" id="tahun_terbit" name="tahun_terbit" 
    value="<?php echo htmlspecialchars($book['tahun']); ?>" 
    required max="<?php echo date('Y-m-d'); ?>">
</div>

          <div class="d-flex justify-content-between">
            <a href="buku.php" class="btn btn-secondary btn-custom">
              <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit" name="update" class="btn btn-primary btn-custom">
              <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const judulInput = document.getElementById("judul");
  const judulPreview = document.getElementById("judulPreview");

  judulInput.addEventListener("input", () => {
    judulPreview.textContent = judulInput.value || "Preview Judul Buku";
  });
</script>

</body>
</html>
