document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.querySelector(".sidebar");
  const sidebarToggler = document.querySelector(".sidebar-toggler");
  const menuToggler = document.querySelector(".menu-toggler");
  const searchInput = document.getElementById("searchInput");
  const searchButton = document.getElementById("searchButton");
  const searchResults = document.getElementById("searchResults");
  const previousSearchResults = document.getElementById(
    "previousSearchResults"
  );

  const collapsedSidebarHeight = "56px";
  const fullSidebarHeight = "calc(100vh - 32px)";

  sidebarToggler.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
  });

  const toggleMenu = (isMenuAction) => {
    sidebar.style.height = isMenuAction
      ? `${sidebar.scrollHeight}px`
      : collapsedSidebarHeight;

    menuToggler.querySelector("span").innerHTML = isMenuAction
      ? "close"
      : "menu";
  };

  menuToggler.addEventListener("click", () => {
    toggleMenu(sidebar.classList.toggle("menu-active"));
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth >= 800) {
      sidebar.style.height = fullSidebarHeight;
    } else {
      sidebar.classList.remove("collapsed");
      toggleMenu(sidebar.classList.contains("menu-active"));
    }
  });

  const patients = [
    {
      id: 1,
      name: "John Doe",
      dob: "1980-01-01",
      lastVisit: "2023-05-15",
      age: 43,
      photo: "https://randomuser.me/api/portraits/men/1.jpg",
      bloodType: "A+",
      lastDiagnosis: "Common Cold",
    },
    {
      id: 2,
      name: "Jane Smith",
      dob: "1992-03-15",
      lastVisit: "2023-06-01",
      age: 31,
      photo: "https://randomuser.me/api/portraits/women/2.jpg",
      bloodType: "O-",
      lastDiagnosis: "Allergies",
    },
    {
      id: 3,
      name: "Alice Johnson",
      dob: "1975-07-22",
      lastVisit: "2023-05-30",
      age: 48,
      photo: "https://randomuser.me/api/portraits/women/3.jpg",
      bloodType: "B+",
      lastDiagnosis: "Hypertension",
    },
    {
      id: 4,
      name: "Bob Williams",
      dob: "1988-11-05",
      lastVisit: "2023-06-10",
      age: 35,
      photo: "https://randomuser.me/api/portraits/men/4.jpg",
      bloodType: "AB-",
      lastDiagnosis: "Sprained Ankle",
    },
    {
      id: 5,
      name: "Bhoomika Seth",
      dob: "2004-12-01",
      lastVisit: "2024-06-10",
      age: 19,
      photo: "bhoomika.jpg",
      bloodType: "AB-",
      lastDiagnosis: "Dementia",
    },
    {
      id: 6,
      name: "Bhavya Nigam",
      dob: "2004-12-01",
      lastVisit: "2024-06-10",
      age: 19,
      photo: "Nigam.jpeg",
      bloodType: "AB-",
      lastDiagnosis: "Dementia",
    },
    {
      id: 7,
      name: "Ayush Srivastava",
      dob: "2004-12-01",
      lastVisit: "2024-06-10",
      age: 19,
      photo: "Ayush.jpeg",
      bloodType: "AB-",
      lastDiagnosis: "Testicular Cancer",
    },
    {
      id: 8,
      name: "Devansh Awasthi",
      dob: "2024-01-01",
      lastVisit: "2023-12-31",
      age: 1,
      photo: "awasthi.jpeg",
      bloodType: "AB-",
      lastDiagnosis: "HIV",
    },
    {
      id: 21,
      name: "John Doe",
      dob: "1980-01-01",
      lastVisit: "2023-05-15",
      age: 43,
      photo: "https://randomuser.me/api/portraits/men/1.jpg",
      bloodType: "A+",
      lastDiagnosis: "Common Cold",
    },
  ];

  let previousSearches = [];

  searchButton.addEventListener("click", performSearch);
  searchInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      performSearch();
    }
  });

  function performSearch() {
    const searchTerm = searchInput.value.toLowerCase();
    const results = patients.filter((patient) => {
      const isNameMatch = patient.name.toLowerCase().includes(searchTerm);
      const isIdMatch = patient.id.toString() === searchTerm;
      return isNameMatch || isIdMatch;
    });
    displayResults(results);
    updatePreviousSearches(results);
  }

  function displayResults(results) {
    if (results.length === 0) {
      searchResults.innerHTML = "<p>No patients found.</p>";
      return;
    }

    let tableHTML = `
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Last Visit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
        `;

    results.forEach((patient) => {
      tableHTML += `
                <tr>
                    <td>${patient.name}</td>
                    <td>${patient.dob}</td>
                    <td>${patient.lastVisit}</td>
                    <td><button class="view-history-btn" onclick="viewHistory(${patient.id})">View History</button></td>
                </tr>
            `;
    });

    tableHTML += "</tbody></table>";
    searchResults.innerHTML = tableHTML;
  }

  function updatePreviousSearches(results) {
    results.forEach((patient) => {
      if (!previousSearches.some((p) => p.id === patient.id)) {
        previousSearches.unshift(patient);
        if (previousSearches.length > 8) {
          previousSearches.pop();
        }
      }
    });

    displayPreviousSearches();
  }

  function displayPreviousSearches() {
    previousSearchResults.innerHTML = "";
    previousSearches.forEach((patient) => {
      const patientCard = document.createElement("div");
      patientCard.className = "patient-card";
      patientCard.innerHTML = `
                <img src="${patient.photo}" alt="${patient.name}">
                <h3>${patient.name}</h3>
                <p>Age: ${patient.age}</p>
                <p>Blood Type: ${patient.bloodType}</p>
                <p>Last Diagnosis: ${patient.lastDiagnosis}</p>
            `;
      previousSearchResults.appendChild(patientCard);
    });
  }

  window.viewHistory = function (patientId) {
    window.open(
      `http://localhost/hospitalmanagementsystem/dashboard/staff/patient/view_prescriptions.php?patient_id=${patientId}`,
      "_blank"
    );
  };
});

/**
 *
 * @param {Date} date
 */

function formatTime(date) {
  const hours = date.getHours() % 24;
  const mins = date.getMinutes();

  return `${hours.toString().padStart(2, "0")}:${mins
    .toString()
    .padStart(2, "0")}`;
}

const timeElement = document.querySelector(".time");
const dateElement = document.querySelector(".date");

/**
 *
 * @param {Date} date
 */

function formatDate(date) {
  const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  const mon = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];

  return `${days[date.getDay()]} ${date.getDate()} ${mon[date.getMonth()]}`;
}

setInterval(() => {
  const now = new Date();

  timeElement.textContent = formatTime(now);
  dateElement.textContent = formatDate(now);
}, 200);
