<?php
// Pengaturan default dari XAMPP
$host     = "localhost";
$username = "root";      // User bawaan XAMPP
$password = "";          // Password bawaan XAMPP memang kosong
$database = "si_pinjam"; // Nama database yang baru saja kita buat

// Melakukan koneksi ke MySQL menggunakan fungsi mysqli
$koneksi = mysqli_connect($host, $username, $password, $database);

// Mengecek apakah koneksi berhasil atau tidak
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Jika berhasil, tidak perlu menampilkan apa-apa agar layar tetap bersih
// echo "Koneksi berhasil!"; // (Bisa di-uncomment sementara jika ingin mengetes)
?>