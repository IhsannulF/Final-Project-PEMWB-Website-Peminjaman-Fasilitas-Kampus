<?php
session_start();

// Menghapus semua data session yang tersimpan
session_unset();

// Menghancurkan session agar benar-benar hilang dari server
session_destroy();

// Mengarahkan pengguna kembali ke Landing Page (index.php)
header("Location: ../index.php");
exit();
?>     