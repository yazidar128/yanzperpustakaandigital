CREATE TABLE tbluser (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    namalengkap VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL
);

CREATE TABLE tblbuku (
    id INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(100) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahunterbit YEAR NOT NULL
);
