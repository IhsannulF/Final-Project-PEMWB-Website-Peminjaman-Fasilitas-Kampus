document.addEventListener("DOMContentLoaded", function () {
    const calendarDays = document.getElementById("calendarDays");
    const monthYearText = document.getElementById("calendarMonthYear");
    const prevBtn = document.getElementById("prevMonth");
    const nextBtn = document.getElementById("nextMonth");
    const facilityCards = document.querySelectorAll(".facility-card");
  
    let date = new Date();
    let currentMonth = date.getMonth();
    let currentYear = date.getFullYear();
    
    // Inisialisasi awal: Ambil ID dari fasilitas paling atas
    let currentFacilityId = null;
    if (facilityCards.length > 0) {
        currentFacilityId = facilityCards[0].getAttribute("data-id");
        // Pastikan fasilitas pertama berwarna biru saat awal dimuat
        facilityCards[0].classList.add("border-sipblue", "bg-sipblue/5", "active");
    }
  
    const monthNames = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember",
    ];
  
    function fetchAndRenderCalendar() {
      if (!currentFacilityId) return;

      const targetBulan = currentMonth + 1;
      const cacheBuster = new Date().getTime(); 
      const apiUrl = `proses/api_jadwal.php?id_fasilitas=${currentFacilityId}&bulan=${targetBulan}&tahun=${currentYear}&_t=${cacheBuster}`;
  
      fetch(apiUrl)
        .then((response) => response.json())
        .then((data) => {
          let bookedDates = [];
          if (Array.isArray(data)) {
              bookedDates = data.map(Number); 
          }
          renderCalendar(bookedDates);
        })
        .catch((error) => {
            console.error("Gagal mengambil data jadwal:", error);
            renderCalendar([]); 
        });
    }
  
    function renderCalendar(bookedDates) {
      calendarDays.innerHTML = "";
      monthYearText.innerText = `${monthNames[currentMonth]} ${currentYear}`;
  
      let firstDay = new Date(currentYear, currentMonth, 1).getDay();
      firstDay = firstDay === 0 ? 6 : firstDay - 1;
  
      let daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
  
      for (let i = 0; i < firstDay; i++) {
        const emptyDiv = document.createElement("div");
        emptyDiv.classList.add("empty");
        calendarDays.appendChild(emptyDiv);
      }
  
      for (let day = 1; day <= daysInMonth; day++) {
        const dayDiv = document.createElement("div");
        dayDiv.innerText = day;
        
        const currentDayNum = parseInt(day, 10);

        if (bookedDates.includes(currentDayNum)) {
          dayDiv.classList.add("booked");
          dayDiv.title = "Fasilitas Penuh / Diblokir";
        } else {
          dayDiv.classList.add("available"); 
        }
  
        dayDiv.addEventListener('click', function() {
            if (this.classList.contains('booked')) {
                alert("Maaf, fasilitas pada tanggal ini sudah penuh/diblokir oleh Admin.");
            }
        });
  
        calendarDays.appendChild(dayDiv);
      }
    }
  
    fetchAndRenderCalendar();
  
    prevBtn.addEventListener("click", () => {
      currentMonth--;
      if (currentMonth < 0) { currentMonth = 11; currentYear--; }
      fetchAndRenderCalendar(); 
    });
  
    nextBtn.addEventListener("click", () => {
      currentMonth++;
      if (currentMonth > 11) { currentMonth = 0; currentYear++; }
      fetchAndRenderCalendar(); 
    });
  
    // --- PERBAIKAN LOGIKA KLIK KARTU FASILITAS ---
    facilityCards.forEach((card) => {
      card.addEventListener("click", function () {
        
        // 1. Hapus SEMUA indikator aktif dari SEMUA kartu
        facilityCards.forEach((c) => {
            c.classList.remove("border-sipblue", "bg-sipblue/5", "active");
        });
        
        // 2. Beri indikator aktif HANYA pada kartu yang baru saja diklik
        this.classList.add("border-sipblue", "bg-sipblue/5", "active");
  
        // 3. Ganti ID fasilitas dan muat ulang kalender
        currentFacilityId = this.getAttribute("data-id");
        fetchAndRenderCalendar();
      });
    });
  
    // --- PENCARIAN FASILITAS ---
    const searchInput = document.getElementById("searchFacility");
    const kategoriSelect = document.getElementById("kategori");
    const btnSearch = document.querySelector(".btn-search-airbnb");
  
    function filterFasilitas() {
      const keyword = searchInput.value.toLowerCase();
      const kategori = kategoriSelect.value.toLowerCase();
      let fasilitasPertama = null;
  
      facilityCards.forEach((card) => {
        const namaFasilitas = card.getAttribute("data-nama");
        const kategoriFasilitas = card.getAttribute("data-kategori");
        const cocokNama = namaFasilitas.includes(keyword);
        const cocokKategori = kategori === "semua" || kategoriFasilitas === kategori;
  
        if (cocokNama && cocokKategori) {
          card.style.display = "flex"; 
          if (!fasilitasPertama) fasilitasPertama = card;
        } else {
          card.style.display = "none"; 
        }
      });
  
      if (fasilitasPertama && !fasilitasPertama.classList.contains("border-sipblue")) {
        fasilitasPertama.click();
      }
    }
  
    searchInput.addEventListener("keyup", filterFasilitas);
    kategoriSelect.addEventListener("change", filterFasilitas);
    if (btnSearch) {
      btnSearch.addEventListener("click", (e) => { e.preventDefault(); filterFasilitas(); });
    }
});