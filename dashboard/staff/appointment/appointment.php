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
    <link rel="stylesheet" href="styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  </head>
  <body>
    <aside class="sidebar">
      <header class="sidebar-header">
        <a href="#" class="header-logo">
          <img src="../img/titleLogo.png" alt="Logo" />
        </a>

        <button class="toggler sidebar-toggler">
          <span class="material-symbols-rounded"> chevron_left </span>
        </button>
        <button class="toggler menu-toggler">
          <span class="material-symbols-rounded"> menu </span>
        </button>
      </header>

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
        <!-- Sticky Header -->
        <div class="header">
          <h1>Today's Appointments</h1>
          <div class="search-main">
            <input type="text" id="search-bar" placeholder="Search by patient name...">
          </div>
          <button id="select-button">Select Completed/Canceled</button>
          <p id="selected-count">Selected Items: 0</p>
        </div>

        <!-- Scrollable Appointment List -->
        <div class="appointment-list">
          <?php include 'fetch_appointments.php'; ?>
        </div>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>