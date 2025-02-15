<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'akmal salman a_if11_kepegawaian';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

$sql_pegawai = "CREATE TABLE IF NOT EXISTS pegawai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50) NOT NULL,
    gaji DECIMAL(10,2) NOT NULL,
    alamat TEXT NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    jenis_kelamin ENUM('L','P') NOT NULL
)";

$sql_departemen = "CREATE TABLE IF NOT EXISTS departemen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_departemen VARCHAR(100) NOT NULL UNIQUE
)";

$sql_relasi = "CREATE TABLE IF NOT EXISTS pegawai_departemen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pegawai_id INT NOT NULL,
    departemen_id INT NOT NULL,
    FOREIGN KEY (pegawai_id) REFERENCES pegawai(id) ON DELETE CASCADE,
    FOREIGN KEY (departemen_id) REFERENCES departemen(id) ON DELETE CASCADE
)";

$conn->query($sql_users);
$conn->query($sql_pegawai);
$conn->query($sql_departemen);
$conn->query($sql_relasi);


?>