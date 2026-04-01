<?php
session_start();

// Proteksi: Hanya Mahasiswa yang boleh masuk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    $_SESSION['error'] = "Silakan login sebagai Mahasiswa untuk mengakses halaman ini.";
    header("Location: login.php");
    exit();
}

require_once 'config/koneksi.php';
$nama_user = $_SESSION['nama_lengkap'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - SI-PINJAM</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style-admin.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>SI-PINJAM</h3>
            <p>Panel Mahasiswa</p>
        </div>

        <ul class="list-unstyled components">
            <li class="active">
                <a href="dashboard_mahasiswa.php"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            <li>
                <a href="index.php"><i class="fas fa-external-link-alt"></i> Lihat Fasilitas</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-calendar-plus"></i> Buat Jadwal Pinjam</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-history"></i> Riwayat Saya</a>
            </li>
        </ul>

        <ul class="list-unstyled CTAs">
            <li>
                <a href="proses/logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
            </li>
        </ul>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 20px;">
                <div>
                    <h4 class="text-white mb-1">Halo, <?php echo $nama_user; ?>!</h4>
                    <div class="text-slate" style="font-size: 14px;">Selamat datang di layanan peminjaman fasilitas.</div>
                </div>
                
                <div>
                    <a href="index.php" class="btn-back-home" style="display: inline-flex; align-items: center; gap: 8px; background-color: #1c202a; color: var(--color-white); padding: 10px 20px; border-radius: 8px; border: 1px solid #2d3240; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s;">
                        <i class="fas fa-external-link-alt" style="color: #009EF7;"></i> Ke Halaman Utama
                    </a>
                </div>
            </nav>

            <div class="row mt-4">
            <div class="col-md-12">
                <div class="stat-card" style="background: linear-gradient(135deg, #16181e 0%, #1c202a 100%); border-left: 4px solid #009EF7;">
                    <div class="stat-info">
                        <h5>Status Peminjaman Terakhir</h5>
                        <p class="text-slate">Anda belum memiliki pengajuan aktif saat ini.</p>
                        <a href="#" class="btn btn-primary btn-sm">Mulai Pinjam Fasilitas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>