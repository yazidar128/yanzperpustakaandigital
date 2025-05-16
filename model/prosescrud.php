<?php

class prosesCrud {
    protected $db;

    function __construct($db) {
        $this->db = $db;
    }
    
    // Hapus data buku
    public function tblbuku($tabel, $where, $id) {
        $sql = "DELETE FROM $tabel WHERE $where = ?";
        $row = $this->db->prepare($sql);
        return $row->execute([$id]);
    }

    // Tambah data buku
    public function tambah_buku($tabel, $data) {
        $judul = $data['judul'];
        $penulis = $data['penulis'];
        $deskripsi = $data['deskripsi'];
        $gambar = $data['gambar'];

        $sql = "INSERT INTO $tabel (judul, penulis, deskripsi, gambar) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$judul, $penulis, $deskripsi, $gambar]);
    }

    // Mendaftarkan user baru
    public function daftar($tabel, $data) {
        // Cek apakah username sudah ada
        if ($this->cekDuplikasiUser($data['username'])) {
            return "Username sudah terdaftar!";
        }

        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $email = $data['email'];
        $namauser = $data['namalengkap'];
        $alamat = $data['alamat'];

        $sql = "INSERT INTO $tabel (username, password, email, namalengkap, alamat) VALUES (?, ?, ?, ?, ?)";
        $save = $this->db->prepare($sql);
        return $save->execute([$username, $password, $email, $namauser, $alamat]);
    }

    // Fungsi untuk mengecek duplikasi username
    public function cekDuplikasiUser($username) {
        $sql = "SELECT COUNT(*) FROM tbluser WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();
        return $count > 0; // Jika username sudah ada, kembalikan true
    }

    // Proses login user
    public function proses_login($username, $password) {
        $row = $this->db->prepare('SELECT * FROM tbluser WHERE username = ?');
        $row->execute([$username]);
        $user = $row->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return 'gagal';
        }
    }

    // Tambah data buku
    public function daftarbuku($tabel, $data) {
        $judul = $data['judul'];
        $penulis = $data['penulis'];
        $penerbit = $data['penerbit'];
        $tahunterbit = $data['tahunterbit'];

        $sql = "INSERT INTO $tabel (judul, penulis, penerbit, tahunterbit) VALUES (?, ?, ?, ?)";
        $save = $this->db->prepare($sql);
        return $save->execute([$judul, $penulis, $penerbit, $tahunterbit]);
    }
}
