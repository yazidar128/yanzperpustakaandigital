<?php
include 'db_connect.php';

$username = "admin"; // Ganti dengan username yang ingin diperbaiki
$password_plain = "password123"; // Password baru

$hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE tbluser SET password = ? WHERE username = ?");
$stmt->bind_param("ss", $hashed_password, $username);

if ($stmt->execute()) {
    echo "Password berhasil diperbarui! Coba login dengan password: password123";
} else {
    echo "Gagal update password: " . $conn->error;
}
?>
