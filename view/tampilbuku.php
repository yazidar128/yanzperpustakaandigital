<!DOCTYPE html>
<html>
<head>
    <?php
    session_start();
    $sesi = $_SESSION['ADMIN'] ?? null;

    // Jika tidak ada session, redirect ke halaman login
    if (empty($sesi)) {
        header('Location: login.php');
        exit;
    }

    echo "Data Buku";
    include '../controller/panggil.php';
    ?>
</head>
<body>
    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Nama Penulis</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $hasil = $proses->tampil_data_buku('tblbuku', $sesi['userid']);

            foreach ($hasil as $data) {
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data['judul']; ?></td>
                    <td><?php echo $data['penulis']; ?></td>
                    <td><?php echo $data['penerbit']; ?></td>
                    <td><?php echo $data['tahunterbit']; ?></td>
                    <td style="text-align: center;">
                        <a href="bukuedit.php?id=<?php echo $data['bukuid']; ?>" class="btn btn-success btn-md">Edit
                            <span class="fa fa-edit"></span>
                        </a>&nbsp;
                        <a onclick="return confirm('Apakah yakin data akan dihapus?')" 
                           href="../controller/crud.php?aksi=hapus&hapusid=<?php echo $data['bukuid']; ?>" 
                           class="btn btn-danger btn-md">Hapus
                            <span class="fa fa-trash"></span>
                        </a>
                    </td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </tbody>
    </table>
</body>
</html>
