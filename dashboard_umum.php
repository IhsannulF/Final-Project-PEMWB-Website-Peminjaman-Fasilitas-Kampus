<?php
session_start();

// Proteksi: Hanya Pihak Eksternal (Umum) yang boleh masuk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'umum') {
    $_SESSION['error'] = "Akses ditolak! Silakan login sebagai Pihak Eksternal.";
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
    <title>Dashboard Eksternal - SI-PINJAM</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>SI-PINJAM</h3>
            <p>Pihak Eksternal</p>
        </div>

        <ul class="list-unstyled components">
            <li class="active">
                <a href="dashboard_umum.php"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            <li>
                <a href="index.php"><i class="fas fa-search"></i> Cari Fasilitas</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-file-invoice-dollar"></i> Sewa Gedung</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-history"></i> Riwayat Transaksi</a>
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
                <h4 class="text-white mb-1">Selamat Datang, <?php echo $nama_user; ?>!</h4>
                <div class="text-slate" style="font-size: 14px;">Mitra Eksternal UPN "Veteran" Jawa Timur.</div>
            </div>
            
            <div>
                <a href="index.php" class="btn-back-home" style="display: inline-flex; align-items: center; gap: 8px; background-color: #1c202a; color: var(--color-white); padding: 10px 20px; border-radius: 8px; border: 1px solid #2d3240; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s;">
                    <i class="fas fa-external-link-alt" style="color: #009EF7;"></i> Ke Halaman Utama
                </a>
            </div>
        </nav>

        <div class="row mt-4">
            <div class="col-md-12 mb-4">
                <div class="stat-card" style="background: linear-gradient(135deg, #16181e 0%, #1c202a 100%); border-left: 4px solid #DE2828;">
                    <div class="stat-info">
                        <h5>Prosedur Peminjaman Eksternal</h5>
                        <p class="text-slate">Peminjaman untuk pihak umum akan dikenakan tarif sesuai peraturan universitas. Pastikan Anda telah mengunggah dokumen identitas dan MoU yang diperlukan.</p>
                        <a href="#" class="btn btn-danger btn-sm mt-2">Panduan Sewa</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box blue"><i class="fas fa-building"></i></div>
                    <div class="stat-info">
                        <h5>Status Sewa</h5>
                        <p class="text-slate">Kosong</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box green"><i class="fas fa-wallet"></i></div>
                    <div class="stat-info">
                        <h5>Tagihan</h5>
                        <p class="text-slate">Rp 0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box slate"><i class="fas fa-info-circle"></i></div>
                    <div class="stat-info">
                        <h5>Bantuan</h5>
                        <p class="text-slate">Hubungi Biro Umum</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>