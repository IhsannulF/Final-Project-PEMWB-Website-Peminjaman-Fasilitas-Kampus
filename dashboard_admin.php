<?php
session_start();

// PROTEKSI HALAMAN: Hanya Admin yang boleh masuk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Akses ditolak! Anda bukan Admin.";
    header("Location: login.php");
    exit();
}

require_once 'config/koneksi.php';

// Mengambil nama admin dari session
$nama_admin = $_SESSION['nama_lengkap'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SI-PINJAM UPNVJ</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>SI-PINJAM</h3>
            <p>Panel Administrator</p>
        </div>

        <ul class="list-unstyled components">
                <li class="active">
                    <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="index.php" target="_blank"><i class="fas fa-external-link-alt"></i> Lihat Situs</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-building"></i> Kelola Fasilitas</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-clipboard-list"></i> Antrean Pinjaman</a>
                </li>
                
                <li>
                    <a href="#"><i class="fas fa-users"></i> Data Pengguna</a>
                </li>
            </ul>

        <ul class="list-unstyled CTAs">
            <li>
                <a href="proses/logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Keluar</a>
            </li>
        </ul>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <h4 class="text-white">Selamat Datang, <?php echo $nama_admin; ?>!</h4>
                <div class="date-now text-slate"><?php echo date('l, d F Y'); ?></div>
            </div>
        </nav>

        <div class="dashboard-cards row mt-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box blue"><i class="fas fa-clock"></i></div>
                    <div class="stat-info">
                        <h5>Pending</h5>
                        <h2>12</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box green"><i class="fas fa-check-double"></i></div>
                    <div class="stat-info">
                        <h5>Disetujui</h5>
                        <h2>45</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box slate"><i class="fas fa-door-open"></i></div>
                    <div class="stat-info">
                        <h5>Total Ruangan</h5>
                        <h2>18</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-table mt-5">
            <h5 class="mb-4">Pengajuan Peminjaman Terbaru</h5>
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Peminjam</th>
                            <th>Fasilitas</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>M. Ihsanul Fikri</td>
                            <td>Gedung GSG</td>
                            <td>12 Apr 2026</td>
                            <td><span class="badge-pending">Pending</span></td>
                            <td>
                                <button class="btn-action green"><i class="fas fa-check"></i></button>
                                <button class="btn-action red"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>