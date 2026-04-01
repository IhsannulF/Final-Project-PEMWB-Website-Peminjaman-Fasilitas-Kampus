document.addEventListener("DOMContentLoaded", function () {
  // ==========================================
  // 1. FITUR TOGGLE PASSWORD (LIHAT/SEMBUNYIKAN)
  // ==========================================
  const togglePassword = document.querySelector(".toggle-password");
  const passwordInput = document.getElementById("password");

  if (togglePassword && passwordInput) {
    togglePassword.addEventListener("click", function () {
      // Ubah tipe input dari password ke text, atau sebaliknya
      const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      // Ubah ikon Font Awesome (Mata terbuka / Mata dicoret)
      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");

      // Berikan warna aksen biru saat password terlihat
      if (type === "text") {
        this.style.color = "#009EF7"; // Warna --color-blue-darken
      } else {
        this.style.color = ""; // Kembali ke warna abu-abu (slate) bawaan CSS
      }
    });
  }

  // ==========================================
  // 2. EFEK LOADING SAAT TOMBOL SUBMIT DITEKAN
  // ==========================================
  const loginForm = document.querySelector("form");
  const submitBtn = document.querySelector(".btn-primary");

  if (loginForm && submitBtn) {
    loginForm.addEventListener("submit", function () {
      // Ubah teks dan tambahkan ikon spinner berputar saat form dikirim
      submitBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin"></i> Memproses...';

      // Buat tombol sedikit transparan dan kursor tidak bisa diklik dua kali
      submitBtn.style.opacity = "0.8";
      submitBtn.style.cursor = "not-allowed";

      // Catatan: Tombol tidak kita 'disabled' melalui JS agar data tetap terkirim ke PHP
    });
  }
});
