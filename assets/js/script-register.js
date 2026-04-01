document.addEventListener("DOMContentLoaded", function () {
  // 1. Logika untuk icon mata pada password
  const togglePassword = document.querySelector(".toggle-password");
  const passwordInput = document.getElementById("password");

  if (togglePassword && passwordInput) {
    togglePassword.addEventListener("click", function () {
      const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");

      if (type === "text") {
        this.style.color = "#009EF7";
      } else {
        this.style.color = "";
      }
    });
  }

  // 2. Efek Loading saat Register diklik
  const registerForm = document.querySelector(".register-form");
  const submitBtn = document.querySelector(".btn-primary");

  if (registerForm && submitBtn) {
    registerForm.addEventListener("submit", function () {
      submitBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin"></i> Memproses...';
      submitBtn.style.opacity = "0.8";
      submitBtn.style.cursor = "not-allowed";
    });
  }
});


