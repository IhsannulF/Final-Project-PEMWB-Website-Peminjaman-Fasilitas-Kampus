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
    
    <link rel="stylesheet" href="assets/css/style-register.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <div class="auth-wrapper">
        <div class="auth-card">
            
            <div class="form-side">
                <header class="nav-header">
                    <div class="logo">
                        <h4 style="color: #64748B; font-weight: 700; margin: 0;">Peminjaman Fasilitas UPNVJT</h4>
                    </div>
                    <nav class="nav-links">
                        <a href="index.php" class="nav-item">Beranda</a>
                    </nav>
                </header>

                <div class="content-body">
                    <p class="sub-title">MEMULAI PEMINJAMAN</p>
                    <h1 class="main-title">Buat Akun Baru<span class="title-dot"></span></h1>
                    <p class="switch-form">Sudah Punya Akun? <a href="login.php" class="link-action">Log In</a></p>

                    <?php if (isset($_SESSION['error'])) : ?>
                        <div class="alert-error">
                            <i class="fas fa-exclamation-circle"></i> 
                            <?php 
                                echo $_SESSION['error']; 
                                unset($_SESSION['error']); 
                            ?>
                        </div>
                    <?php endif; ?>

                    <form action="proses/proses_register.php" method="POST" class="register-form">
                        
                        <div class="input-row">
                            <div class="input-group">
                                <label for="identitas">NPM / NIP / NIK</label>
                                <div class="input-wrapper">
                                    <input type="text" id="identitas" name="identitas" placeholder="Misal: 24082010xxx" required autocomplete="off">
                                    <i class="fas fa-id-card input-icon"></i>
                                </div>
                            </div>
                            <div class="input-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <div class="input-wrapper">
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Sesuai KTP/KTM" required autocomplete="off">
                                    <i class="fas fa-user input-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="email">Email Aktif</label>
                            <div class="input-wrapper">
                                <input type="email" id="email" name="email" placeholder="email@student.upnjatim.ac.id" required autocomplete="off">
                                <i class="fas fa-envelope input-icon"></i>
                            </div>
                        </div>

                        <div class="input-group">
                    <div class="label-row">
                        <label for="password">Kata Sandi</label>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="•••••••••" required>
                        <i class="fas fa-eye toggle-password"></i>
                    </div>
                </div>

                        <div class="input-group" style="margin-bottom: 10px;">
                            <label for="role" style="display: block; color: var(--color-slate); margin-bottom: 8px; font-size: 14px;">Daftar Sebagai</label>
                            <div class="input-wrapper">
                                <select id="role" name="role" style="width: 100%; background-color: transparent; color: white; border: 1px solid #334155; padding: 14px 45px 14px 15px; border-radius: 8px; outline: none; appearance: none; cursor: pointer; font-family: inherit;" required>
                                    <option value="mahasiswa" style="color: #1F1F1F;">Mahasiswa UPN "Veteran" Jatim</option>
                                    <option value="umum" style="color: #1F1F1F;">Pihak Eksternal / Umum</option>
                                </select>
                                <i class="fas fa-chevron-down input-icon"></i>
                            </div>
                        </div>
                        <div class="form-actions" style="display: flex; gap: 15px; margin-top: 1px;">
                            <a href="login.php" style="flex: 1; display: flex; justify-content: center; align-items: center; padding: 12px; border: 1px solid #64748B; border-radius: 8px; color: #FFFFFF; text-decoration: none; font-weight: 600; font-size: 15px; background-color: transparent; transition: 0.3s;" onmouseover="this.style.backgroundColor='rgba(100, 116, 139, 0.2)'; this.style.borderColor='#FFFFFF';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#64748B';">
                                Kembali
                            </a>
                            <button type="submit" name="submit_register" style="flex: 1; display: flex; justify-content: center; align-items: center; padding: 12px; border: none; border-radius: 8px; color: #FFFFFF; background-color: #009EF7; font-weight: 600; font-size: 15px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#008be5';" onmouseout="this.style.backgroundColor='#009EF7';">Daftar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="image-side">
                <div class="image-panel">
                    <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=1000&auto=format&fit=crop" alt="Background" class="bg-image">
                    
                    <div class="wavy-overlay">
                        <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="wavy-line">
                            <path d="M0,0 C40,20 60,-20 100,0 L100,100 L0,100 Z" class="wave-path"></path>
                        </svg>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="assets/js/script-register.js"></script>
</body>
</html>