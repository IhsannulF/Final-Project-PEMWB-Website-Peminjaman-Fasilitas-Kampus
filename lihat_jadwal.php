<?php
session_start();
require_once 'config/koneksi.php';
// Halaman ini bisa diakses publik (tanpa login)
$query_fasilitas = "SELECT * FROM fasilitas WHERE status = 'tersedia'";
$result_fasilitas = mysqli_query($koneksi, $query_fasilitas);
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Jadwal Fasilitas - SI-PINJAM</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/output.css">
</head>

<body class="bg-sipbg text-white font-sans antialiased relative selection:bg-sipblue selection:text-white pb-20">

    <div class="fixed top-[-10%] right-[-5%] w-[500px] h-[500px] rounded-full bg-sipblue/10 blur-[120px] -z-10 pointer-events-none"></div>

    <header class="fixed w-full top-0 z-50 bg-sipbg/90 backdrop-blur-md border-b border-sipborder">
        <div class="w-full px-6 md:px-12 lg:px-20">
            <div class="flex justify-between items-center h-20">
                <a href="index.php" class="flex items-center gap-2 text-xl font-bold tracking-wide">
                    SI-PINJAM <span class="text-sipblue">UPNVJT</span>
                </a>
                <a href="index.php" class="text-sm font-semibold text-siptext hover:text-white transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </header>

    <div class="w-full px-4 md:px-12 lg:px-20 pt-32 max-w-[1600px] mx-auto">
        
        <div class="bg-sipdark/80 backdrop-blur-xl border border-sipborder rounded-full p-2.5 flex flex-col md:flex-row items-center justify-between shadow-2xl max-w-4xl mx-auto mb-12">
            
            <div class="flex-1 w-full px-6 py-2 border-b md:border-b-0 md:border-r border-sipborder">
                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Fasilitas</label>
                <input type="text" placeholder="Cari gedung atau lab..." id="searchFacility" 
                    class="w-full bg-transparent border-none text-white focus:outline-none placeholder-gray-600 font-medium">
            </div>
            
            <div class="flex-1 w-full px-6 py-2 relative">
                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kategori</label>
                <select id="kategori" class="w-full bg-transparent border-none text-white focus:outline-none font-medium appearance-none cursor-pointer">
                    <option value="semua" class="bg-sipdark">Semua Kategori</option>
                    <option value="gsg" class="bg-sipdark">Gedung Serba Guna</option>
                    <option value="lab" class="bg-sipdark">Laboratorium</option>
                    <option value="kelas" class="bg-sipdark">Ruang Kelas</option>
                    <option value="rapat" class="bg-sipdark">Ruang Rapat</option>
                </select>
                <i class="fas fa-chevron-down absolute right-6 top-1/2 mt-1 text-xs text-gray-500 pointer-events-none"></i>
            </div>
            
            <div class="w-full md:w-auto mt-2 md:mt-0 pl-2">
                <button class="w-full md:w-auto bg-sipblue hover:bg-sipbluehover text-white px-8 py-3.5 rounded-full font-bold transition-all shadow-lg shadow-sipblue/30 flex items-center justify-center gap-2 active:scale-95">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/3">
                <div class="bg-sipdark border border-sipborder rounded-3xl p-6 shadow-xl h-[650px] flex flex-col">
                    <h4 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-building text-sipblue"></i> Daftar Fasilitas
                    </h4>
                    
                    <div class="flex-1 overflow-y-auto pr-3 space-y-3 [&::-webkit-scrollbar]:w-[6px] [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-sipborder [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-siptext">
                        
                        <?php 
                        if(mysqli_num_rows($result_fasilitas) > 0) {
                            $is_first = true; 
                            while($row = mysqli_fetch_assoc($result_fasilitas)) { 
                        ?>
                        
                        <div class="facility-card group flex items-center p-4 rounded-2xl border border-sipborder bg-sipbg hover:border-sipblue hover:bg-sipblue/5 cursor-pointer transition-all duration-300" 
                             data-id="<?php echo $row['id_fasilitas']; ?>"
                             data-nama="<?php echo strtolower($row['nama_fasilitas']); ?>"
                             data-kategori="<?php echo strtolower($row['kategori']); ?>">
                             
                            <div class="w-14 h-14 rounded-xl bg-sipblue/10 text-sipblue flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <i class="<?php echo $row['ikon']; ?> text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-white font-bold text-base mb-1 group-hover:text-sipblue transition-colors"><?php echo $row['nama_fasilitas']; ?></h5>
                                <p class="text-siptext text-sm font-medium"><i class="fas fa-users mr-1 opacity-70"></i> <?php echo $row['kapasitas']; ?> Orang</p>
                            </div>
                        </div>

                        <?php 
                                $is_first = false; 
                            } 
                        } else {
                            echo '<div class="text-center py-10 text-siptext"><i class="fas fa-box-open text-4xl mb-3 opacity-50"></i><p>Belum ada data fasilitas.</p></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/3">
                <div class="bg-sipdark border border-sipborder rounded-3xl p-8 shadow-xl h-full flex flex-col">
                    
                    <div class="flex justify-between items-center w-full mb-8">
                        <button id="prevMonth" class="w-12 h-12 flex items-center justify-center text-siptext hover:text-white hover:bg-sipborder rounded-full transition-all bg-sipbg border border-sipborder">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h3 id="calendarMonthYear" class="text-2xl font-extrabold text-white tracking-wide m-0">
                            Bulan Tahun
                        </h3>
                        <button id="nextMonth" class="w-12 h-12 flex items-center justify-center text-siptext hover:text-white hover:bg-sipborder rounded-full transition-all bg-sipbg border border-sipborder">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="flex justify-center gap-8 mb-8 border-b border-sipborder pb-6">
                        <div class="flex items-center gap-2 text-sm font-medium text-gray-300">
                            <span class="w-3 h-3 rounded-full bg-[#00AE1C] shadow-[0_0_8px_#00AE1C]"></span> Tersedia
                        </div>
                        <div class="flex items-center gap-2 text-sm font-medium text-gray-300">
                            <span class="w-3 h-3 rounded-full bg-sipred shadow-[0_0_8px_#DE2828]"></span> Penuh / Booking
                        </div>
                    </div>

                    <div class="grid grid-cols-7 gap-2 mb-2">
                        <?php 
                        $hari = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                        foreach($hari as $h) {
                            echo "<div class='text-center text-xs font-bold text-gray-500 uppercase tracking-widest py-2'>$h</div>";
                            }
                            ?>
                    </div>

                    <div class="grid grid-cols-7 gap-2 flex-1 content-start" id="calendarDays">
                        </div>

                    <div class="mt-8 pt-6 border-t border-sipborder flex justify-end">
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                            <a href="dashboard_admin.php" class="bg-sipred hover:bg-red-700 text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-sipred/30 flex items-center gap-2">
                                <i class="fas fa-edit"></i> Edit Jadwal
                            </a>
                        <?php else : 
                            $link_pinjam = isset($_SESSION['user_id']) ? 'dashboard_'. $_SESSION['role'] .'.php' : 'login.php';
                        ?>
                            <a href="<?php echo $link_pinjam; ?>" class="bg-[#00AE1C] hover:bg-green-700 text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-green-500/30 flex items-center gap-2">
                                <i class="fas fa-calendar-check"></i> Ajukan Peminjaman
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="assets/js/script-jadwal.js"></script>
</body>
</html>