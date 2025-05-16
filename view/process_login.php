<?php
session_start();
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!$conn) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Cek apakah username ada di database
    $stmt = $conn->prepare("SELECT userid, password FROM tbluser WHERE username = ?");
    if (!$stmt) {
        die("Query error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();


        // Cek apakah password cocok
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;

            // Redirect ke index.php di luar folder view
            header("Location: ../index.php");
            exit();

        } else {
            header("Location: login.php?error=Password salah!");
            exit();
        }
    } else {
        header("Location: login.php?error=Username tidak ditemukan!");
        exit();
    }
}
?>
