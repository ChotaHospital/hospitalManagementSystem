const sidebar = document.querySelector(".sidebar");
const sidebarToggler = document.querySelector(".sidebar-toggler");
const menuToggler = document.querySelector(".menu-toggler");
const main = document.querySelector(".section");

const collapsedSidebarHeight = "56px";
const fullSidebarHeight = "calc(100vh - 32px)";

sidebarToggler.addEventListener("click", () => {
  sidebar.classList.toggle("collapsed");
  main.classList.toggle("active");
});

const toggleMenu = (isMenuAction) => {
  sidebar.style.height = isMenuAction
    ? `${sidebar.scrollHeight}px`
    : collapsedSidebarHeight;

  menuToggler.querySelector("span").innerHTML = isMenuAction ? "close" : "menu";
};

menuToggler.addEventListener("click", () => {
  toggleMenu(sidebar.classList.toggle("menu-active"));
});

window.addEventListener("resize", () => {
  if (window.innerHeight >= 800) {
    sidebar.style.height = fullSidebarHeight;
  } else {
    sidebar.classList.remove("collapsed");
    // sidebar.style.height = 'auto';
    toggleMenu(sidebar.classList.contains("menu-active"));
  }
});

const timeElement = document.querySelector(".time");
const dateElement = document.querySelector(".date");

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
//

//

document.addEventListener("DOMContentLoaded", () => {
  const addMedicationButton = document.getElementById("add-medication");
  const medicationSection = document.querySelector(".medications");
  let medicationCount = 1; // Start from the second medication row, as the first one is already present.

  addMedicationButton.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent form submission when the button is clicked

    // Increment the medication count
    medicationCount++;

    // Create a new medication row
    const newRow = document.createElement("div");
    newRow.classList.add("medication-row");

    // Add input fields for the new medication row
    newRow.innerHTML = `
      <label for="drug-${medicationCount}">Drug:</label>
      <textarea type="text" id="drug-${medicationCount}" name="medications[${
      medicationCount - 1
    }][name]" ></textarea>
      <label for="dosage-${medicationCount}">Dosage (Per Day):</label>
      <textarea  id="dosage-${medicationCount}" name="medications[${
      medicationCount - 1
    }][dosage]" ></textarea>
      <label for="remark-${medicationCount}">Remark:</label>
      <textarea type="text" id="remark-${medicationCount}" name="medications[${
      medicationCount - 1
    }][remark]"  ></textarea>
      <button class="remove-medication" aria-label="Remove this medication">-</button>
    `;

    // Append the new row to the medications section
    medicationSection.appendChild(newRow);

    // Add event listener to the remove button
    const removeButton = newRow.querySelector(".remove-medication");
    removeButton.addEventListener("click", (e) => {
      e.preventDefault();
      newRow.remove();
    });
  });
});

// Disable future dates
var today = new Date().toISOString().split("T")[0];
document.getElementById("dob").setAttribute("max", today);

// Disable past dates
var today = new Date().toISOString().split("T")[0];
document.getElementById("followUp").setAttribute("min", today);

document.querySelectorAll('.medication-row input').forEach(input => {
  input.addEventListener('keydown', event => {
    if (event.key === 'Enter' && event.shiftKey) {
      // Prevent the default action
      event.preventDefault();

      // Insert a newline character into the input field
      const cursorPosition = input.selectionStart;
      input.value =
        input.value.substring(0, cursorPosition) +
        '\n' +
        input.value.substring(cursorPosition);

      // Move the cursor to after the newline
      input.selectionStart = input.selectionEnd = cursorPosition + 1;
    }
  });
});