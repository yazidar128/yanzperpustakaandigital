<?php
require 'panggil.php';

// proses tambah
if (!empty($_GET['aksi'] == 'daftar')) {
    $tabel = 'tbluser';

    # proses insert
    $data = array(
        'username'   => $_POST['username'],
        'password'   => md5($_POST['password']),
        'email'      => $_POST['email'],
        'namalengkap' => $_POST['nama'],
        'alamat'     => $_POST['alamat'],
    );

    $proses->daftar($tabel, $data);
    echo '<script>alert("Tambah Data Berhasil");window.location="../view/login.php"</script>';
}

// Login
if (!empty($_GET['aksi']) && $_GET['aksi'] == 'login') {
    // Validasi input dengan filter_input untuk mencegah karakter khusus
    $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Panggil fungsi proses_login() dari class prosesCrud
    $hasil = $proses->proses_login($user, $pass);

    if ($hasil == 'gagal') {
        // Redirect jika login gagal
        echo '<script>alert("Login Gagal");window.location="../view/login.php?get=gagal";</script>';
    } else {
        // Jika login berhasil
        session_start(); // Pastikan session_start() dipanggil sebelum output
        $_SESSION['login'] = $hasil;

        // Redirect ke index.php
        header("Location:../index.php");
        exit(); // Pastikan untuk keluar setelah redirect
    }
}

// hapus data
if (!empty($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $tabel = 'tblbuku';
    $where = 'bukuid';
    $id = strip_tags($_GET['hapusid']);
    $proses->hapus_buku($tabel, $where, $id);
    echo '<script>alert("Hapus Data Berhasil"); window.location="../view/tampilbuku.php";</script>';
}


?>
