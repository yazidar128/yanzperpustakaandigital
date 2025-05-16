<?php
$servername = "localhost"; // Sesuaikan dengan database kamu
$username = "root"; // Username default XAMPP
$password = ""; // Password default XAMPP (kosong)
$database = "yazidperpustakaan"; // Ganti dengan nama database kamu

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
