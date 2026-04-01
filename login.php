<?php
// Memulai session PHP (Wajib ada di baris paling atas sebelum tag HTML)
session_start();

// Cek jika user sudah login, arahkan langsung ke halaman utama (index)
// (Fitur ini akan aktif setelah kita buat proses_login.php)
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
    
    <link rel="stylesheet" href="assets/css/style-login.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="bg-glow"></div>

    <div class="auth-container">
        <div class="form-box" id="login-box">
            <h2>Log In</h2>
            
            <?php if (isset($_SESSION['error'])) : ?>
                <div style="background-color: #DE2828; color: white; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; text-align: center; border: 1px solid #FFC5C5;">
                    <i class="fas fa-exclamation-circle"></i> 
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']); // Hapus pesan setelah ditampilkan
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])) : ?>
                <div style="background-color: #00AE1C; color: white; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; text-align: center; border: 1px solid #C5FFCA;">
                    <i class="fas fa-check-circle"></i> 
                    <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']); 
                    ?>
                </div>
            <?php endif; ?>
            <form action="proses/proses_login.php" method="POST">
                <div class="input-group">
                    <label for="username">Username (NPM / NIP / NIK)</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan identitas Anda" required autocomplete="off">
                </div>
                
                <div class="input-group">
                    <div class="label-row">
                        <label for="password">Kata Sandi</label>
                        <a href="#" class="forgot-link">Lupa Password?</a>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="•••••••••" required>
                        <i class="fas fa-eye toggle-password"></i>
                    </div>
                </div>
                
                <button type="submit" name="submit_login" class="btn-primary">Log In</button>
            </form>

            <p class="switch-form">
                Belum punya akun? <a href="register.php" id="show-register">Daftar di sini</a>
            </p>
            <p class="switch-form" style="margin-top: 15px;">
                <a href="index.php"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
            </p>
        </div>
    </div>

    <script src="assets/js/script-login.js"></script>
</body>
</html>