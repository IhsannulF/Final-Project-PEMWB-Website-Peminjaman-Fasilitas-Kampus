document.addEventListener("DOMContentLoaded", function() {
    
    const calendarDays = document.getElementById("calendarDays");
    
    // Fungsi untuk merender kalender (Mockup Data)
    function renderCalendar() {
        calendarDays.innerHTML = "";
        
        // Misal kita asumsikan bulan dimulai di hari Rabu (Kosongkan 2 hari pertama untuk Sen & Sel)
        for (let i = 0; i < 2; i++) {
            const emptyDiv = document.createElement("div");
            emptyDiv.classList.add("cal-day", "empty");
            calendarDays.appendChild(emptyDiv);
        }

        // Generate tanggal 1 sampai 30 (Asumsi Bulan April)
        for (let day = 1; day <= 30; day++) {
            const dayDiv = document.createElement("div");
            dayDiv.classList.add("cal-day");
            dayDiv.innerText = day;

            // SIMULASI TANGGAL YANG DIBOOKING (Tanggal merah)
            // Misalnya tanggal 12, 13, 14, dan 25 sudah penuh dipesan
            if (day === 12 || day === 13 || day === 14 || day === 25) {
                dayDiv.classList.add("booked");
                dayDiv.title = "Fasilitas sudah dibooking pada tanggal ini";
            }

            calendarDays.appendChild(dayDiv);
        }
    }

    renderCalendar();

    // Efek saat list fasilitas diklik
    const facilityCards = document.querySelectorAll(".facility-card");
    facilityCards.forEach(card => {
        card.addEventListener("click", function() {
            // Hapus class active dari semua
            facilityCards.forEach(c => c.classList.remove("active"));
            // Tambahkan ke yang diklik
            this.classList.add("active");
            
            // Di sini nanti Anda bisa memanggil AJAX untuk merender ulang tanggal kalender
            // berdasarkan fasilitas yang dipilih dari Database.
        });
    });

});