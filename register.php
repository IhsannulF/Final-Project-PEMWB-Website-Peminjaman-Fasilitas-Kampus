<?php
// Wajib di baris paling atas untuk menggunakan fitur session/notifikasi
session_start();

// Jika sudah login, lempar kembali ke index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Peminjaman Fasilitas UPNVJT</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-sipbg font-sans antialiased min-h-screen flex items-center justify-center relative selection:bg-sipblue selection:text-white p-4 lg:p-8">

    <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-sipblue/20 blur-[120px] -z-10 pointer-events-none"></div>

    <div class="w-full max-w-6xl bg-sipdark/80 backdrop-blur-xl border border-sipborder rounded-3xl shadow-2xl flex flex-col-reverse lg:flex-row overflow-hidden">
        
        <div class="w-full lg:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center relative">
            
            <header class="flex justify-between items-center mb-10">
                <h4 class="text-siptext font-bold text-sm tracking-wide">SI-PINJAM UPNVJT</h4>
                <a href="index.php" class="text-sm font-semibold text-sipblue hover:text-white transition">Beranda</a>
            </header>

            <div class="mb-10">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Memulai Peminjaman</p>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">Buat Akun Baru<span class="text-sipblue">.</span></h1>
                <p class="text-sm text-siptext">Sudah Punya Akun? <a href="login.php" class="text-sipblue hover:text-white font-semibold transition">Log In</a></p>
            </div>

            <?php if (isset($_SESSION['error'])) : ?>
                <div class="bg-red-500/10 border border-red-500/50 text-red-500 px-4 py-3 rounded-xl mb-6 text-sm flex items-start gap-3">
                    <i class="fas fa-exclamation-circle mt-0.5"></i> 
                    <div>
                        <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']); 
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <form action="proses/proses_register.php" method="POST" class="space-y-5">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="identitas" class="block text-xs font-medium text-gray-300 mb-2">NPM / NIP / NIK</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-siptext"></i>
                            </div>
                            <input type="text" id="identitas" name="identitas" placeholder="Misal: 24082010xxx" required autocomplete="off" 
                                class="w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all text-sm">
                        </div>
                    </div>
                    
                    <div>
                        <label for="nama_lengkap" class="block text-xs font-medium text-gray-300 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-siptext"></i>
                            </div>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Sesuai KTP/KTM" required autocomplete="off" 
                                class="w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all text-sm">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-medium text-gray-300 mb-2">Email Aktif</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-siptext"></i>
                        </div>
                        <input type="email" id="email" name="email" placeholder="email@student.upnjatim.ac.id" required autocomplete="off" 
                            class="w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-medium text-gray-300 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-siptext"></i>
                        </div>
                        <input type="password" id="password" name="password" placeholder="•••••••••" required 
                            class="w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-12 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all text-sm">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <i class="fas fa-eye text-siptext hover:text-white cursor-pointer transition toggle-password"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-xs font-medium text-gray-300 mb-2">Daftar Sebagai</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user-tag text-siptext"></i>
                        </div>
                        <select id="role" name="role" required 
                            class="w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-10 py-3 text-white focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all appearance-none text-sm cursor-pointer">
                            <option value="mahasiswa" class="bg-sipdark">Mahasiswa UPN "Veteran" Jatim</option>
                            <option value="umum" class="bg-sipdark">Pihak Eksternal / Umum</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-siptext text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <a href="login.php" class="flex-1 flex justify-center items-center py-3.5 rounded-xl border border-siptext/50 text-white font-semibold hover:bg-siptext/20 hover:border-white transition-all text-sm">
                        Kembali
                    </a>
                    <button type="submit" name="submit_register" class="flex-1 flex justify-center items-center py-3.5 rounded-xl bg-sipblue hover:bg-sipbluehover text-white font-semibold shadow-lg shadow-sipblue/30 transition-all active:scale-[0.98] text-sm">
                        Daftar Akun
                    </button>
                </div>

            </form>
        </div>

        <div class="w-full lg:w-1/2 min-h-[300px] lg:min-h-full relative overflow-hidden hidden md:block">
            <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=1000&auto=format&fit=crop" alt="Teknologi" class="absolute inset-0 w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-sipdark/60 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-sipdark via-transparent to-transparent"></div>

            <div class="absolute bottom-12 left-12 right-12 z-10">
                <h3 class="text-3xl font-bold text-white mb-3">Manajemen Fasilitas yang Efisien</h3>
                <p class="text-gray-300 text-sm leading-relaxed">Sistem terintegrasi untuk menjadwalkan dan mengelola penggunaan seluruh fasilitas di lingkungan kampus secara *real-time*.</p>
            </div>
        </div>

    </div>

    <script src="assets/js/script-register.js"></script>
</body>
</html>