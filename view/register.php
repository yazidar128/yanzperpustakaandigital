<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yazidperpustakaan";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $email = $_POST['email'];
    $namalengkap = $_POST['namalengkap'];
    $address = $_POST['address'];

    // SQL untuk memasukkan data
    $sql = "INSERT INTO tbluser (username, password, email, namalengkap, alamat) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $password, $email, $namalengkap, $address);

    // Eksekusi query
    if ($stmt->execute()) {
        echo '<div class="alert alert-success text-center" role="alert">Registrasi berhasil!</div>';
    } else {
        echo '<div class="alert alert-danger text-center" role="alert">Error: ' . $stmt->error . '</div>';
    }

    if ($stmt->execute()) {
        header("Location: login.php?success=1");
        exit();
    }
    

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registrasi Akun</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-200 min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-2xl overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
    
    <!-- Left Section -->
    <div class="hidden md:flex md:w-1/2 bg-blue-600 text-white items-center justify-center p-10">
      <div>
        <h2 class="text-3xl font-bold mb-4">Selamat Datang!</h2>
        <p class="text-sm">Isi data registrasi di samping untuk membuat akun baru. Sudah punya akun?</p>
        <a href="login.php" class="mt-4 inline-block px-6 py-2 bg-white text-blue-600 rounded-full hover:bg-gray-100 font-semibold transition">Login di sini</a>
      </div>
    </div>

    <!-- Right Section: Form -->
    <div class="w-full md:w-1/2 p-8">
      <h3 class="text-2xl font-semibold text-blue-700 text-center mb-6">Registrasi</h3>

      <?php if (isset($_GET['success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-sm text-center">
          Registrasi berhasil! Silakan login.
        </div>
      <?php endif; ?>

      <form action="" method="POST" class="space-y-4">
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
          <input type="text" id="username" name="username" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" id="password" name="password" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div>
          <label for="namalengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input type="text" id="namalengkap" name="namalengkap" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"/>
        </div>

        <div>
          <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
          <textarea id="address" name="address" rows="3" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none"></textarea>
        </div>

        <button type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
          Daftar Sekarang
        </button>
      </form>

      <p class="text-center text-sm text-gray-400 mt-6">
        &copy; 2023 CV. YAZID ABADI. All rights reserved.
      </p>
    </div>
  </div>
</body>
</html>


