<?php
// Koneksi ke database
$servername = "localhost"; // Ganti dengan server Anda
$username = "username"; // Ganti dengan username database Anda
$password = "password"; // Ganti dengan password database Anda
$dbname = "yazidperpustakaan";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$judul = $_POST['judul'];
$pengarang = $_POST['pengarang'];
$tahun = $_POST['tahun'];

// Query untuk menyimpan data
$sql = "INSERT INTO tblbuku (judul, pengarang, tahun) VALUES ('$judul', '$pengarang', '$tahun')";

if ($conn->query($sql) === TRUE) {
    echo "Buku berhasil ditambahkan";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
?>