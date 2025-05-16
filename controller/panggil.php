<?php

// panggil file
include '../model/koneksi.php';
include '../model/prosescrud.php';
// include '../model/proseslogin.php';

// cara panggil class di koneksi php
$db = new Koneksi();

// cara panggil koneksi di fungsi DBConnect()
$koneksi = $db->dbkonek();

// panggil class prosesCrud di file prosescrud.php
$proses = new prosesCrud($koneksi);

// menghilangkan pesan error
error_reporting(0);

?>
