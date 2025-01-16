<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0"
    />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  </head>
  <body>
    <aside class="sidebar">
      <header class="sidebar-header">
        <a href="#" class="header-logo">
          <img src="img/titleLogo.png" alt="Logo" />
        </a>

        <button class="toggler sidebar-toggler">
          <span class="material-symbols-rounded"> chevron_left </span>
        </button>
        <button class="toggler menu-toggler">
          <span class="material-symbols-rounded"> menu </span>
        </button>
      </header>

      <!-- <hr> -->
      <!-- <div class="line"></div> -->

      <nav class="sidebar-nav">
        <ul class="nav-list primary-nav">
          <li class="nav-item">
            <a
              href="http://localhost/hospitalmanagementsystem/dashboard/staff/dashboard.php"
              class="nav-link"
            >
              <span class="nav-icon material-symbols-rounded"> home </span>
              <span class="nav-label">Home</span>
            </a>
            <span class="nav-tooltip">Home</span>
          </li>
          <li class="nav-item">
            <a
              href="http://localhost/hospitalmanagementsystem/dashboard/staff/patient/index.html"
              class="nav-link"
            >
              <span class="material-symbols-rounded"> patient_list </span>
              <span class="nav-label">Patient</span>
            </a>
            <span class="nav-tooltip">Patient</span>
          </li>
          <li class="nav-item">
            <a
              href="http://localhost/hospitalmanagementsystem/dashboard/staff/prescription/prescription.html"
              class="nav-link"
            >
              <span class="material-symbols-rounded"> prescriptions </span>
              <span class="nav-label">Prescription</span>
            </a>
            <span class="nav-tooltip">Prescription</span>
          </li>
          <li class="nav-item">
            <a
              href="http://localhost/hospitalmanagementsystem/dashboard/staff/appointment/appointment.php"
              class="nav-link"
            >
              <span class="material-symbols-rounded"> event_upcoming </span>
              <span class="nav-label">Appointment List</span>
            </a>
            <span class="nav-tooltip">Appointment List</span>
          </li>
        </ul>

        <ul class="nav-list secondary-nav">
          <div class="line"></div>
          <li class="nav-item">
            <a href="http://localhost/hospitalmanagementsystem/dashboard/staff/prescription/prescription.html" class="nav-link">
              <span class="material-symbols-rounded"> add </span>
              <span class="nav-label">New Patient</span>
            </a>
            <span class="nav-tooltip">New Patient</span>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <span class="nav-icon material-symbols-rounded"> logout </span>
              <span class="nav-label">Logout </span>
            </a>
            <span class="nav-tooltip">Logout </span>
          </li>
        </ul>
      </nav>
    </aside>

    <div class="section">
      <div class="top">
        <p class="portal">
          <span class="material-symbols-rounded"> person </span>Staff
        </p>
        <div class="datetime">
          <div class="date"></div>
          <div class="time"></div>
        </div>
      </div>

      <div class="main">
        <div class="card">
          <h2>Total Patients</h2>
          <p>Monthly Data</p>
          <div class="pulse"></div>
          <div class="area-chart">
            <div class="grid"></div>
          </div>
        </div>

        <div class="cardBox">
          <div class="cardData">
            <div class="">
              <div class="numbers">1,503</div>
              <div class="cardName">Monthly Patients</div>
            </div>
            <div class="icon">
              <span class="material-symbols-rounded"> recent_patient </span>
            </div>
          </div>
          <div class="cardData">
            <div>
              <div class="numbers">421</div>
              <div class="cardName">Daily Appointments</div>
            </div>
            <div class="icon">
              <span class="material-symbols-rounded"> today </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="side">
      <div class="calendar-container">
        <!-- Header -->
        <div class="calendar-header">
          <h2>
            <span class="material-symbols-rounded">schedule</span> Schedule
          </h2>
          <a href="http://localhost/hospitalmanagementsystem/dashboard/staff/appointment/appointment.php">
            <button>See all</button>
          </a>
        </div>

        <!-- Date Picker -->
        <!-- <div class="date-picker">
          <button id="date-10">10 Dec</button>
          <button id="date-11">11 Dec</button>
          <button id="date-12">12 Dec</button>
          <button id="date-13">13 Dec</button>
          <button id="date-14">14 Dec</button>
        </div> -->

        <div class="date-picker">
          <a href="?time_slot=all" class="date-btn">All</a>
          <a href="?time_slot=morning" class="date-btn">Morning</a>
          <a href="?time_slot=noon" class="date-btn">Noon</a>
          <a href="?time_slot=evening" class="date-btn">Evening</a>
        </div>


        <!-- Appointments Section -->
        <div class="appointment-section">
          <h3>Appointments</h3>
          <div class="appointment-list">
            <?php include 'fetch_appointments.php'; ?>
            <!-- <div class="appointment meeting">
              <div class="patient_name">Patient Name 1</div>
              <div class="time">8:00 - 8:45 AM</div>
              <div class="details">
                Meeting with James Brown<br /><em>Marketing</em>
              </div>
            </div>

            <div class="appointment event">
              <div class="patient_name">Patient Name 2</div>
              <div class="time">9:00 - 9:45 AM</div>
              <div class="details">
                Meeting with Laura Perez<br /><em>Product Manager</em>
              </div>
            </div>

            <div class="appointment holiday">
              <div class="patient_name">Patient Name 3</div>
              <div class="time">10:00 - 11:00 AM</div>
              <div class="details">
                Meeting with Arthur Taylor<br /><em>Partnership</em>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
