<?php
require 'db_connection.php';
session_start(); 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$sql = "SELECT * FROM pegawai WHERE 1=1";
$params = [];
$types = "";

if (!empty($_GET['search'])) {
    $search = "%{$_GET['search']}%";
    $sql .= " AND (id LIKE ? OR nama LIKE ? OR jabatan LIKE ?)";
    array_push($params, $search, $search, $search);
    $types .= "sss";
}


if (!empty($_GET['jenis_kelamin'])) {
    $jenis_kelamin = $_GET['jenis_kelamin'];
    $sql .= " AND jenis_kelamin = ?";
    array_push($params, $jenis_kelamin);
    $types .= "s";
}

$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>




<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <h2 class="text-center"><strong>DATA PEGAWAI</strong></h2>
        <div class="d-flex justify-content-start mb-3">
        <button class="btn btn-primary btn-tambah mb-3" 
        style="padding: 12px 24px; min-width: 180px; height: 50px; font-size: 18px;"
        data-bs-toggle="modal" 
        data-bs-target="#modalTambah">
        Tambah Pegawai
        </button>
        </div>


        <!-- Form Pencarian & Filter -->
        <form method="GET" action="" class="mb-3">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" placeholder="Cari ID, Nama, Jabatan " value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                </div>
                <div class="col-md-4">
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="L" <?= (isset($_GET['jenis_kelamin']) && $_GET['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?= (isset($_GET['jenis_kelamin']) && $_GET['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">Cari</button>
                </div>
            </div>
        </form>
        
        <?php 
            include('message.php');
        ?>

        <div class="table-responsive">
        <table class="table table-striped table-bordered mt-3 "style="table-layout: fixed;">
            <thead class="table-dark" align="center">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Gaji</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['jabatan'] ?></td>
                    <td><?= $row['gaji'] ?></td>
                    <td class="alamat-col">
                        <span class="tooltip-text" data-tooltip="<?= htmlspecialchars($row['alamat']) ?>">
                            <?= strlen($row['alamat']) > 30 ? substr($row['alamat'], 0, 30) . '...' : $row['alamat'] ?>
                        </span>
                    </td>

                    <td><?= $row['email'] ?></td>
                    <td><?= ($row['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan' ?></td>
                    <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-info btn-sm view-btn" 
                                data-id="<?= $row['id'] ?>" 
                                data-nama="<?= $row['nama'] ?>"
                                data-jabatan="<?= $row['jabatan'] ?>"
                                data-gaji="<?= $row['gaji'] ?>"
                                data-alamat="<?= htmlspecialchars($row['alamat']) ?>"
                                data-email="<?= $row['email'] ?>"
                                data-jenis_kelamin="<?= ($row['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan' ?>"
                                data-bs-toggle="modal" 
                                data-bs-target="#modalView">
                            Lihat
                        </button>
                        <a href="update-pegawai.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete-pegawai.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </div>
                </td>


                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formTambah" method="POST" action="create-pegawai.php">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gaji</label>
                                <input type="number" name="gaji" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <div>
                                <input type="radio" name="jenis_kelamin" value="L" required>
                                <label for="jenis_kelamin">Laki-laki</label>
                            </div>
                            <div>
                                <input type="radio" name="jenis_kelamin" value="P" required>
                                <label for="jenis_kelamin">Perempuan</label>
                            </div>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="index.php" class="nav-link text-white">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tempat menampilkan detail -->
        <div id="detailPegawai" class="card p-4 mt-3 shadow-sm" style="display: none; max-width: 500px; margin: auto; border-radius: 10px; position: relative;">
            <button id="closeDetail" style="position: absolute; top: 10px; right: 10px; border: none; background: none; font-size: 20px; cursor: pointer;">&times;</button>
            <h5 class="text-center mb-3">Detail Pegawai</h5>
            <div class="border-top pt-2">
                <p><strong>Nama:</strong> <span id="view-nama"></span></p>
                <p><strong>Jabatan:</strong> <span id="view-jabatan"></span></p>
                <p><strong>Gaji:</strong> <span id="view-gaji"></span></p>
                <p><strong>Alamat:</strong> <span id="view-alamat"></span></p>
                <p><strong>Email:</strong> <span id="view-email"></span></p>
                <p><strong>Jenis Kelamin:</strong> <span id="view-jenis_kelamin"></span></p>
            </div>
        </div>

        <script>
        $(document).ready(function () {
            $(".view-btn").click(function () {
                let nama = $(this).data("nama");
                let jabatan = $(this).data("jabatan");
                let gaji = $(this).data("gaji");
                let alamat = $(this).data("alamat");
                let email = $(this).data("email");
                let jenisKelamin = $(this).data("jenis_kelamin");

                $("#view-nama").text(nama);
                $("#view-jabatan").text(jabatan);
                $("#view-gaji").text(gaji);
                $("#view-alamat").text(alamat);
                $("#view-email").text(email);
                $("#view-jenis_kelamin").text(jenisKelamin);

                $("#detailPegawai").fadeIn();
            });

            $("#closeDetail").click(function () {
                $("#detailPegawai").fadeOut();
            });
        });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</div>
</body>
</html>
