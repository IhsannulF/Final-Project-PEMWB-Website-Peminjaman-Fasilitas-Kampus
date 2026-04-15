<?php
// Memulai session PHP (Wajib ada di baris paling atas sebelum tag HTML)
session_start();

// Cek jika user sudah login, arahkan langsung ke halaman utama (index)
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
    <title>Login - SI Peminjaman Fasilitas UPNVJ</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/output.css">
</head>

<body class="bg-sipbg font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden selection:bg-sipblue selection:text-white">

    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-sipblue/20 blur-[120px] -z-10 pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[400px] h-[400px] rounded-full bg-sipblue/10 blur-[100px] -z-10 pointer-events-none"></div>

    <div class="w-full max-w-md mx-4 z-10">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-white tracking-wide">
                SI-PINJAM <span class="text-sipblue">UPNVJT</span>
            </h1>
            <p class="text-siptext mt-2">Masuk untuk mengelola jadwal fasilitas</p>
        </div>

        <div class="bg-sipdark/80 backdrop-blur-xl border border-sipborder rounded-3xl p-8 shadow-2xl">
            <h2 class="text-2xl font-bold text-white mb-6">Log In</h2>
            
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="bg-red-500/10 border border-red-500/50 text-red-500 px-4 py-3 rounded-xl mb-6 text-sm text-center flex items-center justify-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> 
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']); 
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])) : ?>
                <div class="bg-[#00AE1C]/10 border border-[#00AE1C]/50 text-[#00AE1C] px-4 py-3 rounded-xl mb-6 text-sm text-center flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle"></i> 
                    <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']); 
                    ?>
                </div>
            <?php endif; ?>

            <form action="proses/proses_login.php" method="POST" class="space-y-5">
                
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Username (NPM / NIP / NIK)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user text-siptext"></i>
                        </div>
                        <input type="text" id="username" name="username" placeholder="Masukkan identitas Anda" required autocomplete="off" 
                            class="w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-4 py-3.5 text-white placeholder-gray-500 focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all">
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="text-sm font-medium text-gray-300">Kata Sandi</label>
                        <a href="#" class="text-xs text-sipblue hover:text-sipbluehover font-semibold transition">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-siptext"></i>
                        </div>
                        <input type="password" id="password" name="password" placeholder="•••••••••" required 
                            class="w-full bg-sipbg border border-sipborder rounded-xl pl-11 pr-12 py-3.5 text-white placeholder-gray-500 focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all">
                        
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <i class="fas fa-eye text-siptext hover:text-white cursor-pointer transition toggle-password"></i>
                        </div>
                    </div>
                </div>
                
                <button type="submit" name="submit_login" 
                    class="w-full bg-sipblue hover:bg-sipbluehover text-white font-semibold rounded-xl py-3.5 mt-2 transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98]">
                    Log In
                </button>
            </form>

            <div class="mt-8 text-center space-y-4">
                <p class="text-sm text-siptext">
                    Belum punya akun? <a href="register.php" class="text-sipblue font-semibold hover:text-white transition">Daftar di sini</a>
                </p>
                <a href="index.php" class="inline-flex items-center gap-2 text-sm text-siptext hover:text-white transition mt-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

    <script src="assets/js/script-login.js"></script>
</body>
</html>