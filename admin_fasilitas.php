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
        $pesan = "<div class='bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 py-3 rounded-xl mb-6 flex items-center gap-3'><i class='fas fa-check-circle'></i> Berhasil menambahkan fasilitas baru!</div>";
    }
}

// --- 2. LOGIKA HAPUS FASILITAS ---
if (isset($_POST['hapus_fasilitas'])) {
    $id = (int)$_POST['id_hapus'];
    $query = "DELETE FROM fasilitas WHERE id_fasilitas = $id";
    if (mysqli_query($koneksi, $query)) {
        $pesan = "<div class='bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 py-3 rounded-xl mb-6 flex items-center gap-3'><i class='fas fa-trash-alt'></i> Fasilitas berhasil dihapus!</div>";
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
        $pesan = "<div class='bg-[#00AE1C]/10 text-[#00AE1C] border border-[#00AE1C]/30 px-4 py-3 rounded-xl mb-6 flex items-center gap-3'><i class='fas fa-shield-alt'></i> Berhasil memblokir $sukses_count hari jadwal!</div>";
    } else {
        $pesan = "<div class='bg-yellow-500/10 text-yellow-500 border border-yellow-500/30 px-4 py-3 rounded-xl mb-6 flex items-center gap-3'><i class='fas fa-exclamation-triangle'></i> Tanggal tersebut sudah diblokir sebelumnya.</div>";
    }
}

