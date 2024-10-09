<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Tamu</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('admin.header')
    <style>
        .calendar-container {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            margin: 0 80px;
        }

        #calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .calendar-header {
            background-color: #06BBCC;
            color: white;
            font-weight: bold;
            padding: 10px 0;
            text-align: center;
        }

        .calendar-day {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px;
    text-align: center;
    height: 150px; /* Tinggi kolom lebih besar */
    transition: background-color 0.2s;
}

        .calendar-day:hover {
            background-color: #e9ecef;
        }

        .text-calendar {
            text-align: center;
            margin: 40px 0 20px 0;
            font-size: 1.5em;
            color: #333;
        }

        .meeting {
            background-color: #dff0d8;
            padding: 2px;
            margin-top: 2px;
        }

        .more-link {
            cursor: pointer;
            color: #06BBCC;
            font-weight: bold;
            margin-top: 5px;
        }

        .additional-meetings {
            display: none; /* Awalnya sembunyikan */
            margin-top: 5px;
        }
        .pagination {
    display: flex;
    justify-content: right; /* Memusatkan elemen */
    align-items: center; /* Menjaga elemen agar sejajar */
    margin: 20px 0;
    margin-right: 80px;
}

.btn-cal {
    padding: 10px 15px;
    border: none;
    background-color: #06BBCC;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    margin: 0 10px; /* Jarak antar tombol */
    transition: background-color 0.3s; /* Transisi halus saat hover */
}
.service-header {
            max-width: 800px; /* Limit the width */
            margin: auto; /* Center the header */
            margin-top: 50px; /* Increased space above the header */
        }

       
     .light-background {
    background-color: #f5fbff; 
        }
        
    </style>
</head>
<body>
@include('admin.navbar')

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="containner">
        <h1>Jadwal Tamu</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="current">Jadwal Tamu</li>
          </ol>
        </nav>
      </div>
      </div>
      
<div class="text-center service-header wow fadeInUp" data-wow-delay="0.2s">
<h6 class="section-title bg-white text-center text-primary px-3">Jadwal Tamu</h6>
        <h1 class="display-5 mb-3" style="font-size: 1.2rem; color: gray;">Jadwal Tamu yang datang berkunjung</h1>
</div>
<h2 class="text-calendar" id="monthYear"></h2>
<div id="calendar" class="calendar-container"></div>
<div class="pagination">
        <button class="btn-cal" id="prevMonth">Sebelumnya</button>
        <button class="btn-cal" id="nextMonth">Berikutnya</button>
</div>
<script>
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    async function fetchCalendarData(year, month) {
            try {
                const response = await fetch(`/get-calendar-data/${year}/${month}`);
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const guests = await response.json();
                console.log("Fetched Guests:", guests);
                return guests;
            } catch (error) {
                console.error('Error fetching data:', error);
                return []; // Return an empty array on error
            }
        }

    async function generateCalendar(month, year) {
        const calendar = document.getElementById('calendar');
        calendar.innerHTML = '';

        const guests = await fetchCalendarData(year, month);
        const monthYear = document.getElementById('monthYear');
        monthYear.textContent = new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' });

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Header hari
        const daysOfWeek = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        daysOfWeek.forEach(day => {
            const header = document.createElement('div');
            header.className = 'calendar-header';
            header.textContent = day;
            calendar.appendChild(header);
        });

        // Hari kosong
        for (let i = 0; i < firstDay; i++) {
            const blankDay = document.createElement('div');
            blankDay.className = 'calendar-day';
            calendar.appendChild(blankDay);
        }

        // Hari dalam bulan
        for (let day = 1; day <= daysInMonth; day++) {
            const calendarDay = document.createElement('div');
            calendarDay.className = 'calendar-day';
            calendarDay.innerHTML = `${day}`;

            // Cek tamu pada hari ini
            const dayGuests = guests.filter(tamu => {
        const guestDate = new Date(tamu.created_at);
        return guestDate.getDate() === day && guestDate.getMonth() === month; // Include month check
    });
    
    const displayedGuests = dayGuests.slice(0, 2); // Tampilkan 2 tamu pertama
    displayedGuests.forEach(tamu => {
        const guestElement = document.createElement('div');
        guestElement.className = 'meeting';
        guestElement.innerHTML = `<a href="#" onclick="handleGuestClick('${tamu.opd.dinas}', '${tamu.dinas}'); return false;">${tamu.opd.dinas}</a>`;
        calendarDay.appendChild(guestElement);
    });

            if (dayGuests.length > 2) {
                const moreLink = document.createElement('div');
                moreLink.className = 'more-link';
                moreLink.innerHTML = `+${dayGuests.length - 2} more`;
                
                  moreLink.onclick = () => {
                    const guestList = dayGuests.map(tamu => {
                    return `<a href="#" onclick="handleGuestClick('${tamu.opd.dinas}', '${tamu.dinas}'); return false;">${tamu.opd.dinas}</a>`;
                }).join('<br>');
   Swal.fire({
                    title: `Tamu untuk ${day} ${month + 1}/${year}`,
                    html: guestList || 'Tidak ada tamu untuk hari ini.',
                    confirmButtonText: 'OK'
                });
            };

                calendarDay.appendChild(moreLink);
               
            }
            calendar.appendChild(calendarDay);
        }
    }
    
    function handleGuestClick(opdId, dinas) {
    Swal.fire({
        title: 'Informasi Tamu',
        html: `<strong>Asal Dinas :</strong> <span style="margin-bottom: 10px; display: block;">${dinas}</span>
            <strong>Tujuan Dinas :</strong> <span style="margin-bottom: 10px; display: block;">${opdId}</span>`,
        confirmButtonText: 'OK'
    });
    
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('prevMonth').addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentMonth, currentYear);
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentMonth, currentYear);
        });
    });
    // Generate initial calendar
    generateCalendar(currentMonth, currentYear);
</script>
@include('admin.footer')
</body>
</html>
