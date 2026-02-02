// Modal functionality for confirmations
function openDeleteModal(itemId, itemName) {
  document.getElementById("modalDeleteId").value = itemId;
  document.getElementById("modalItemName").textContent = itemName;
  document.getElementById("deleteModal").style.display = "flex";
}

function closeDeleteModal() {
  document.getElementById("deleteModal").style.display = "none";
}

function confirmDelete() {
  const itemId = document.getElementById("modalDeleteId").value;
  window.location.href = `delete.php?id=${itemId}`;
}

// Close modal when clicking outside
window.addEventListener("click", function (event) {
  const modal = document.getElementById("deleteModal");
  if (event.target === modal) {
    closeDeleteModal();
  }
});

// Close modal on Escape key
window.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    closeDeleteModal();
  }
});

// Order details toggle functionality
function toggleOrderDetails(element) {
  const orderRow = element.closest(".order-row");
  const details = orderRow.querySelector(".order-details");
  const icon = element.querySelector(".expand-icon");

  orderRow.classList.toggle("expanded");

  if (orderRow.classList.contains("expanded")) {
    details.style.maxHeight = details.scrollHeight + "px";
    icon.textContent = "▲";
  } else {
    details.style.maxHeight = "0";
    icon.textContent = "▼";
  }
}
