<?php
require 'db_connection.php';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_departemen = isset($_POST['nama_departemen']) ? $conn->real_escape_string($_POST['nama_departemen']) : null;

    if (!$nama_departemen) {
        die("ERROR: Nama departemen tidak boleh kosong!");
    }

    $sql = "INSERT INTO departemen (nama_departemen) VALUES ('$nama_departemen')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Departemen berhasil ditambahkan!'); window.location.href='departemen.php';</script>";
    } else {
        echo "ERROR: " . $conn->error;
    }
}

$conn->close();
?>
