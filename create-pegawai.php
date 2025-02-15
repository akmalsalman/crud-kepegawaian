<?php
require 'db_connection.php'; 


$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = isset($_POST['nama']) ? $conn->real_escape_string($_POST['nama']) : null;
    $jabatan = isset($_POST['jabatan']) ? $conn->real_escape_string($_POST['jabatan']) : null;
    $gaji = isset($_POST['gaji']) ? $conn->real_escape_string($_POST['gaji']) : null;
    $alamat = isset($_POST['alamat']) ? $conn->real_escape_string($_POST['alamat']) : null;
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : null;
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $conn->real_escape_string($_POST['jenis_kelamin']) : null;

    if (!$nama || !$jabatan || !$gaji || !$alamat || !$email || !$jenis_kelamin) {
        die("ERROR: Data tidak lengkap. Silakan periksa kembali input form.");
    }

    $sql = "INSERT INTO pegawai (nama, jabatan, gaji, alamat, email, jenis_kelamin) 
            VALUES ('$nama', '$jabatan', '$gaji', '$alamat', '$email', '$jenis_kelamin')";

    echo "DEBUG: Query yang akan dijalankan: <br> $sql <br><br>";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data pegawai berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "ERROR: " . $conn->error;
    }
}

$conn->close();
?>
