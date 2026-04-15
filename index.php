<?php
session_start();
// Jika user sudah login, bisa langsung diarahkan ke dashboard nantinya
if (isset($_SESSION['user_id'])) {
    // header("Location: dashboard.php");
    // exit();
}
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SI-PINJAM - Universitas Pembangunan Nasional "Veteran" Jawa Timur</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              sipblue: '#009EF7',    /* Biru Utama */
              sipbluehover: '#007BB5', /* Biru saat di-hover */
              sipred: '#DE2828',     /* Merah Aksen / Hapus / Full */
              sipdark: '#16181e',    /* Warna Card Gelap */
              sipbg: '#1c202a',      /* Warna Background Layar */
              sipborder: '#2d3240',  /* Warna Garis Tepi */
              siptext: '#64748B'     /* Warna Teks Abu-abu */
            },
            fontFamily: {
              sans: ['Inter', 'sans-serif'],
            }
          }
        }
      }
    </script>
</head>
<body class="bg-sipbg text-white font-sans antialiased relative overflow-x-hidden">
    
    <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-sipblue/20 blur-[120px] -z-10 pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] rounded-full bg-sipblue/10 blur-[100px] -z-10 pointer-events-none"></div>

    <header class="fixed w-full top-0 z-50 bg-sipbg/80 backdrop-blur-md border-b border-sipborder transition-all duration-300">
        <div class="w-full px-6 md:px-12 lg:px-20">
            <div class="flex justify-between items-center h-20">
                
                <a href="#" class="flex items-center gap-2 text-xl font-bold tracking-wide">
                    SI-PINJAM <span class="text-sipblue">UPNVJT</span>
                </a>

                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="#welcome" class="text-white font-medium hover:text-sipblue transition">Beranda</a>
                    <a href="#perbandingan" class="text-siptext hover:text-white transition">Hak Akses</a>
                    
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="dashboard_admin.php" class="px-5 py-2.5 rounded-full bg-sipborder text-white text-sm font-semibold hover:bg-gray-700 transition flex items-center gap-2">
                            <i class="fas fa-user-shield"></i> Panel Admin
                        </a>
                    <?php endif; ?>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="proses/logout.php" class="px-5 py-2.5 rounded-full border border-red-500/50 text-red-500 bg-red-500/10 text-sm font-semibold hover:bg-red-500 hover:text-white transition flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i> Log Out
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="px-6 py-2.5 rounded-full bg-sipblue text-white text-sm font-semibold hover:bg-sipbluehover shadow-lg shadow-sipblue/30 transition">
                            Log In System
                        </a>
                    <?php endif; ?>
                </nav>

            </div>
        </div>
    </header>

    <div class="pt-32 pb-20 lg:pt-40 lg:pb-28 px-4" id="welcome">
        <div class="max-w-4xl mx-auto text-center">
            
            <div class="inline-block py-1.5 px-4 rounded-full bg-sipblue/10 border border-sipblue/30 text-sipblue text-xs font-bold tracking-widest uppercase mb-6">
                UPN "Veteran" Jawa Timur
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight">
                Sistem Informasi Peminjaman <br> <span class="text-sipblue">Fasilitas Kampus</span>
            </h1>
            
            <p class="text-lg md:text-xl text-siptext mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform digital terpadu untuk memudahkan civitas akademika dan masyarakat umum dalam melakukan reservasi ruang kelas, laboratorium, hingga gedung serba guna.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="#perbandingan" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-sipblue text-white font-semibold hover:bg-sipbluehover transition shadow-lg shadow-sipblue/30">
                    Lihat Perbandingan Akses
                </a>
                <a href="lihat_jadwal.php" class="w-full sm:w-auto px-8 py-3.5 rounded-full border border-siptext text-siptext font-semibold hover:text-white hover:border-white transition bg-transparent">
                    Lihat Jadwal Fasilitas
                </a>
            </div>

            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="mt-6 flex justify-center">
                    <?php if($_SESSION['role'] === 'mahasiswa'): ?>
                        <a href="dashboard_mahasiswa.php" class="px-8 py-3.5 rounded-full bg-[#00AE1C] text-white font-semibold hover:bg-green-700 transition shadow-lg shadow-green-500/30 flex items-center gap-2">
                            <i class="fas fa-calendar-plus"></i> Buat Jadwal (Mahasiswa)
                        </a>
                    <?php elseif($_SESSION['role'] === 'admin'): ?>
                        <a href="dashboard_admin.php" class="px-8 py-3.5 rounded-full bg-siptext text-white font-semibold hover:bg-gray-500 transition flex items-center gap-2">
                            <i class="fas fa-user-shield"></i> Masuk Panel Admin
                        </a>
                    <?php else: ?>
                        <a href="dashboard_<?php echo $_SESSION['role']; ?>.php" class="px-8 py-3.5 rounded-full bg-[#00AE1C] text-white font-semibold hover:bg-green-700 transition shadow-lg shadow-green-500/30 flex items-center gap-2">
                            <i class="fas fa-calendar-plus"></i> Buat Jadwal
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <section class="py-20 bg-sipbg" id="perbandingan">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Pilih Akses Sesuai Status Anda</h2>
                <p class="text-siptext max-w-2xl mx-auto">Sistem kami membedakan alur birokrasi dan ketersediaan fasilitas berdasarkan role pengguna untuk memastikan efisiensi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-sipdark border border-sipborder rounded-2xl p-8 flex flex-col hover:-translate-y-2 hover:shadow-xl hover:shadow-sipblue/5 hover:border-sipblue/30 transition-all duration-300">
                    <div class="border-b border-sipborder pb-6 mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">Mahasiswa / UKM</h3>
                        <div class="text-3xl font-extrabold text-white mb-1">Gratis</div>
                        <div class="text-sm text-sipblue font-medium">Akademik & Organisasi</div>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Login via NPM Mahasiswa</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Kelas & Lab Fakultas</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Lapangan Olahraga</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> <span><strong>Wajib:</strong> Surat Izin BEM/Wadek</span></li>
                        <li class="flex items-start gap-3 text-sm text-siptext opacity-50"><i class="fas fa-times mt-1"></i> Akses Bebas GSG & Auditorium</li>
                        <li class="flex items-start gap-3 text-sm text-siptext opacity-50"><i class="fas fa-times mt-1"></i> Peminjaman Tanpa Batas Waktu</li>
                    </ul>
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] === 'mahasiswa'): ?>
                        <a href="dashboard_mahasiswa.php" class="block w-full py-3 text-center rounded-xl bg-sipblue text-white font-semibold hover:bg-sipbluehover transition">Buat Jadwal</a>
                    <?php elseif(!isset($_SESSION['user_id'])): ?>
                        <a href="login.php" class="block w-full py-3 text-center rounded-xl border border-sipborder text-white hover:border-sipblue hover:bg-sipblue/10 transition">Lanjut Login</a>
                    <?php endif; ?>
                </div>

                <div class="bg-sipdark border border-sipblue relative rounded-2xl p-8 flex flex-col hover:-translate-y-2 hover:shadow-xl hover:shadow-sipblue/20 transition-all duration-300">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 bg-sipblue text-white text-xs font-bold px-4 py-1 rounded-b-lg">PRIORITAS</div>
                    <div class="border-b border-sipborder pb-6 mb-6 mt-2">
                        <h3 class="text-xl font-bold text-white mb-2">Dosen & Tendik</h3>
                        <div class="text-3xl font-extrabold text-sipblue mb-1">Gratis</div>
                        <div class="text-sm text-sipblue font-medium">Prioritas Utama</div>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Login via NIP Pegawai</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Semua Ruang Kelas & Lab</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Auditorium & Seminar</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Gedung Serba Guna (GSG)</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> <span><strong>Bebas:</strong> Tanpa Surat Pengantar</span></li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Approval Otomatis / Instan</li>
                    </ul>
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] === 'dosen'): ?>
                        <a href="dashboard_dosen.php" class="block w-full py-3 text-center rounded-xl bg-sipblue text-white font-semibold hover:bg-sipbluehover transition shadow-lg shadow-sipblue/30">Buat Jadwal</a>
                    <?php elseif(!isset($_SESSION['user_id'])): ?>
                        <a href="login.php" class="block w-full py-3 text-center rounded-xl border border-sipborder text-white hover:border-sipblue hover:bg-sipblue/10 transition">Lanjut Login</a>
                    <?php endif; ?>
                </div>

                <div class="bg-sipdark border border-sipborder rounded-2xl p-8 flex flex-col hover:-translate-y-2 hover:shadow-xl hover:shadow-sipblue/5 hover:border-sipblue/30 transition-all duration-300">
                    <div class="border-b border-sipborder pb-6 mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">Umum / Eksternal</h3>
                        <div class="text-3xl font-extrabold text-white mb-1">Berbayar</div>
                        <div class="text-sm text-sipblue font-medium">Sesuai Tarif Sewa</div>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Login via NIK (KTP)</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Gedung Serba Guna (GSG)</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> Akses Lapangan Olahraga Umum</li>
                        <li class="flex items-start gap-3 text-sm text-gray-200"><i class="fas fa-check mt-1 text-sipblue"></i> <span><strong>Wajib:</strong> MoU & Bukti Bayar</span></li>
                        <li class="flex items-start gap-3 text-sm text-siptext opacity-50"><i class="fas fa-times mt-1"></i> Akses Ruang Kelas Pembelajaran</li>
                        <li class="flex items-start gap-3 text-sm text-siptext opacity-50"><i class="fas fa-times mt-1"></i> Akses Laboratorium Komputer</li>
                    </ul>
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] === 'umum'): ?>
                        <a href="dashboard_umum.php" class="block w-full py-3 text-center rounded-xl bg-sipblue text-white font-semibold hover:bg-sipbluehover transition">Buat Jadwal</a>
                    <?php elseif(!isset($_SESSION['user_id'])): ?>
                        <a href="login.php" class="block w-full py-3 text-center rounded-xl border border-sipborder text-white hover:border-sipblue hover:bg-sipblue/10 transition">Lanjut Login</a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

    </body>
</html>