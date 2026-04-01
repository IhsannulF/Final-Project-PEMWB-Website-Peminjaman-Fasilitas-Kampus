<?php
session_start();
require_once '../config/koneksi.php';

if (isset($_POST['submit_login'])) {
    
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Cari user berdasarkan identitas (NPM/NIP/NIK)
    $query = "SELECT * FROM users WHERE identitas = '$username'";
    $result = mysqli_query($koneksi, $query);

    // Cek apakah username ditemukan (baris data = 1)
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikasi kecocokan password yang diketik dengan hash di database
        if (password_verify($password, $user['password'])) {
            
            // Jika cocok, simpan data penting ke dalam Session
            $_SESSION['user_id']      = $user['id_user'];
            $_SESSION['identitas']    = $user['identitas'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['role']         = $user['role'];

            // PERCABANGAN ROLE: Arahkan berdasarkan status akun
            // Cari bagian pengalihan role di proses/proses_login.php
            if ($user['role'] == 'admin') {
                // Masuk sebagai Admin
                header("Location: ../dashboard_admin.php");
            } elseif ($user['role'] == 'mahasiswa') {
                // Masuk sebagai Mahasiswa
                header("Location: ../dashboard_mahasiswa.php");
            } elseif ($user['role'] == 'dosen') {
                // Masuk sebagai Dosen atau Tendik
                header("Location: ../dashboard_dosen.php");
            } elseif ($user['role'] == 'umum') {
                // Masuk sebagai Umum (Jika Anda sudah buat dashboard_umum.php)
                header("Location: ../dashboard_umum.php");
            } else {
                // Jika role tidak dikenali, lempar ke landing page
                header("Location: ../index.php"); 
            }

        } else {
            $_SESSION['error'] = "Kata sandi yang Anda masukkan salah!";
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Username tidak ditemukan di sistem kami!";
        header("Location: ../login.php");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>