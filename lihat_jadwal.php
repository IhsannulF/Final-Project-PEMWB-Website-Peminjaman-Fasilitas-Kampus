<?php
session_start();
require_once 'config/koneksi.php';
// Halaman ini bisa diakses publik (tanpa login)
$query_fasilitas = "SELECT * FROM fasilitas WHERE status = 'tersedia'";
$result_fasilitas = mysqli_query($koneksi, $query_fasilitas);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Jadwal Fasilitas - SI-PINJAM</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style-landing.css">
    <link rel="stylesheet" href="assets/css/style-jadwal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              sipblue: '#009EF7',    /* Biru Utama */
              sipred: '#DE2828',     /* Merah Aksen / Booked */
              sipdark: '#1c202a',    /* Background Gelap */
              sipcard: '#16181e',    /* Card Gelap */
              sipslate: '#64748B'    /* Teks Abu-abu */
            }
          }
        }
      }
      </script>
</head>

<body style="background-color: var(--bg-dark-wrapper);">

    <nav class="navbar header-sticky p-3" style="width: 100%; border-bottom: 1px solid rgba(255,255,255,0.05);">
        <div class="container-fluid px-4" style="display: flex; justify-content: space-between; align-items: center;">
            
            <a href="index.php" class="logo-text text-decoration-none" style="font-size: 1.25rem; font-weight: 700; color: #fff;">
                SI-PINJAM UPNVJT
            </a>
            
            <a href="index.php" class="btn-back-nav">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
            
        </div>
    </nav>

    <div class="container-fluid px-4 px-lg-5" style="margin-top: 100px; margin-bottom: 50px; max-width: 1800px;">
        
        <div class="airbnb-search-bar mx-auto">
            <div class="search-item">
                <label>Fasilitas</label>
                <input type="text" placeholder="Cari gedung atau lab..." id="searchFacility">
            </div>
            <div class="search-divider"></div>
            <div class="search-item" class="container" style="display: flex; align-items: center; width: 50%;">
                <label>Kategori</label>
                <select id="kategori">
                    <option value="semua">Semua Kategori</option>
                    <option value="gsg">Gedung Serba Guna</option>
                    <option value="lab">Laboratorium</option>
                    <option value="kelas">Ruang Kelas</option>
                </select>
            </div>
            <button class="btn-search-airbnb">
                <i class="fas fa-search"></i> Cari
            </button>
        </div>

        <div class="row mt-5">
            <div class="col-lg-4 mb-4">
                <h4 class="text-white mb-4">Daftar Fasilitas</h4>
                <div class="facility-list">
                    
                    <?php 
                    // Cek apakah ada data di database
                    if(mysqli_num_rows($result_fasilitas) > 0) {
                        $is_first = true; // Variabel penanda untuk fasilitas pertama
                        
                        // Keluarkan data satu per satu
                        while($row = mysqli_fetch_assoc($result_fasilitas)) { 
                            // Berikan class 'active' HANYA pada fasilitas urutan pertama
                            $active_class = $is_first ? 'active' : '';
                    ?>
                    <div class="facility-card <?php echo $active_class; ?>" data-id="<?php echo $row['id_fasilitas']; ?>">
                            <div class="facility-img">
                                <i class="<?php echo $row['ikon']; ?> fa-2x"></i>
                            </div>
                            <div class="facility-info">
                                <h5><?php echo $row['nama_fasilitas']; ?></h5>
                                <p>Kapasitas: <?php echo $row['kapasitas']; ?> Orang</p>
                            </div>
                        </div>

                    <?php 
                            $is_first = false; // Ubah penanda agar card berikutnya tidak ikut active
                        } 
                    } else {
                        // Tampilan jika tabel fasilitas masih kosong
                        echo '<p class="text-slate">Belum ada data fasilitas.</p>';
                    }
                    ?>

                </div>
            </div>

            <div class="col-lg-8">
                <div class="calendar-white-card">
                    
                    <div class="flex justify-between items-center w-full mb-8">
                        <button id="prevMonth" class="text-2xl text-gray-800 hover:bg-gray-200 p-3 rounded-full transition-colors duration-200">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h3 id="calendarMonthYear" class="text-3xl font-bold text-gray-800 text-center flex-grow m-0">
                            Bulan Tahun
                        </h3>
                        <button id="nextMonth" class="text-2xl text-gray-800 hover:bg-gray-200 p-3 rounded-full transition-colors duration-200">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="calendar-legend mb-3 d-flex justify-content-center gap-4">
                        <div class="legend-item"><span class="dot dot-available"></span> Tersedia</div>
                        <div class="legend-item"><span class="dot dot-booked"></span> Penuh / Dibooking</div>
                    </div>

                    <div class="calendar-grid-header">
                        <div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div><div>Min</div>
                    </div>

                    <div class="calendar-grid" id="calendarDays">
                        </div>

                    <div class="text-center mt-5 pt-3 border-top">
                        <?php 
                        // Jika yang login adalah ADMIN
                        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : 
                        ?>
                            <a href="dashboard_admin.php" class="btn-action-primary" style="background-color: #DE2828;">
                                <i class="fas fa-edit"></i> Edit Jadwal
                            </a>
                            
                        <?php 
                        // Jika yang login BUKAN ADMIN (Mahasiswa/Dosen/Umum), atau BELUM LOGIN
                        else : 
                            // Tentukan link: kalau sudah login arahkan ke dashboard masing-masing, kalau belum ke login.php
                            $link_pinjam = isset($_SESSION['user_id']) ? 'index.php' : 'login.php';
                        ?>
                            <a href="<?php echo $link_pinjam; ?>" class="btn-action-primary">
                                <i class="fas fa-calendar-check"></i> Ajukan Peminjaman
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script src="assets/js/script-jadwal.js"></script>
</body>
</html>