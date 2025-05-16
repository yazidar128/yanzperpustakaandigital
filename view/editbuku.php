
<?php
session_start();
$sesi = $_SESSION['ADMIN'];
if (!isset($_SESSION['ADMIN'])) {
    header('location:buku.php');
    exit();
}
require('../controller/panggil.php');

// Ambil ID Buku
$idGet = isset($_GET['id']) ? strip_tags($_GET['id']) : '';
$hasil = $proses->tampil_data_buku_id('tblbuku', 'bukuid', $idGet);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css"> <!-- Sesuaikan dengan path CSS Bootstrap Anda -->
</head>
<body class="bg-gradient-login">
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Edit Data Buku</h1>
                                    </div>
                                    <form action="../controller/crud.php?aksi=editbuku" method="POST">
                                        <input type="hidden" class="form-control" id="iduser" name="iduser" value="<?php echo htmlspecialchars($sesi['userid']); ?>" required>
                                        
                                        <div class="form-group">
                                            <label>ID Buku</label>
                                            <input type="text" class="form-control" id="idbuku" name="idbuku" value="<?php echo htmlspecialchars($hasil['bukuid']); ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Judul Buku</label>
                                            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($hasil['judul']); ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Penulis</label>
                                            <input type="text" class="form-control" id="penulis" name="penulis" placeholder="Masukan Penulis" value="<?php echo htmlspecialchars($hasil['penulis']); ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Penerbit</label>
                                            <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Masukan Penerbit" value="<?php echo htmlspecialchars($hasil['penerbit']); ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Tahun Terbit</label>
                                            <input type="text" class="form-control" id="tahun" name="tahun" placeholder="Masukan Tahun Terbit" value="<?php echo htmlspecialchars($hasil['tahunterbit']); ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block" name="simpan">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>copyright &copy; 2024 - developed by <b><a href="#" target="_blank">be</a></b></span>
            </div>
        </div>
    </footer>
    
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include("../template/footer.php"); ?>
</body>
</html>
