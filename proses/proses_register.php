<?php
session_start();
// Panggil file koneksi database yang ada di luar folder proses
require_once '../config/koneksi.php';

// Cek apakah tombol submit_register ditekan
if (isset($_POST['submit_register'])) {
    
    // Tangkap data dari form dan bersihkan dari karakter berbahaya (SQL Injection)
    $identitas    = mysqli_real_escape_string($koneksi, $_POST['identitas']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password     = $_POST['password'];

    // 1. Cek apakah NPM/NIP/NIK (identitas) sudah pernah didaftarkan sebelumnya
    $cek_identitas = mysqli_query($koneksi, "SELECT * FROM users WHERE identitas = '$identitas'");
    if (mysqli_num_rows($cek_identitas) > 0) {
        $_SESSION['error'] = "Pendaftaran gagal: NPM / NIP / NIK sudah terdaftar!";
        header("Location: ../register.php");
        exit();
    }

    // 2. Enkripsi (Hash) Password demi keamanan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 3. Masukkan data ke database
    // Tangkap data role dari form
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);
    
    // Update query INSERT agar menyertakan kolom role
    $query = "INSERT INTO users (identitas, nama_lengkap, email, password, role) 
          VALUES ('$identitas', '$nama_lengkap', '$email', '$hashed_password', '$role')";
    
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil
        $_SESSION['success'] = "Akun berhasil dibuat! Silakan Log In.";
        header("Location: ../login.php");
        exit();
    } else {
        // Jika sistem error
        $_SESSION['error'] = "Terjadi kesalahan pada server.";
        header("Location: ../register.php");
        exit();
    }
} else {
    // Jika ada yang mencoba akses file ini langsung dari URL
    header("Location: ../register.php");
    exit();
}
?>