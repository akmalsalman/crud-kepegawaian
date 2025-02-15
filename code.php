<?php
session_start();
require 'db_connection.php';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses Update Data Pegawai
if (isset($_POST['update_pegawai'])) {
    $pegawai_id = $_POST['pegawai_id'];
    $nama = $conn->real_escape_string($_POST['nama']);
    $jabatan = $conn->real_escape_string($_POST['jabatan']);
    $gaji = $conn->real_escape_string($_POST['gaji']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $email = $conn->real_escape_string($_POST['email']);
    $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);

    $query = "UPDATE pegawai SET nama='$nama', jabatan='$jabatan', gaji='$gaji', alamat='$alamat', email='$email', jenis_kelamin='$jenis_kelamin' WHERE id='$pegawai_id'";
    
    if ($conn->query($query) === TRUE) {
        $_SESSION['message'] = "Data pegawai berhasil diperbarui";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal memperbarui data pegawai: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    
    header("Location: index.php");
    exit(0);
}

// Proses Tambah Data Pegawai
if (isset($_POST['tambah_pegawai'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $jabatan = $conn->real_escape_string($_POST['jabatan']);
    $gaji = $conn->real_escape_string($_POST['gaji']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $email = $conn->real_escape_string($_POST['email']);
    $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);

    $query = "INSERT INTO pegawai (nama, jabatan, gaji, alamat, email, jenis_kelamin) VALUES ('$nama', '$jabatan', '$gaji', '$alamat', '$email', '$jenis_kelamin')";
    
    if ($conn->query($query) === TRUE) {
        $_SESSION['message'] = "Pegawai berhasil ditambahkan";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal menambahkan pegawai: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    
    header("Location: index.php");
    exit(0);
}

?>
