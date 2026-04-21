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
    <section id="showcase" class="py-24 relative z-10 bg-sipbg overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-[1600px]">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-sipblue font-bold tracking-widest uppercase text-sm mb-3">Galeri UPNVJT</h2>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Fasilitas Kampus <span class="text-transparent bg-clip-text bg-gradient-to-r from-sipblue to-blue-400">Unggulan</span></h3>
                    <p class="text-siptext text-base leading-relaxed">
                        Eksplorasi berbagai ruang representatif yang siap mendukung setiap agenda akademik, organisasi, maupun kegiatan kolaboratif Anda.
                    </p>
                </div>
            </div>
        </div>

        <div id="carouselFasilitas" class="flex overflow-x-auto snap-x snap-mandatory gap-6 px-6 md:px-12 lg:px-20 pb-12 pt-4 [&::-webkit-scrollbar]:h-2 [&::-webkit-scrollbar-track]:bg-sipdark [&::-webkit-scrollbar-thumb]:bg-sipborder [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-siptext transition-all">
            
            <a href="detail_fasilitas.php?id=1" class="snap-start shrink-0 w-[85vw] md:w-[600px] h-[400px] relative rounded-3xl overflow-hidden group cursor-pointer shadow-2xl border border-sipborder/50 hover:border-sipblue transition-all duration-500">
                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1000&auto=format&fit=crop" alt="Gedung Serba Guna" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/50 to-transparent opacity-90"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30"><i class="fas fa-users mr-1"></i> 1000</span>
                        <span class="px-3 py-1 text-xs font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20">GSG</span>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-2">Gedung Serba Guna (GSG)</h4>
                    <p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2">
                        Pusat kegiatan utama kampus dengan kapasitas masif, cocok untuk seminar nasional, yudisium, maupun pementasan besar.
                    </p>
                </div>
            </a>

            <a href="detail_fasilitas.php?id=17" class="snap-start shrink-0 w-[80vw] md:w-[400px] h-[400px] relative rounded-3xl overflow-hidden group cursor-pointer shadow-xl border border-sipborder/50 hover:border-sipblue transition-all duration-500 block">
                <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=1000&auto=format&fit=crop" alt="Giri Loka" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/50 to-transparent opacity-90"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30"><i class="fas fa-users mr-1"></i> 500</span>
                        <span class="px-3 py-1 text-xs font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20">GSG / EVENT</span>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-2">Giri Loka</h4>
                    <p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2">
                        Fasilitas serbaguna yang representatif untuk berbagai kegiatan mahasiswa dan acara kampus berskala menengah.
                    </p>
                </div>
            </a>

            <a href="detail_fasilitas.php?id=12" class="snap-start shrink-0 w-[80vw] md:w-[400px] h-[400px] relative rounded-3xl overflow-hidden group cursor-pointer shadow-xl border border-sipborder/50 hover:border-sipblue transition-all duration-500 block">
                <img src="https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?q=80&w=1000&auto=format&fit=crop" alt="Ruang Seminar GKB" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/50 to-transparent opacity-90"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30"><i class="fas fa-users mr-1"></i> 200</span>
                        <span class="px-3 py-1 text-xs font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20">SEMINAR</span>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-2">Ruang Seminar GKB</h4>
                    <p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2">
                        Ruang auditorium mini yang nyaman, sangat ideal untuk kuliah tamu, workshop, dan pemaparan materi.
                    </p>
                </div>
            </a>

            <a href="detail_fasilitas.php?id=18" class="snap-start shrink-0 w-[80vw] md:w-[400px] h-[400px] relative rounded-3xl overflow-hidden group cursor-pointer shadow-xl border border-sipborder/50 hover:border-sipblue transition-all duration-500 block">
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1000&auto=format&fit=crop" alt="Perpustakaan Giri Santika" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/50 to-transparent opacity-90"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30"><i class="fas fa-users mr-1"></i> 500</span>
                        <span class="px-3 py-1 text-xs font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20">PERPUSTAKAAN</span>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-2">Perpustakaan Giri Santika</h4>
                    <p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2">
                        Pusat literatur dan ruang baca tenang yang mendukung produktivitas riset seluruh civitas akademika.
                    </p>
                </div>
            </a>

            <a href="detail_fasilitas.php?id=2" class="snap-start shrink-0 w-[80vw] md:w-[400px] h-[400px] relative rounded-3xl overflow-hidden group cursor-pointer shadow-xl border border-sipborder/50 hover:border-sipblue transition-all duration-500 block">
                <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=1000&auto=format&fit=crop" alt="Lab Komputer FIK 1" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/50 to-transparent opacity-90"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30"><i class="fas fa-users mr-1"></i> 40</span>
                        <span class="px-3 py-1 text-xs font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20">LAB</span>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-2">Lab Komputer FIK 1</h4>
                    <p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2">
                        Fasilitas praktikum dengan PC spesifikasi terkini untuk menunjang kegiatan perkuliahan IT dan desain.
                    </p>
                </div>
            </a>

            <a href="detail_fasilitas.php?id=3" class="snap-start shrink-0 w-[80vw] md:w-[400px] h-[400px] relative rounded-3xl overflow-hidden group cursor-pointer shadow-xl border border-sipborder/50 hover:border-sipblue transition-all duration-500 block">
                <img src="https://images.unsplash.com/photo-1577415124269-ce1140073282?q=80&w=1000&auto=format&fit=crop" alt="Ruang Kelas Kuliah Bersama" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/50 to-transparent opacity-90"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30"><i class="fas fa-users mr-1"></i> 60</span>
                        <span class="px-3 py-1 text-xs font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20">KELAS</span>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-2">Ruang Kelas Kuliah Bersama</h4>
                    <p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2">
                        Ruang kelas standar yang luas, dilengkapi pendingin ruangan dan proyektor untuk kenyamanan belajar mengajar.
                    </p>
                </div>
            </a>

            <a href="detail_fasilitas.php?id=1" class="snap-start shrink-0 w-[85vw] md:w-[600px] h-[400px] relative rounded-3xl overflow-hidden group cursor-pointer shadow-2xl border border-sipborder/50 hover:border-sipblue transition-all duration-500 block">
                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1000&auto=format&fit=crop" alt="Gedung Serba Guna" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1115] via-[#0f1115]/50 to-transparent opacity-90"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-bold bg-sipblue text-white rounded-full shadow-lg shadow-sipblue/30"><i class="fas fa-users mr-1"></i> 1000</span>
                        <span class="px-3 py-1 text-xs font-bold bg-white/10 backdrop-blur-md text-white rounded-full border border-white/20">GSG</span>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-2">Gedung Serba Guna (GSG)</h4>
                    <p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2">
                        Pusat kegiatan utama kampus dengan kapasitas masif, cocok untuk seminar nasional, yudisium, maupun pementasan besar.
                    </p>
                </div>
            </a>
            
            <div class="snap-start shrink-0 w-6 md:w-12"></div>

        </div>
        
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-[1600px] mt-8 text-center md:text-left">
            <a href="lihat_jadwal.php" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-sipdark border border-sipborder text-white text-sm font-semibold hover:bg-sipblue hover:border-sipblue hover:shadow-lg hover:shadow-sipblue/30 transition-all">
                Cek Ketersediaan Selengkapnya <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <section id="faq" class="py-24 relative z-10 bg-sipbg border-t border-sipborder/30">
        <div class="container mx-auto px-6 md:px-12 lg:px-20 max-w-[1000px]">
            
            <div class="text-center mb-16">
                <h2 class="text-sipblue font-bold tracking-widest uppercase text-sm mb-3">Bantuan & Informasi</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Pertanyaan yang Sering <span class="text-transparent bg-clip-text bg-gradient-to-r from-sipblue to-blue-400">Diajukan</span></h3>
                <p class="text-siptext text-base">
                    Temukan jawaban cepat untuk prosedur peminjaman fasilitas di lingkungan UPNVJT.
                </p>
            </div>

            <div class="space-y-4">
                
                <details class="group bg-sipdark border border-sipborder rounded-2xl [&_summary::-webkit-details-marker]:hidden hover:border-sipblue/50 transition-colors">
                    <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-white">
                        <span class="pr-6">Siapa saja yang diperbolehkan meminjam fasilitas melalui SI-PINJAM?</span>
                        <span class="transition-transform duration-300 group-open:-rotate-180 text-sipblue shrink-0">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </summary>
                    <div class="px-6 pb-6 text-siptext text-sm leading-relaxed border-t border-sipborder/50 pt-4 mt-2">
                        Peminjaman fasilitas difokuskan untuk seluruh civitas akademika kampus, termasuk mahasiswa (melalui pengurus BEM, Ormawa, atau UKM), dosen, dan tenaga kependidikan untuk keperluan akademik maupun non-akademik yang resmi.
                    </div>
                </details>

                <details class="group bg-sipdark border border-sipborder rounded-2xl [&_summary::-webkit-details-marker]:hidden hover:border-sipblue/50 transition-colors">
                    <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-white">
                        <span class="pr-6">Bagaimana alur persetujuan peminjaman ruangan?</span>
                        <span class="transition-transform duration-300 group-open:-rotate-180 text-sipblue shrink-0">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </summary>
                    <div class="px-6 pb-6 text-siptext text-sm leading-relaxed border-t border-sipborder/50 pt-4 mt-2">
                        Setelah Anda mengajukan form peminjaman melalui sistem, status akan menjadi "Menunggu Verifikasi". Admin fasilitas akan mengecek ketersediaan jadwal dan keabsahan kegiatan. Jika disetujui, status akan berubah menjadi "Disetujui" dan ruangan siap digunakan.
                    </div>
                </details>

                <details class="group bg-sipdark border border-sipborder rounded-2xl [&_summary::-webkit-details-marker]:hidden hover:border-sipblue/50 transition-colors">
                    <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-white">
                        <span class="pr-6">H-Berapa maksimal saya harus mengajukan peminjaman?</span>
                        <span class="transition-transform duration-300 group-open:-rotate-180 text-sipblue shrink-0">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </summary>
                    <div class="px-6 pb-6 text-siptext text-sm leading-relaxed border-t border-sipborder/50 pt-4 mt-2">
                        Sangat disarankan untuk mengajukan peminjaman maksimal H-14 sebelum acara berlangsung. Hal ini memberikan waktu yang cukup bagi Admin untuk memverifikasi jadwal dan memastikan tidak ada bentrok dengan kegiatan rektorat atau fakultas lainnya.
                    </div>
                </details>

                <details class="group bg-sipdark border border-sipborder rounded-2xl [&_summary::-webkit-details-marker]:hidden hover:border-sipblue/50 transition-colors">
                    <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-white">
                        <span class="pr-6">Apakah saya bisa membatalkan jadwal yang sudah disetujui?</span>
                        <span class="transition-transform duration-300 group-open:-rotate-180 text-sipblue shrink-0">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </summary>
                    <div class="px-6 pb-6 text-siptext text-sm leading-relaxed border-t border-sipborder/50 pt-4 mt-2">
                        Tentu bisa. Pembatalan dapat dilakukan langsung melalui menu Dashboard pengguna Anda. Mohon lakukan pembatalan Maksimal H agar jadwal ruangan tersebut dapat dikembalikan menjadi "Tersedia" dan bisa digunakan oleh pihak lain yang membutuhkan.
                    </div>
                </details>

            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const carousel = document.getElementById('carouselFasilitas');
            if (!carousel) return;

            let autoScrollTimer;
            const scrollInterval = 2000; // Waktu dalam milidetik untuk setiap geseran otomatis

            function startAutoScroll() {
                autoScrollTimer = setInterval(() => {
                    // Hitung batas maksimal area yang bisa di-scroll
                    const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;

                    // Jika posisi scroll sudah mencapai ujung kanan (mentok)
                    if (carousel.scrollLeft >= maxScrollLeft - 10) {
                        // Putar balik ke paling kiri dengan mulus
                        carousel.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        // Geser ke kanan seukuran kira-kira 1 kartu (400px)
                        carousel.scrollBy({ left: 400, behavior: 'smooth' });
                    }
                }, scrollInterval);
            }

            function stopAutoScroll() {
                clearInterval(autoScrollTimer);
            }

            // Jalankan otomatis saat halaman pertama kali dibuka
            startAutoScroll();

            // PENTING: Hentikan scroll saat mouse diarahkan ke kartu (supaya gampang diklik)
            carousel.addEventListener('mouseenter', stopAutoScroll);
            carousel.addEventListener('mouseleave', startAutoScroll);

            // Supaya ramah juga di HP (berhenti saat disentuh jari)
            carousel.addEventListener('touchstart', stopAutoScroll, {passive: true});
            carousel.addEventListener('touchend', startAutoScroll);
        });
    </script>
    </body>
    
</html>