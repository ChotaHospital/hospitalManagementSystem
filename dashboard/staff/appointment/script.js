const selectButton = document.getElementById("select-button");
const cards = document.querySelectorAll(".appointment-card");
const selectedCountEl = document.getElementById("selected-count");

// Toggle selection mode
selectButton.addEventListener("click", async function () {
  const isSelecting = selectButton.classList.toggle("active");
  if (isSelecting) {
    selectButton.textContent = "Submit Selection";
    cards.forEach((card) => {
      card.classList.add("shrinked");
      card.querySelector(".select-checkbox-wrapper").style.display = "block";
    });
  } else {
    const selectedIds = [];
    let selectedCount = 0;

    // Collect selected IDs
    cards.forEach((card) => {
      const checkbox = card.querySelector(".select-checkbox");
      if (checkbox.checked) {
        selectedIds.push(card.dataset.id); // Use the card's data-id attribute
      }
    });

    if (selectedIds.length > 0) {
      try {
        const response = await fetch("delete_appointments.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ ids: selectedIds }), // Send IDs as JSON object
        });

        const result = await response.json();
        if (result.success) {
          // Remove selected cards from the UI
          selectedIds.forEach((id) => {
            const card = document.querySelector(
              `.appointment-card[data-id="${id}"]`
            );
            if (card) card.remove();
          });

          console.log("Selected IDs:", selectedIds);
          alert(result.message);
        } else {
          alert(`Error: ${result.message}`);
        }
      } catch (error) {
        console.error("Error:", error);
        alert("An error occurred while deleting appointments.");
      }
    } else {
      alert("No appointments selected.");
    }

    // Reset selection mode
    cards.forEach((card) => {
      card.classList.remove("shrinked");
      card.querySelector(".select-checkbox-wrapper").style.display = "none";
    });
    selectButton.textContent = "Select Completed/Canceled";
    selectedCountEl.textContent = `Selected Items: 0`;
  }
});

// Update selected count dynamically
cards.forEach((card) => {
  const checkbox = card.querySelector(".select-checkbox");
  checkbox.addEventListener("change", function () {
    const selectedCount = [...cards].filter(
      (card) => card.querySelector(".select-checkbox").checked
    ).length;
    selectedCountEl.textContent = `Selected Items: ${selectedCount}`;
  });
});

// Toggle appointment details
document.querySelectorAll(".toggle-details").forEach((button) => {
  button.addEventListener("click", function () {
    const card = this.closest(".appointment-card");
    const details = card.querySelector(".card-details");
    details.style.display =
      details.style.display === "block" ? "none" : "block";
    this.textContent =
      details.style.display === "block" ? "Hide Details" : "View Details";
  });
});

// Search functionality
document.getElementById("search-bar").addEventListener("input", function () {
  const searchQuery = this.value.toLowerCase(); // Convert to lowercase for case-insensitive matching
  const cards = document.querySelectorAll(".appointment-card"); // Get all cards

  cards.forEach((card) => {
    const name = card
      .querySelector(".patient-info h4")
      .textContent.toLowerCase(); // Get the patient's name
    const isMatch = name.includes(searchQuery); // Check if the name matches the search query
    card.style.display = isMatch ? "block" : "none"; // Toggle visibility based on match
  });
});
