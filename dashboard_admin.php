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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-sipbg text-white font-sans antialiased overflow-hidden selection:bg-sipblue selection:text-white">

    <div class="flex h-screen w-full">

        <nav class="w-72 bg-sipdark border-r border-sipborder flex flex-col shrink-0 transition-all duration-300">
            <div class="p-8 border-b border-sipborder">
                <h3 class="text-2xl font-bold tracking-wide mb-1">SI-PINJAM</h3>
                <p class="text-xs font-bold text-siptext uppercase tracking-widest">Panel Administrator</p>
            </div>

            <ul class="flex-1 py-6 px-4 space-y-2 overflow-y-auto [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder">
                <li>
                    <a href="dashboard_admin.php" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-sipblue/10 text-sipblue font-semibold border border-sipblue/20 transition-all">
                        <i class="fas fa-home text-lg"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-external-link-alt text-lg group-hover:text-sipblue transition-colors"></i> Lihat Situs
                    </a>
                </li>
                <li>
                    <a href="admin_fasilitas.php" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-building text-lg group-hover:text-sipblue transition-colors"></i> Kelola Fasilitas
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group flex-wrap">
                        <i class="fas fa-clipboard-list text-lg group-hover:text-sipblue transition-colors"></i> Antrean Pinjaman
                        <span class="ml-auto bg-sipred text-white text-[10px] font-bold px-2 py-0.5 rounded-full">12</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-siptext hover:bg-sipborder/50 hover:text-white font-medium transition-all group">
                        <i class="fas fa-users text-lg group-hover:text-sipblue transition-colors"></i> Data Pengguna
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
                    <h4 class="text-xl font-bold text-white mb-0.5">Selamat Datang, <?php echo $nama_admin; ?>!</h4>
                    <div class="text-sm font-medium text-siptext"><i class="far fa-calendar-alt mr-1"></i> <?php echo date('l, d F Y'); ?></div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    
                    <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg hover:-translate-y-1 hover:border-yellow-500/50 hover:shadow-yellow-500/10 transition-all group flex items-center gap-5 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 text-yellow-500/5 pointer-events-none">
                            <i class="fas fa-clock text-7xl"></i>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-yellow-500/10 text-yellow-500 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 group-hover:bg-yellow-500 group-hover:text-white transition-all z-10">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="z-10">
                            <h5 class="text-sm font-bold text-siptext uppercase tracking-wider mb-1">Pending</h5>
                            <p class="text-4xl font-extrabold text-white">12</p>
                        </div>
                    </div>

                    <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg hover:-translate-y-1 hover:border-[#00AE1C]/50 hover:shadow-[#00AE1C]/10 transition-all group flex items-center gap-5 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 text-[#00AE1C]/5 pointer-events-none">
                            <i class="fas fa-check-double text-7xl"></i>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-[#00AE1C]/10 text-[#00AE1C] flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 group-hover:bg-[#00AE1C] group-hover:text-white transition-all z-10">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div class="z-10">
                            <h5 class="text-sm font-bold text-siptext uppercase tracking-wider mb-1">Disetujui</h5>
                            <p class="text-4xl font-extrabold text-white">45</p>
                        </div>
                    </div>

                    <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg hover:-translate-y-1 hover:border-sipblue/50 hover:shadow-sipblue/10 transition-all group flex items-center gap-5 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 text-sipblue/5 pointer-events-none">
                            <i class="fas fa-door-open text-7xl"></i>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-sipblue/10 text-sipblue flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 group-hover:bg-sipblue group-hover:text-white transition-all z-10">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div class="z-10">
                            <h5 class="text-sm font-bold text-siptext uppercase tracking-wider mb-1">Total Ruangan</h5>
                            <p class="text-4xl font-extrabold text-white">18</p>
                        </div>
                    </div>

                </div>

                <div class="bg-sipdark border border-sipborder rounded-3xl shadow-xl flex flex-col overflow-hidden">
                    
                    <div class="p-6 border-b border-sipborder flex justify-between items-center bg-sipbg/50">
                        <h5 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-list-alt text-sipblue"></i> Pengajuan Peminjaman Terbaru
                        </h5>
                        <a href="#" class="text-sm font-semibold text-sipblue hover:text-white transition-colors">Lihat Semua &rarr;</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-sipbg border-b border-sipborder text-xs font-bold text-siptext uppercase tracking-wider">
                                    <th class="p-4 pl-6">Peminjam</th>
                                    <th class="p-4">Fasilitas</th>
                                    <th class="p-4">Tanggal</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4 pr-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-medium text-gray-300 divide-y divide-sipborder">
                                
                                <tr class="hover:bg-sipblue/5 transition-colors group">
                                    <td class="p-4 pl-6 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-xs text-white font-bold">MI</div>
                                        <span class="text-white group-hover:text-sipblue transition-colors">Muhammad Ihsanul Fikri</span>
                                    </td>
                                    <td class="p-4">Gedung GSG</td>
                                    <td class="p-4 text-siptext">12 Apr 2026</td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5 animate-pulse"></span> Pending
                                        </span>
                                    </td>
                                    <td class="p-4 pr-6">
                                        <div class="flex justify-center gap-2">
                                            <button class="w-8 h-8 rounded-lg bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 hover:bg-[#00AE1C] hover:text-white flex items-center justify-center transition-all" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="w-8 h-8 rounded-lg bg-sipred/10 text-sipred border border-sipred/30 hover:bg-sipred hover:text-white flex items-center justify-center transition-all" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

    </div>

</body>
</html>