// --- 4. LOGIKA BUKA BLOKIR (HAPUS JADWAL BLOKIR) ---
if (isset($_POST['buka_blokir'])) {
    $id_pinjam = (int)$_POST['id_buka_blokir'];
    $query = "DELETE FROM peminjaman WHERE id_peminjaman = $id_pinjam";
    if (mysqli_query($koneksi, $query)) {
        $pesan = "<div class='bg-sipblue/10 text-sipblue border border-sipblue/30 px-4 py-3 rounded-xl mb-6 flex items-center gap-3'><i class='fas fa-lock-open'></i> Blokir tanggal berhasil dibuka!</div>";
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/output.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-sipbg text-white font-sans antialiased min-h-screen selection:bg-sipblue selection:text-white pb-12">

    <nav class="bg-sipdark/80 backdrop-blur-md border-b border-sipborder p-4 sticky top-0 z-50">
        <div class="container mx-auto max-w-7xl flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="dashboard_admin.php" class="w-10 h-10 rounded-full bg-sipbg border border-sipborder flex items-center justify-center text-siptext hover:text-white hover:border-white transition-all"><i class="fas fa-arrow-left"></i></a>
                <h1 class="text-xl font-bold tracking-wide">Admin Panel <span class="text-sipblue">SI-PINJAM</span></h1>
            </div>
            <a href="lihat_jadwal.php" class="px-5 py-2.5 bg-sipbg border border-sipborder hover:border-sipblue hover:text-sipblue rounded-xl text-sm font-semibold transition-all flex items-center gap-2">
                <i class="far fa-calendar-alt"></i> Lihat Kalender Publik
            </a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-7xl">
        
        <?= $pesan ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-8">
                
                <div class="bg-sipdark border border-sipborder rounded-3xl p-6 md:p-8 shadow-xl">
                    <h2 class="text-lg font-bold mb-6 flex items-center gap-3"><i class="fas fa-plus-circle text-sipblue text-xl"></i> Tambah Fasilitas</h2>
                    <form method="POST" action="">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Nama Fasilitas</label>
                                <input type="text" name="nama" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sipblue focus:ring-1 focus:ring-sipblue transition-all text-sm">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Kategori</label>
                                    <div class="relative w-full">
                                        <select name="kategori" required class="w-full bg-sipbg border border-sipborder rounded-xl pl-4 pr-10 py-3 text-white appearance-none focus:outline-none focus:border-sipblue transition-all text-sm cursor-pointer">
                                            <option value="gsg" class="bg-sipdark">GSG</option>
                                            <option value="lab" class="bg-sipdark">Lab</option>
                                            <option value="kelas" class="bg-sipdark">Kelas</option>
                                            <option value="rapat" class="bg-sipdark">Ruang Rapat</option>
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-siptext pointer-events-none"></i>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Kapasitas</label>
                                    <input type="number" name="kapasitas" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sipblue transition-all text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Pilih Ikon Fasilitas</label>
                                <div class="relative w-full">
                                    <select name="ikon" required class="w-full bg-sipbg border border-sipborder rounded-xl pl-4 pr-10 py-3 text-white appearance-none focus:outline-none focus:border-sipblue transition-all text-sm cursor-pointer">
                                        <option value="fas fa-building" class="bg-sipdark">🏢 Gedung Umum</option>
                                        <option value="fas fa-laptop-code" class="bg-sipdark">💻 Lab Komputer / IT</option>
                                        <option value="fas fa-chalkboard-teacher" class="bg-sipdark">👨‍🏫 Ruang Kelas / Teori</option>
                                        <option value="fas fa-users" class="bg-sipdark">👥 Ruang Rapat / Sidang</option>
                                        <option value="fas fa-book" class="bg-sipdark">📚 Perpustakaan / Ruang Baca</option>
                                        <option value="fas fa-futbol" class="bg-sipdark">⚽ Fasilitas Olahraga</option>
                                        <option value="fas fa-mosque" class="bg-sipdark">🕌 Fasilitas Ibadah</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-siptext pointer-events-none"></i>
                                </div>
                            </div>
                            <button type="submit" name="tambah_fasilitas" class="w-full bg-sipblue hover:bg-sipbluehover text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-sipblue/30 active:scale-[0.98] mt-2">
                                Simpan Fasilitas
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-sipdark border border-sipborder rounded-3xl p-6 md:p-8 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-sipred"></div>
                    <h2 class="text-lg font-bold mb-6 flex items-center gap-3"><i class="fas fa-calendar-times text-sipred text-xl"></i> Tutup/Blokir Jadwal</h2>
                    <form method="POST" action="">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Pilih Fasilitas</label>
                                <div class="relative w-full">
                                    <select name="id_fasilitas_blokir" required class="w-full bg-sipbg border border-sipborder rounded-xl pl-4 pr-10 py-3 text-white appearance-none focus:outline-none focus:border-sipred transition-all text-sm cursor-pointer">
                                        <?php
                                        $q_fas = mysqli_query($koneksi, "SELECT id_fasilitas, nama_fasilitas FROM fasilitas");
                                        while($f = mysqli_fetch_assoc($q_fas)){
                                            echo "<option value='{$f['id_fasilitas']}' class='bg-sipdark'>{$f['nama_fasilitas']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-siptext pointer-events-none"></i>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Mulai</label>
                                    <input type="date" name="tanggal_mulai" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sipred text-sm transition-all [&::-webkit-calendar-picker-indicator]:invert">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Selesai</label>
                                    <input type="date" name="tanggal_selesai" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sipred text-sm transition-all [&::-webkit-calendar-picker-indicator]:invert">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-siptext uppercase tracking-wider mb-2">Alasan (Cth: Maintenance)</label>
                                <input type="text" name="keperluan" required class="w-full bg-sipbg border border-sipborder rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sipred transition-all text-sm">
                            </div>
                            <button type="submit" name="blokir_jadwal" class="w-full bg-sipred hover:bg-red-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-sipred/30 active:scale-[0.98] mt-2">
                                Blokir Rentang Tanggal
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-sipdark border border-sipborder rounded-3xl p-6 md:p-8 shadow-xl flex flex-col h-[700px]">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                        <h2 class="text-lg font-bold flex items-center gap-3">
                            <i class="fas fa-list text-sipblue text-xl"></i> Daftar Fasilitas
                        </h2>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-6 border-b border-sipborder pb-6">
                        <button class="filter-btn bg-sipblue text-white border border-sipblue px-5 py-2 rounded-full text-xs font-bold tracking-wide transition-all" data-filter="semua">Semua</button>
                        <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white hover:border-siptext px-5 py-2 rounded-full text-xs font-bold tracking-wide transition-all" data-filter="gsg">GSG</button>
                        <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white hover:border-siptext px-5 py-2 rounded-full text-xs font-bold tracking-wide transition-all" data-filter="lab">Lab</button>
                        <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white hover:border-siptext px-5 py-2 rounded-full text-xs font-bold tracking-wide transition-all" data-filter="kelas">Kelas</button>
                        <button class="filter-btn bg-sipbg text-siptext border border-sipborder hover:text-white hover:border-siptext px-5 py-2 rounded-full text-xs font-bold tracking-wide transition-all" data-filter="rapat">Rapat</button>
                    </div>

                    <div class="flex-1 overflow-y-auto pr-3 space-y-3 [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-siptext">
                        
                        <?php
                        $q_fasilitas = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY kategori ASC, nama_fasilitas ASC");
                        $current_category = ""; 
                        
                        if(mysqli_num_rows($q_fasilitas) > 0) {
                            while($row = mysqli_fetch_assoc($q_fasilitas)) {
                                
                                // HEADER KATEGORI
                                if ($current_category !== $row['kategori']) {
                                    $current_category = $row['kategori'];
                                    $display_name = strtoupper($current_category);
                                    if($current_category == 'gsg') $display_name = "Gedung Serba Guna (GSG)";
                                    if($current_category == 'lab') $display_name = "Laboratorium & Komputer";
                                    if($current_category == 'kelas') $display_name = "Ruang Kelas & Teori";
                                    if($current_category == 'rapat') $display_name = "Ruang Rapat & Sidang";
                        ?>
                                    <div class="kategori-header sticky top-0 bg-sipdark/95 backdrop-blur-sm z-10 py-3 border-b border-sipborder mb-3 mt-4" data-kategori="<?= $current_category ?>">
                                        <span class="text-[10px] font-extrabold tracking-widest text-sipblue uppercase"><?= $display_name ?></span>
                                    </div>
                        <?php 
                                } 
                        ?>

                                <div class="fasilitas-item flex items-center justify-between p-4 bg-sipbg border border-sipborder rounded-2xl hover:border-sipblue/50 transition-all group" data-kategori="<?= $row['kategori'] ?>">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 rounded-xl bg-sipdark border border-sipborder flex items-center justify-center text-sipblue group-hover:scale-110 group-hover:bg-sipblue/10 transition-all shrink-0">
                                            <i class="<?= $row['ikon'] ?> text-2xl"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm text-white mb-1"><?= $row['nama_fasilitas'] ?></div>
                                            <div class="text-xs text-siptext font-medium"><i class="fas fa-users mr-1"></i> <?= $row['kapasitas'] ?> Orang</div>
                                        </div>
                                    </div>
                                    
                                    <form method="POST" action="" class="flex items-center ml-4 shrink-0">
                                        <input type="hidden" name="id_hapus" value="<?= $row['id_fasilitas'] ?>">
                                        <button type="button" onclick="konfirmasiHapus(this)" class="text-red-500 hover:text-red-400 hover:scale-110 transition-all p-2">
                                            <i class="fas fa-trash-alt text-lg"></i>
                                        </button>
                                        <button type="submit" name="hapus_fasilitas" class="hidden btn-submit-real"></button>
                                    </form>
                                </div>

                        <?php 
                            }
                        } else {
                            echo '<div class="text-center py-12 text-siptext"><i class="fas fa-box-open text-4xl mb-4 opacity-50"></i><p>Belum ada data fasilitas yang ditambahkan.</p></div>';
                        }
                        ?>

                    </div>
                </div>

                <div class="bg-sipdark border border-sipborder rounded-3xl p-6 md:p-8 shadow-xl overflow-x-auto">
                    <h2 class="text-lg font-bold mb-6 flex items-center gap-3"><i class="fas fa-calendar-minus text-siptext text-xl"></i> Jadwal yang Diblokir Admin</h2>
                    
                    <table class="w-full text-left border-collapse min-w-[600px]">
                        <thead>
                            <tr class="border-b border-sipborder text-siptext text-xs uppercase tracking-wider font-bold">
                                <th class="pb-4 px-4">Tanggal</th>
                                <th class="pb-4 px-4">Fasilitas</th>
                                <th class="pb-4 px-4">Alasan</th>
                                <th class="pb-4 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sipborder/50">
                            <?php
                            $q_blokir = mysqli_query($koneksi, "SELECT p.id_peminjaman, p.tanggal_pinjam, p.keperluan, f.nama_fasilitas 
                                                                FROM peminjaman p 
                                                                JOIN fasilitas f ON p.id_fasilitas = f.id_fasilitas 
                                                                WHERE p.status = 'diblokir' 
                                                                ORDER BY p.tanggal_pinjam ASC");
                            if(mysqli_num_rows($q_blokir) == 0){
                                echo "<tr><td colspan='4' class='py-8 text-center text-siptext text-sm'><i class='fas fa-calendar-check text-2xl mb-2 opacity-50 block'></i> Tidak ada jadwal yang sedang diblokir.</td></tr>";
                            }
                            while($row = mysqli_fetch_assoc($q_blokir)):
                            ?>
                            <tr class="hover:bg-sipbg/50 transition-colors">
                                <td class="py-4 px-4 font-bold text-sipred text-sm flex items-center gap-2">
                                    <i class="far fa-calendar-times"></i> <?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-300 font-medium"><?= $row['nama_fasilitas'] ?></td>
                                <td class="py-4 px-4 text-sm text-siptext"><?= $row['keperluan'] ?></td>
                                <td class="py-4 px-4 text-right">
                                    <form method="POST" action="">
                                        <input type="hidden" name="id_buka_blokir" value="<?= $row['id_peminjaman'] ?>">
                                        <button type="submit" name="buka_blokir" class="inline-flex items-center gap-2 text-sipblue hover:text-white bg-sipblue/10 border border-sipblue/20 hover:bg-sipblue px-4 py-2 rounded-lg text-xs font-bold transition-all">
                                            <i class="fas fa-lock-open"></i> Buka Blokir
                                        </button>
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
                cancelButtonColor: '#2d3240',  // Warna border/abu
                confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#16181e',         // Tema gelap menyesuaikan web
                color: '#ffffff',              // Teks putih
                customClass: {
                    popup: 'border border-sipborder rounded-3xl shadow-2xl',
                    confirmButton: 'rounded-xl',
                    cancelButton: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = button.closest('form');
                    form.querySelector('.btn-submit-real').click();
                }
            });
        }

        // Logika Filter Kategori
        const filterBtns = document.querySelectorAll('.filter-btn');
        const fasilitasItems = document.querySelectorAll('.fasilitas-item');
        const kategoriHeaders = document.querySelectorAll('.kategori-header');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // 1. Reset warna semua tombol
                filterBtns.forEach(b => {
                    b.classList.remove('bg-sipblue', 'text-white', 'border-sipblue');
                    b.classList.add('bg-sipbg', 'text-siptext', 'border-sipborder');
                });
                
                // 2. Warnai tombol yang sedang diklik
                btn.classList.remove('bg-sipbg', 'text-siptext', 'border-sipborder');
                btn.classList.add('bg-sipblue', 'text-white', 'border-sipblue');

                // 3. Ambil nilai kategori
                const filterValue = btn.getAttribute('data-filter');

                // 4. Sembunyikan atau Tampilkan Item Fasilitas
                fasilitasItems.forEach(item => {
                    if(filterValue === 'semua' || item.getAttribute('data-kategori') === filterValue) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });

                // 5. Sembunyikan atau Tampilkan Header Kategori
                kategoriHeaders.forEach(header => {
                    if(filterValue === 'semua' || header.getAttribute('data-kategori') === filterValue) {
                        header.style.display = 'block';
                    } else {
                        header.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>