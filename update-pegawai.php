<?php
session_start();
require 'db_connection.php';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM pegawai WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Pegawai tidak ditemukan");
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $jabatan = trim($_POST['jabatan']);
    $gaji = floatval($_POST['gaji']);
    $alamat = trim($_POST['alamat']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $jenis_kelamin = ($_POST['jenis_kelamin'] === 'L' || $_POST['jenis_kelamin'] === 'P') ? $_POST['jenis_kelamin'] : 'L';

    if (empty($nama) || empty($jabatan) || empty($alamat) || empty($email) || !in_array($jenis_kelamin, ['L', 'P'])) {
        die("Semua kolom wajib diisi dengan benar.");
    }

    $sql = "UPDATE pegawai SET nama=?, jabatan=?, gaji=?, alamat=?, email=?, jenis_kelamin=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsssi", $nama, $jabatan, $gaji, $alamat, $email, $jenis_kelamin, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/update.css" rel="stylesheet">
</head>
<body>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100" >
    <div class="card p-4">
        <h2 class="text-center">Edit Pegawai</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="<?= htmlspecialchars($row['jabatan']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gaji</label>
                <input type="number" name="gaji" class="form-control" value="<?= htmlspecialchars($row['gaji']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" required><?= htmlspecialchars($row['alamat']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="jenis_kelamin" value="L" <?= ($row['jenis_kelamin'] == 'L') ? 'checked' : '' ?> required>
                        <label class="form-check-label">Laki-laki</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="jenis_kelamin" value="P" <?= ($row['jenis_kelamin'] == 'P') ? 'checked' : '' ?> required>
                        <label class="form-check-label">Perempuan</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">Batal</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>