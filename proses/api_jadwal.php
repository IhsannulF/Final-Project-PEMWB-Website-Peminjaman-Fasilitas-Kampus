<?php
// Mencegah error CORS jika diakses dari luar
header('Content-Type: application/json');
require_once '../config/koneksi.php';

// Ambil parameter dari URL (JavaScript)
$id_fasilitas = isset($_GET['id_fasilitas']) ? (int)$_GET['id_fasilitas'] : 1;
$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('n');
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

// Array untuk menyimpan tanggal yang penuh/dibooking/diblokir
$booked_dates = [];

// JURUS KUNCI: Ambil semua jadwal yang BUKAN berstatus 'ditolak'
// (Artinya: 'pending', 'disetujui', dan 'diblokir' akan memerah di kalender)
$query = "SELECT DAY(tanggal_pinjam) as tanggal 
          FROM peminjaman 
          WHERE id_fasilitas = $id_fasilitas 
          AND MONTH(tanggal_pinjam) = $bulan 
          AND YEAR(tanggal_pinjam) = $tahun
          AND status IN ('pending', 'disetujui', 'diblokir')";

$result = mysqli_query($koneksi, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Masukkan tanggal (angka) ke dalam array
        $booked_dates[] = (int)$row['tanggal'];
    }
}

// Kirim data kembali ke JavaScript dalam format JSON (misal: [12, 15, 20])
echo json_encode($booked_dates);
?>