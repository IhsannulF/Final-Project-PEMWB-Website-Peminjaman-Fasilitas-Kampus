<?php
// File: proses/api_jadwal.php
require_once '../config/koneksi.php';

// Tangkap request dari JavaScript
$id_fasilitas = isset($_GET['id_fasilitas']) ? intval($_GET['id_fasilitas']) : 1;
$bulan = isset($_GET['bulan']) ? intval($_GET['bulan']) : date('m');
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : date('Y');

// Cari tanggal berapa saja yang sudah DIBOOKING atau DIBLOKIR pada bulan & fasilitas tersebut
$query = "SELECT tanggal_pinjam FROM peminjaman 
          WHERE id_fasilitas = $id_fasilitas 
          AND MONTH(tanggal_pinjam) = $bulan 
          AND YEAR(tanggal_pinjam) = $tahun 
          AND status IN ('disetujui', 'diblokir')";

$result = mysqli_query($koneksi, $query);

$booked_dates = [];
// Ambil hanya angka tanggalnya saja (misal: 15)
while($row = mysqli_fetch_assoc($result)){
    $booked_dates[] = (int)date('d', strtotime($row['tanggal_pinjam']));
}

// Kirim data dalam format JSON ke JavaScript
header('Content-Type: application/json');
echo json_encode($booked_dates);
?>