<?php
session_start();
require_once 'config/koneksi.php';

// Proteksi: Hanya Admin yang boleh masuk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$pesan = "";

// --- 1. LOGIKA TAMBAH FASILITAS ---
if (isset($_POST['tambah_fasilitas'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $kapasitas = (int)$_POST['kapasitas'];
    $ikon = mysqli_real_escape_string($koneksi, $_POST['ikon']);

    $query = "INSERT INTO fasilitas (nama_fasilitas, kategori, kapasitas, ikon) VALUES ('$nama', '$kategori', $kapasitas, '$ikon')";
    if (mysqli_query($koneksi, $query)) {
        $pesan = "<div class='bg-green-500/20 text-green-400 p-4 rounded-lg mb-6 border border-green-500/30'>Berhasil menambahkan fasilitas baru!</div>";
    }
}

// --- 2. LOGIKA HAPUS FASILITAS ---
if (isset($_POST['hapus_fasilitas'])) {
    $id = (int)$_POST['id_hapus'];
    $query = "DELETE FROM fasilitas WHERE id_fasilitas = $id";
    if (mysqli_query($koneksi, $query)) {
        $pesan = "<div class='bg-green-500/20 text-green-400 p-4 rounded-lg mb-6 border border-green-500/30'>Fasilitas berhasil dihapus!</div>";
    }
}

// --- 3. LOGIKA BLOKIR TANGGAL JADWAL (RENTANG HARI) ---
if (isset($_POST['blokir_jadwal'])) {
    $id_fasilitas = (int)$_POST['id_fasilitas_blokir'];
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'];
    $keperluan = mysqli_real_escape_string($koneksi, $_POST['keperluan']);

    // Konversi string ke objek tanggal
    $begin = new DateTime($tgl_mulai);
    $end = new DateTime($tgl_selesai);
    $end->modify('+1 day'); // Agar tanggal selesai tetap terhitung dalam loop

    $interval = new DateInterval('P1D'); // Interval 1 hari
    $period = new DatePeriod($begin, $interval, $end);

    $sukses_count = 0;

    foreach ($period as $dt) {
        $tgl_format = $dt->format("Y-m-d");
        
        // Cek dulu apakah tanggal tersebut sudah diblokir sebelumnya agar tidak duplikat
        $cek = mysqli_query($koneksi, "SELECT id_peminjaman FROM peminjaman WHERE id_fasilitas = $id_fasilitas AND tanggal_pinjam = '$tgl_format'");
        
        if (mysqli_num_rows($cek) == 0) {
            $query = "INSERT INTO peminjaman (id_user, id_fasilitas, tanggal_pinjam, keperluan, status) 
                      VALUES (NULL, $id_fasilitas, '$tgl_format', '$keperluan', 'diblokir')";
            mysqli_query($koneksi, $query);
            $sukses_count++;
        }
    }

    if ($sukses_count > 0) {
        $pesan = "<div class='bg-green-500/20 text-green-400 p-4 rounded-lg mb-6 border border-green-500/30'>Berhasil memblokir $sukses_count hari jadwal!</div>";
    } else {
        $pesan = "<div class='bg-yellow-500/20 text-yellow-400 p-4 rounded-lg mb-6 border border-yellow-500/30'>Tanggal tersebut sudah diblokir sebelumnya.</div>";
    }
}

// --- 4. LOGIKA BUKA BLOKIR (HAPUS JADWAL BLOKIR) ---
if (isset($_POST['buka_blokir'])) {
    $id_pinjam = (int)$_POST['id_buka_blokir'];
    $query = "DELETE FROM peminjaman WHERE id_peminjaman = $id_pinjam";
    if (mysqli_query($koneksi, $query)) {
        $pesan = "<div class='bg-green-500/20 text-green-400 p-4 rounded-lg mb-6 border border-green-500/30'>Blokir tanggal berhasil dibuka!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Fasilitas - Admin SI-PINJAM</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              sipblue: '#009EF7',
              sipred: '#DE2828',
              sipdark: '#16181e', /* Card Gelap */
              sipbg: '#1c202a',   /* Background Utama */
              sipborder: '#2d3240',
              siptext: '#64748B'
            },
            fontFamily: {
              sans: ['Inter', 'sans-serif'],
            }
          }
        }
      }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-sipbg text-white font-sans antialiased min-h-screen">

    <nav class="bg-sipdark border-b border-sipborder p-4 sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="dashboard_admin.php" class="text-siptext hover:text-white transition"><i class="fas fa-arrow-left"></i></a>
                <h1 class="text-xl font-bold">Admin Panel <span class="text-sipblue">SI-PINJAM</span></h1>
            </div>
            <a href="lihat_jadwal.php" class="px-4 py-2 bg-sipborder hover:bg-gray-700 rounded-lg text-sm transition">Lihat Kalender Publik</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-7xl">
        
        <?= $pesan ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-8">
                
                <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2"><i class="fas fa-plus-circle text-sipblue"></i> Tambah Fasilitas</h2>
                    <form method="POST" action="">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-siptext mb-1">Nama Fasilitas</label>
                                <input type="text" name="nama" required class="w-full bg-sipbg border border-sipborder rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-siptext mb-1">Kategori</label>
                                    <select name="kategori" class="w-full bg-sipbg border border-sipborder rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-sipblue">
                                        <option value="gsg">GSG</option>
                                        <option value="lab">Lab</option>
                                        <option value="kelas">Kelas</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-siptext mb-1">Kapasitas</label>
                                    <input type="number" name="kapasitas" required class="w-full bg-sipbg border border-sipborder rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-sipblue">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm text-siptext mb-1">Pilih Ikon Fasilitas</label>
                                <select name="ikon" required class="w-full bg-sipbg border border-sipborder rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-sipblue">
                                    <option value="fas fa-building">🏢 Gedung Umum (fa-building)</option>
                                    <option value="fas fa-laptop-code">💻 Lab Komputer / IT (fa-laptop-code)</option>
                                    <option value="fas fa-chalkboard-teacher">👨‍🏫 Ruang Kelas / Teori (fa-chalkboard-teacher)</option>
                                    <option value="fas fa-users">👥 Ruang Rapat / Sidang (fa-users)</option>
                                    <option value="fas fa-book">📚 Perpustakaan / Ruang Baca (fa-book)</option>
                                    <option value="fas fa-futbol">⚽ Fasilitas Olahraga (fa-futbol)</option>
                                    <option value="fas fa-mosque">🕌 Fasilitas Ibadah (fa-mosque)</option>
                                </select>
                            </div>
                            <button type="submit" name="tambah_fasilitas" class="w-full bg-sipblue hover:bg-blue-600 text-white font-semibold py-2.5 rounded-lg transition mt-2">
                                Simpan Fasilitas
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg border-l-4 border-l-sipred">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2"><i class="fas fa-calendar-times text-sipred"></i> Tutup/Blokir Jadwal</h2>
                    <form method="POST" action="">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-siptext mb-1">Pilih Fasilitas</label>
                                <select name="id_fasilitas_blokir" required class="w-full bg-sipbg border border-sipborder rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-sipred">
                                    <?php
                                    $q_fas = mysqli_query($koneksi, "SELECT id_fasilitas, nama_fasilitas FROM fasilitas");
                                    while($f = mysqli_fetch_assoc($q_fas)){
                                        echo "<option value='{$f['id_fasilitas']}'>{$f['nama_fasilitas']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-siptext mb-1">Mulai</label>
                                    <input type="date" name="tanggal_mulai" required class="w-full bg-sipbg border border-sipborder rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-sipred text-xs">
                                </div>
                                <div>
                                    <label class="block text-sm text-siptext mb-1">Selesai</label>
                                    <input type="date" name="tanggal_selesai" required class="w-full bg-sipbg border border-sipborder rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-sipred text-xs">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm text-siptext mb-1">Alasan (Cth: Maintenance)</label>
                                <input type="text" name="keperluan" required class="w-full bg-sipbg border border-sipborder rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-sipred">
                            </div>
                            <button type="submit" name="blokir_jadwal" class="w-full bg-sipred hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg transition mt-2">
                                Blokir Rentang Tanggal
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg overflow-x-auto">
                    <h2 class="text-lg font-bold mb-4">Daftar Fasilitas Sistem</h2>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-sipborder text-siptext text-sm">
                                <th class="pb-3 px-2">Fasilitas</th>
                                <th class="pb-3 px-2">Kapasitas</th>
                                <th class="pb-3 px-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q_fasilitas = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY id_fasilitas DESC");
                            while($row = mysqli_fetch_assoc($q_fasilitas)):
                            ?>
                            <tr class="border-b border-sipborder/50 hover:bg-sipbg/50 transition">
                                <td class="py-3 px-2 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-sipbg flex items-center justify-center text-sipblue"><i class="<?= $row['ikon'] ?>"></i></div>
                                    <div>
                                        <div class="font-semibold text-sm"><?= $row['nama_fasilitas'] ?></div>
                                        <div class="text-xs text-siptext uppercase"><?= $row['kategori'] ?></div>
                                    </div>
                                </td>
                                <td class="py-3 px-2 text-sm"><?= $row['kapasitas'] ?> Orang</td>
                                <td class="py-3 px-2 text-right">
                                    <form method="POST" action="" class="form-hapus">
                                        <input type="hidden" name="id_hapus" value="<?= $row['id_fasilitas'] ?>">
                                        <button type="button" onclick="konfirmasiHapus(this)" class="text-red-400 hover:text-red-300 bg-red-400/10 px-3 py-1.5 rounded text-xs font-medium transition">
                                            Hapus
                                        </button>
                                        <button type="submit" name="hapus_fasilitas" class="hidden btn-submit-real"></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="bg-sipdark border border-sipborder rounded-2xl p-6 shadow-lg overflow-x-auto">
                    <h2 class="text-lg font-bold mb-4">Jadwal yang Diblokir Admin</h2>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-sipborder text-siptext text-sm">
                                <th class="pb-3 px-2">Tanggal</th>
                                <th class="pb-3 px-2">Fasilitas</th>
                                <th class="pb-3 px-2">Alasan</th>
                                <th class="pb-3 px-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Ambil data peminjaman yang statusnya 'diblokir'
                            $q_blokir = mysqli_query($koneksi, "SELECT p.id_peminjaman, p.tanggal_pinjam, p.keperluan, f.nama_fasilitas 
                                                                FROM peminjaman p 
                                                                JOIN fasilitas f ON p.id_fasilitas = f.id_fasilitas 
                                                                WHERE p.status = 'diblokir' 
                                                                ORDER BY p.tanggal_pinjam ASC");
                            if(mysqli_num_rows($q_blokir) == 0){
                                echo "<tr><td colspan='4' class='py-4 text-center text-siptext text-sm'>Tidak ada jadwal yang diblokir.</td></tr>";
                            }
                            while($row = mysqli_fetch_assoc($q_blokir)):
                            ?>
                            <tr class="border-b border-sipborder/50 hover:bg-sipbg/50 transition">
                                <td class="py-3 px-2 font-medium text-sipred text-sm"><?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?></td>
                                <td class="py-3 px-2 text-sm"><?= $row['nama_fasilitas'] ?></td>
                                <td class="py-3 px-2 text-sm text-siptext"><?= $row['keperluan'] ?></td>
                                <td class="py-3 px-2 text-right">
                                    <form method="POST" action="">
                                        <input type="hidden" name="id_buka_blokir" value="<?= $row['id_peminjaman'] ?>">
                                        <button type="submit" name="buka_blokir" class="text-sipblue hover:text-blue-300 bg-sipblue/10 px-3 py-1.5 rounded text-xs font-medium transition">Buka Blokir</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

<script>
        function konfirmasiHapus(button) {
            Swal.fire({
                title: 'Hapus Fasilitas?',
                text: "Semua jadwal yang terkait dengan fasilitas ini mungkin akan ikut terhapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DE2828', // Warna merah SI-PINJAM
                cancelButtonColor: '#64748B',  // Warna abu-abu
                confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#16181e',         // Tema gelap menyesuaikan web
                color: '#ffffff',              // Teks putih
                customClass: {
                    popup: 'border border-gray-700 rounded-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika diklik 'Ya', cari tombol submit asli di dalam form yang sama, lalu klik otomatis
                    const form = button.closest('form');
                    form.querySelector('.btn-submit-real').click();
                }
            });
        }
    </script>
    
</body>
</html>
</body>
</html>