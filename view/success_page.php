<?php
if (isset($_GET['aksi']) && $_GET['aksi'] == 'editbuku') {
    // Ambil data dari form
    $idbuku = $_POST['idbuku'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];

    // Prepared statement
    $stmt = $conn->prepare("UPDATE tblbuku SET judul=?, penulis=?, penerbit=?, tahunterbit=? WHERE bukuid=?");
    $stmt->bind_param("ssssi", $judul, $penulis, $penerbit, $tahun, $idbuku);

    if ($stmt->execute()) {
        echo "Data buku berhasil diperbarui";
        header("Location: success_page.php"); // Ganti dengan halaman yang sesuai
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>