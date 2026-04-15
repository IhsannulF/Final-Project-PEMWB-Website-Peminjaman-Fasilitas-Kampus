document.addEventListener("DOMContentLoaded", function () {
    const calendarDays = document.getElementById("calendarDays");
    const monthYearText = document.getElementById("calendarMonthYear");
    const prevBtn = document.getElementById("prevMonth");
    const nextBtn = document.getElementById("nextMonth");
    const facilityCards = document.querySelectorAll(".facility-card");
  
    let date = new Date();
    let currentMonth = date.getMonth();
    let currentYear = date.getFullYear();
    
    // Ambil ID fasilitas pertama saat halaman dimuat
    let currentFacilityId = null;
    if (facilityCards.length > 0) {
        currentFacilityId = facilityCards[0].getAttribute("data-id");
        facilityCards[0].classList.add("border-sipblue", "bg-sipblue/5");
    }
  
    const monthNames = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember",
    ];
  
    // Fungsi Mengambil Data dari Database via API
    function fetchAndRenderCalendar() {
      if (!currentFacilityId) return;

      const targetBulan = currentMonth + 1;
      const cacheBuster = new Date().getTime(); // Anti-Cache
      const apiUrl = `proses/api_jadwal.php?id_fasilitas=${currentFacilityId}&bulan=${targetBulan}&tahun=${currentYear}&_t=${cacheBuster}`;
  
      fetch(apiUrl)
        .then((response) => response.json())
        .then((data) => {
          // JURUS KUNCI: Paksa pastikan data yang diterima adalah Array berisi Angka murni
          let bookedDates = [];
          if (Array.isArray(data)) {
              bookedDates = data.map(Number); 
          }
          
          // Tampilkan log di Console Browser untuk kita pantau
          console.log(`Cek Jadwal -> Fasilitas ID: ${currentFacilityId} | Bulan: ${targetBulan} | Tanggal Merah:`, bookedDates);
          
          renderCalendar(bookedDates);
        })
        .catch((error) => {
            console.error("Gagal mengambil data jadwal:", error);
            renderCalendar([]); 
        });
    }
  
    // Fungsi Menggambar Kalender
    function renderCalendar(bookedDates) {
      calendarDays.innerHTML = "";
      monthYearText.innerText = `${monthNames[currentMonth]} ${currentYear}`;
  
      let firstDay = new Date(currentYear, currentMonth, 1).getDay();
      firstDay = firstDay === 0 ? 6 : firstDay - 1;
  
      let daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
  
      // Bikin kotak kosong untuk awal bulan
      for (let i = 0; i < firstDay; i++) {
        const emptyDiv = document.createElement("div");
        emptyDiv.classList.add("empty");
        calendarDays.appendChild(emptyDiv);
      }
  
      // Bikin kotak tanggal
      for (let day = 1; day <= daysInMonth; day++) {
        const dayDiv = document.createElement("div");
        dayDiv.innerText = day;
        
        // Ubah day menjadi angka mutlak
        const currentDayNum = parseInt(day, 10);

        // LOGIKA PENENTU WARNA
        if (bookedDates.includes(currentDayNum)) {
          dayDiv.classList.add("booked"); // Class ini akan diwarnai merah oleh Tailwind
          dayDiv.title = "Fasilitas Penuh / Diblokir";
        } else {
          dayDiv.classList.add("available"); // Class ini akan diwarnai hijau oleh Tailwind
        }
  
        // Event Listener untuk klik
        dayDiv.addEventListener('click', function() {
            if (this.classList.contains('booked')) {
                alert("Maaf, fasilitas pada tanggal ini sudah penuh/diblokir oleh Admin.");
                return; 
            }
        });
  
        calendarDays.appendChild(dayDiv);
      }
    }
  
    // Inisialisasi awal
    fetchAndRenderCalendar();
  
    // Tombol Navigasi Bulan
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
  
    // Efek Klik Fasilitas di Kiri
    facilityCards.forEach((card) => {
      card.addEventListener("click", function () {
        facilityCards.forEach((c) => c.classList.remove("border-sipblue", "bg-sipblue/5"));
        this.classList.add("border-sipblue", "bg-sipblue/5");
  
        currentFacilityId = this.getAttribute("data-id");
        fetchAndRenderCalendar();
      });
    });
  
    // Fitur Pencarian Fasilitas
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