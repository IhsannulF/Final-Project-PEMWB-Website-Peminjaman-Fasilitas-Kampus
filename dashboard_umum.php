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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-sipbg text-white font-sans antialiased overflow-hidden selection:bg-sipblue selection:text-white">

    <div class="flex h-screen w-full">

        <nav class="w-72 bg-sipdark border-r border-sipborder flex flex-col shrink-0 transition-all duration-300">
            <div class="p-8 border-b border-sipborder">
                <h3 class="text-2xl font-bold tracking-wide mb-1">SI-PINJAM</h3>
                <p class="text-sm font-medium text-siptext uppercase tracking-widest">Pihak Eksternal</p>
            </div>

            <ul class="flex-1 py-6 px-4 space-y-2 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                <li>
                    <a href="dashboard_umum.php" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-sipblue/10 text-sipblue font-semibold border border-sipblue/20 transition-all">
                        <i class="fas fa-home text-lg"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-search text-lg group-hover:text-sipblue transition-colors"></i> Cari Fasilitas
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-file-invoice-dollar text-lg group-hover:text-sipblue transition-colors"></i> Sewa Gedung
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-history text-lg group-hover:text-sipblue transition-colors"></i> Riwayat Transaksi
                    </a>
                </li>
            </ul>

            <div class="p-4 border-t border-sipborder">
                <a href="proses/logout.php" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl border border-sipred/50 text-sipred bg-sipred/5 hover:bg-sipred hover:text-white font-semibold transition-all shadow-[0_0_15px_rgba(222,40,40,0.1)]">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </nav>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-sipbg to-[#15181f]">
            
            <header class="h-20 border-b border-sipborder flex items-center justify-between px-8 bg-sipdark/50 backdrop-blur-md shrink-0">
                <div>
                    <h4 class="text-xl font-bold text-white mb-0.5">Selamat Datang, <?php echo $nama_user; ?>!</h4>
                    <div class="text-sm font-medium text-siptext">Mitra Eksternal UPN "Veteran" Jawa Timur.</div>
                </div>
                
                <a href="index.php" class="flex items-center gap-2 bg-sipdark text-white px-5 py-2.5 rounded-xl border border-sipborder hover:border-sipblue hover:bg-sipblue/5 font-semibold text-sm transition-all shadow-md group">
                    <i class="fas fa-external-link-alt text-sipblue group-hover:scale-110 transition-transform"></i> Ke Halaman Utama
                </a>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="bg-gradient-to-r from-sipdark to-sipbg border border-sipborder border-l-4 border-l-sipred rounded-2xl p-6 shadow-xl mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-sipred/5 pointer-events-none">
                        <i class="fas fa-file-contract text-9xl"></i>
                    </div>
                    
                    <div class="relative z-10 max-w-3xl">
                        <h5 class="text-lg font-bold text-white mb-2 flex items-center gap-2">
                            <i class="fas fa-info-circle text-sipred"></i> Prosedur Peminjaman Eksternal
                        </h5>
                        <p class="text-sm text-siptext leading-relaxed">
                            Peminjaman untuk pihak umum akan dikenakan tarif sesuai peraturan universitas. Pastikan Anda telah mengunggah dokumen identitas dan MoU yang diperlukan sebelum mengajukan jadwal.
                        </p>
                    </div>
                    
                    <div class="relative z-10 shrink-0 w-full md:w-auto">
                        <a href="#" class="block w-full md:w-auto text-center bg-sipred hover:bg-red-700 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-sipred/20">
                            Unduh Panduan Sewa
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg hover:-translate-y-1 hover:border-sipblue/50 hover:shadow-sipblue/10 transition-all group flex items-center gap-5">
                        <div class="w-14 h-14 rounded-xl bg-sipblue/10 text-sipblue flex items-center justify-center text-2xl shrink-0 group-hover:scale-110 group-hover:bg-sipblue group-hover:text-white transition-all">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-siptext uppercase tracking-wider mb-1">Status Sewa</h5>
                            <p class="text-xl font-extrabold text-white">Kosong</p>
                        </div>
                    </div>

                    <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg hover:-translate-y-1 hover:border-[#00AE1C]/50 hover:shadow-[#00AE1C]/10 transition-all group flex items-center gap-5">
                        <div class="w-14 h-14 rounded-xl bg-[#00AE1C]/10 text-[#00AE1C] flex items-center justify-center text-2xl shrink-0 group-hover:scale-110 group-hover:bg-[#00AE1C] group-hover:text-white transition-all">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-siptext uppercase tracking-wider mb-1">Total Tagihan</h5>
                            <p class="text-xl font-extrabold text-white">Rp 0</p>
                        </div>
                    </div>

                    <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg hover:-translate-y-1 hover:border-siptext/50 hover:shadow-siptext/10 transition-all group flex items-center gap-5">
                        <div class="w-14 h-14 rounded-xl bg-sipborder text-siptext flex items-center justify-center text-2xl shrink-0 group-hover:scale-110 group-hover:bg-gray-600 group-hover:text-white transition-all">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-siptext uppercase tracking-wider mb-1">Bantuan Info</h5>
                            <p class="text-sm font-semibold text-white mt-1.5"><a href="#" class="hover:text-sipblue transition-colors">Hubungi Biro Umum &rarr;</a></p>
                        </div>
                    </div>

                </div>

            </div>
        </main>

    </div>

</body>
</html>