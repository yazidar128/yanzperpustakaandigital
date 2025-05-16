<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Akun</title>
  <link rel="icon" type="image/png" href="favicon.png">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-200 min-h-screen flex items-center justify-center">

  <div class="bg-white shadow-lg rounded-2xl overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
    
    <!-- Left Section -->
    <div class="hidden md:flex md:w-1/2 bg-blue-600 text-white items-center justify-center p-10">
      <div>
        <h2 class="text-3xl font-bold mb-4">Selamat Datang Kembali!</h2>
        <p class="text-sm">Masukkan username dan password untuk masuk. Belum punya akun?</p>
        <a href="register.php" class="mt-4 inline-block px-6 py-2 bg-white text-blue-600 rounded-full hover:bg-gray-100 font-semibold transition">Daftar di sini</a>
      </div>
    </div>

    <!-- Right Section: Form -->
    <div class="w-full md:w-1/2 p-8">
      <h3 class="text-2xl font-semibold text-blue-700 text-center mb-6">Login</h3>

      <!-- Alert Messages -->
      <?php if (isset($_GET['success'])): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
          Registrasi berhasil! Silakan login.
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['error'])): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
          <?= htmlspecialchars($_GET['error']); ?>
        </div>
      <?php endif; ?>

      <!-- Login Form -->
      <form action="process_login.php" method="POST" autocomplete="off">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Username:</label>
          <input type="text" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Password:</label>
          <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
          <label class="inline-flex items-center mt-2">
            <input type="checkbox" onclick="togglePassword()" class="mr-2">
            <span class="text-sm text-gray-600">Tampilkan Password</span>
          </label>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">Login</button>
      </form>

      <div class="text-center mt-4">
        <a href="forgot_password.php" class="text-sm text-blue-600 hover:underline">Lupa Password?</a><br>
        <a href="register.php" class="text-sm text-blue-600 hover:underline">Buat Akun</a>
      </div>
       <!-- Footer -->
  <footer class="text-center text-gray-500 text-sm mt-6 mb-4">
    &copy; <?= date("Y") ?> Sistem Login. Semua hak dilindungi.
  </footer>
    </div>
  </div>

 
  <!-- Script: Toggle Password -->
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    }
  </script>
</body>
</html>
