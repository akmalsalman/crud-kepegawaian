<?php
require 'db_connection.php';
session_start();

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM departemen";
$result = $conn->query($sql);

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_departemen = $_POST['nama_departemen'];

    if (!empty($id) && !empty($nama_departemen)) {
        $sql_update = "UPDATE departemen SET nama_departemen=? WHERE id=?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("si", $nama_departemen, $id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Departemen berhasil diperbarui!'); window.location.href='departemen.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data!');</script>";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Departemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Sistem Kepegawaian</h4>
        <a href="index.php"><i class="fas fa-users"></i> Data Pegawai</a>
        <a href="departemen.php"><i class="fas fa-building"></i> Data Departemen</a>
    </div>

     <!-- Navbar -->
     <nav class="navbar">
        <span class="navbar-brand"><strong>DATA PEGAWAI</strong></span>
        <div class="d-flex align-items-center">
            <i class="fas fa-user-shield me-2"></i> <!-- Ikon Admin -->
            <span><strong>Hi, Welcome <?= htmlspecialchars($_SESSION['user'] ?? 'Admin'); ?></strong></span>
            <a href="logout.php" class="btn btn-danger ms-3">Logout</a>
        </div>    
    </nav>
    
    <!-- Main Content -->
    <div class="content">
    <h2 class="text-center"><strong>DATA DEPARTEMEN</strong></h2>
    <button class="btn btn-primary mb-3" style="padding: 10px 24px; min-width: 200px; height: 50px; font-size: 18px;" 
    data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Departemen</button>

    <div class="table-responsive"> 
        <table class="table table-striped table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 60%;">Nama Departemen</th>
                    <th style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nama_departemen'] ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="showUpdateForm(<?= $row['id'] ?>, '<?= $row['nama_departemen'] ?>')">Edit</button>
                        <a href="delete-departemen.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Departemen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="create-departemen.php">
                                <div class="mb-3">
                                    <label class="form-label">Nama Departemen</label>
                                    <input type="text" name="nama_departemen" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--Update Departemen -->
            <div id="updateForm" class="card p-3 mt-3" style="display: none;">
                <h4>Update Departemen</h4>
                <form method="POST" action="departemen.php">
                    <input type="hidden" id="updateId" name="id">
                    <div class="mb-3">
                        <label for="nama_departemen" class="form-label">Nama Departemen</label>
                        <input type="text" class="form-control" id="updateNama" name="nama_departemen" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="update">Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary" onclick="hideUpdateForm()">Batal</button>
                </form>
            </div>

            <script>
                function showUpdateForm(id, nama) {
                document.getElementById("updateForm").style.display = "block";
                document.getElementById("updateId").value = id;
                document.getElementById("updateNama").value = nama;
            }

            function hideUpdateForm() {
                document.getElementById("updateForm").style.display = "none";
            }
            </script>   
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
