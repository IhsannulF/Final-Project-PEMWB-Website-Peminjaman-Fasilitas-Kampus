<?php
session_start();
// Jika user sudah login, bisa langsung diarahkan ke dashboard nantinya
if (isset($_SESSION['user_id'])) {
    // header("Location: dashboard.php");
    // exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SI-PINJAM - Universitas Pembangunan Nasional "Veteran" Jawa Timur</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="assets/css/style-landing.css">
</head>
<body>
    
    <div class="bg-glow-top"></div>
    <div class="bg-glow-bottom"></div>

    <header class="header-area header-sticky" id="header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <a href="#" class="logo">
                            <h4 class="logo-text">SI-PINJAM UPNVJT</h4>
                        </a>
                        <ul class="nav">
                            <li><a href="#welcome" class="nav-link active">Beranda</a></li>
                            <li><a href="#perbandingan" class="nav-link">Hak Akses</a></li>
                            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li>
                            <a href="dashboard_admin.php" class="btn-admin-nav">
                                <i class="fas fa-user-shield"></i> Panel Admin
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <li>
                                <a href="proses/logout.php" class="btn-logout-nav">
                                    <i class="fas fa-sign-out-alt"></i> Log Out
                                </a>
                            </li>
                            <?php else: ?>
                                <li><a href="login.php" class="btn-login-nav">Log In System</a></li>
                                <?php endif; ?>
                            </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div class="welcome-area" id="welcome">
        <div class="header-text">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12 text-center">
                        <div class="badge-kampus">UPN "Veteran" Jawa Timur</div>
                        <h1 class="hero-title">Sistem Informasi Peminjaman <strong>Fasilitas Kampus</strong></h1>
                        <p class="hero-desc">Platform digital terpadu untuk memudahkan civitas akademika dan masyarakat umum dalam melakukan reservasi ruang kelas, laboratorium, hingga gedung serba guna.</p>
                        <div class="hero-buttons">
    <a href="#perbandingan" class="main-button-slider">Lihat Perbandingan Akses</a>
    <a href="lihat_jadwal.php" class="outline-button">Lihat Jadwal Fasilitas</a>
</div>

<?php if(isset($_SESSION['user_id'])): ?>
    <div class="hero-buttons" style="margin-top: 15px;">
        
        <?php if($_SESSION['role'] === 'mahasiswa'): ?>
            <a href="dashboard_mahasiswa.php" class="outline-button" style="background-color: #00AE1C; color: white; border-color: #00AE1C;">
                <i class="fas fa-calendar-plus"></i> Buat Jadwal (Mahasiswa)
            </a>
            
        <?php elseif($_SESSION['role'] === 'admin'): ?>
            <a href="dashboard_admin.php" class="outline-button" style="background-color: #64748B; color: white; border-color: #64748B;">
                <i class="fas fa-user-shield"></i> Masuk Panel Admin
            </a>
            
        <?php else: ?>
            <a href="dashboard_<?php echo $_SESSION['role']; ?>.php" class="outline-button" style="background-color: #00AE1C; color: white; border-color: #00AE1C;">
                <i class="fas fa-calendar-plus"></i> Buat Jadwal
            </a>
        <?php endif; ?>
        
    </div>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="section pricing-section" id="perbandingan">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="center-heading">
                        <h2 class="section-title">Pilih Akses Sesuai Status Anda</h2>
                    </div>
                </div>
                <div class="offset-lg-3 col-lg-6">
                    <div class="center-text">
                        <p>Sistem kami membedakan alur birokrasi dan ketersediaan fasilitas berdasarkan role pengguna untuk memastikan efisiensi.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="pricing-item">
                        <div class="pricing-header">
                            <h3 class="pricing-title">Mahasiswa / UKM</h3>
                        </div>
                        <div class="pricing-body">
                            <div class="price-wrapper">
                                <span class="price">Gratis</span>
                                <span class="period">Akademik & Organisasi</span>
                            </div>
                            <ul class="list">
                                <li class="active">Login via NPM Mahasiswa</li>
                                <li class="active">Akses Kelas & Lab Fakultas</li>
                                <li class="active">Akses Lapangan Olahraga</li>
                                <li class="active"><strong>Wajib:</strong> Surat Izin BEM/Wadek</li>
                                <li>Akses Bebas GSG & Auditorium</li>
                                <li>Peminjaman Tanpa Batas Waktu</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
    <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] === 'mahasiswa'): ?>
        <a href="dashboard_mahasiswa.php" class="main-button" style="background-color: #009EF7;">Buat Jadwal</a>
    <?php elseif(!isset($_SESSION['user_id'])): ?>
        <a href="login.php" class="main-button">Lanjut Login</a>
    <?php endif; ?>
</div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="pricing-item active">
                        <div class="pricing-header">
                            <h3 class="pricing-title">Dosen & Tendik</h3>
                        </div>
                        <div class="pricing-body">
                            <div class="price-wrapper">
                                <span class="price">Gratis</span>
                                <span class="period">Prioritas Utama</span>
                            </div>
                            <ul class="list">
                                <li class="active">Login via NIP Pegawai</li>
                                <li class="active">Akses Semua Ruang Kelas & Lab</li>
                                <li class="active">Akses Auditorium & Ruang Seminar</li>
                                <li class="active">Akses Gedung Serba Guna (GSG)</li>
                                <li class="active"><strong>Bebas:</strong> Tanpa Surat Pengantar</li>
                                <li class="active">Approval Otomatis / Instan</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
    <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] === 'dosen'): ?>
        <a href="dashboard_dosen.php" class="main-button" style="background-color: #009EF7;">Buat Jadwal</a>
    <?php elseif(!isset($_SESSION['user_id'])): ?>
        <a href="login.php" class="main-button">Lanjut Login</a>
    <?php endif; ?>
</div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="pricing-item">
                        <div class="pricing-header">
                            <h3 class="pricing-title">Umum / Eksternal</h3>
                        </div>
                        <div class="pricing-body">
                            <div class="price-wrapper">
                                <span class="price">Berbayar</span>
                                <span class="period">Sesuai Tarif Sewa</span>
                            </div>
                            <ul class="list">
                                <li class="active">Login via NIK (KTP)</li>
                                <li class="active">Akses Gedung Serba Guna (GSG)</li>
                                <li class="active">Akses Lapangan Olahraga Umum</li>
                                <li class="active"><strong>Wajib:</strong> MoU & Bukti Bayar</li>
                                <li>Akses Ruang Kelas Pembelajaran</li>
                                <li>Akses Laboratorium Komputer</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
    <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] === 'umum'): ?>
        <a href="dashboard_umum.php" class="main-button" style="background-color: #009EF7;">Buat Jadwal</a>
    <?php elseif(!isset($_SESSION['user_id'])): ?>
        <a href="login.php" class="main-button">Lanjut Login</a>
    <?php endif; ?>
</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/js/jquery-2.1.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/script-landing.js"></script>
</body>
</html>