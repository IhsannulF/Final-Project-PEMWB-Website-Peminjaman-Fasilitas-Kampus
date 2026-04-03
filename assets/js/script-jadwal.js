document.addEventListener("DOMContentLoaded", function () {
  const calendarDays = document.getElementById("calendarDays");
  const monthYearText = document.getElementById("calendarMonthYear");
  const prevBtn = document.getElementById("prevMonth");
  const nextBtn = document.getElementById("nextMonth");

  let date = new Date();
  let currentMonth = date.getMonth();
  let currentYear = date.getFullYear();
  let currentFacilityId = 1; // Default awal melihat fasilitas ID 1 (GSG)

  const monthNames = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];

  // Fungsi Mengambil Data dari Database via API
  function fetchAndRenderCalendar() {
    // Bulan di JS mulai dari 0, tapi di PHP (database) mulai dari 1. Jadi kita + 1
    const targetBulan = currentMonth + 1;

    // Panggil API PHP kita
    fetch(
      `proses/api_jadwal.php?id_fasilitas=${currentFacilityId}&bulan=${targetBulan}&tahun=${currentYear}`,
    )
      .then((response) => response.json())
      .then((bookedDates) => {
        // Setelah data dari database didapat, render kalendernya
        renderCalendar(bookedDates);
      })
      .catch((error) => console.error("Error fetching data:", error));
  }

  // Fungsi Menggambar Kalender
  function renderCalendar(bookedDates) {
    calendarDays.innerHTML = "";
    monthYearText.innerText = `${monthNames[currentMonth]} ${currentYear}`;

    let firstDay = new Date(currentYear, currentMonth, 1).getDay();
    firstDay = firstDay === 0 ? 6 : firstDay - 1;

    let daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
      const emptyDiv = document.createElement("div");
      emptyDiv.classList.add("cal-day", "empty");
      calendarDays.appendChild(emptyDiv);
    }

    for (let day = 1; day <= daysInMonth; day++) {
      const dayDiv = document.createElement("div");
      dayDiv.classList.add("cal-day");
      dayDiv.innerText = day;

      // CEK DATABASE: Jika tanggal ini ada di dalam data yang dibooking, MERAHKAN!
      if (bookedDates.includes(day)) {
        dayDiv.classList.add("booked");
        dayDiv.title = "Fasilitas tidak tersedia";
      }

      calendarDays.appendChild(dayDiv);
    }
  }

  // Panggil saat halaman pertama dibuka
  fetchAndRenderCalendar();

  // Event Klik Mundur/Maju Bulan
  prevBtn.addEventListener("click", () => {
    currentMonth--;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    fetchAndRenderCalendar(); // Ambil data ulang
  });

  nextBtn.addEventListener("click", () => {
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    fetchAndRenderCalendar(); // Ambil data ulang
  });

  // --- EFEK KLIK DAFTAR FASILITAS (KIRI) ---
  // --- EFEK KLIK DAFTAR FASILITAS (KIRI) ---
    const facilityCards = document.querySelectorAll(".facility-card");
    facilityCards.forEach(card => {
        card.addEventListener("click", function() {
            // Hapus class active dari semua kartu
            facilityCards.forEach(c => c.classList.remove("active"));
            
            // Tambahkan class active ke kartu yang diklik
            this.classList.add("active");
            
            // Tangkap ID fasilitas dari atribut data-id
            currentFacilityId = this.getAttribute("data-id");
            
            // Tampilkan di Console Browser untuk memastikan ID-nya benar
            console.log("Memuat data untuk Fasilitas ID:", currentFacilityId);
            
            // Load ulang kalendernya!
            fetchAndRenderCalendar(); 
        });
    });
});
