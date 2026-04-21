<?php
session_start();
require_once 'config/koneksi.php';

// Tangkap ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data fasilitas dari database
$query = "SELECT * FROM fasilitas WHERE id_fasilitas = $id";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

// Jika ID tidak ditemukan, kembalikan ke index
if (!$data) {
    header("Location: index.php");
    exit();
}

// --- TRIK GAMBAR DINAMIS ---
// Kita pasangkan ID database dengan link gambar dari halaman depan
$kumpulan_gambar = [
    1  => "https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1200", // GSG
    17 => "https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=1200", // Giri Loka
    12 => "https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?q=80&w=1200", // Seminar GKB
    18 => "https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1200", // Perpustakaan
    2  => "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=1200", // Lab Komputer 1
    3  => "https://images.unsplash.com/photo-1577415124269-ce1140073282?q=80&w=1200"  // Kelas Kuliah Bersama
];

// Cek apakah ID yang diklik ada di daftar gambar kita. 
// Jika tidak ada (misal klik fasilitas lain), pakai gambar default (gambar GSG)
$gambar_tampil = isset($kumpulan_gambar[$id]) ? $kumpulan_gambar[$id] : "https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1200";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail <?php echo $data['nama_fasilitas']; ?> - SI-PINJAM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-sipbg text-white font-sans antialiased pb-20">

    <nav class="fixed w-full top-0 z-50 bg-sipbg/90 backdrop-blur-md border-b border-sipborder">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold">SI-PINJAM <span class="text-sipblue">UPNVJT</span></a>
            <a href="index.php" class="text-sm font-semibold text-siptext hover:text-white transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </nav>

    <main class="container mx-auto px-6 pt-32 max-w-6xl">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <div class="w-full lg:w-3/5">
                <div class="rounded-[40px] overflow-hidden shadow-2xl border border-sipborder aspect-video relative group">
                    <img src="<?php echo $gambar_tampil; ?>" alt="<?php echo $data['nama_fasilitas']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute top-6 left-6">
                        <span class="px-4 py-2 rounded-full bg-sipblue text-white text-xs font-bold shadow-lg uppercase tracking-wider">
                            <?php echo $data['kategori']; ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/5 flex flex-col justify-center">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight"><?php echo $data['nama_fasilitas']; ?></h1>
                
                <div class="flex items-center gap-6 mb-8 text-siptext">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-users text-sipblue text-lg"></i>
                        <span class="font-semibold text-white"><?php echo $data['kapasitas']; ?></span> Orang
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                        <span class="font-semibold text-white">Status: <?php echo ucfirst($data['status']); ?></span>
                    </div>
                </div>

                <div class="bg-sipdark border border-sipborder rounded-3xl p-8 mb-8">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-sipblue"></i> Deskripsi Fasilitas
                    </h3>
                    <p class="text-siptext leading-relaxed text-sm">
                        Ruangan ini merupakan salah satu fasilitas unggulan di lingkungan UPN "Veteran" Jawa Timur yang dirancang untuk mendukung berbagai kegiatan civitas akademika. Dilengkapi dengan pendingin ruangan, pencahayaan yang optimal, dan aksesibilitas yang mudah.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="lihat_jadwal.php" class="w-full bg-sipdark border border-sipborder hover:border-sipblue text-white font-bold py-4 rounded-2xl transition-all flex items-center justify-center gap-2">
                        <i class="far fa-calendar-alt"></i> Lihat Jadwal
                    </a>
                    <a href="login.php" class="w-full bg-sipblue hover:bg-sipbluehover text-white font-bold py-4 rounded-2xl shadow-lg shadow-sipblue/30 transition-all flex items-center justify-center gap-2">
                        Pinjam Sekarang <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>

</body>
</html>