// Cart AJAX functionality
console.log("main.js: Script loaded");

// Wait for DOM to be ready
function setupCart() {
  console.log("main.js: Setting up cart buttons");

  const buttons = document.querySelectorAll(".add-to-cart-btn");
  console.log("main.js: Found", buttons.length, "buttons");

  buttons.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      console.log("main.js: Button clicked, item ID:", this.dataset.itemId);
      addToCart(this);
    });
  });
}

// Setup on DOM ready
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", setupCart);
} else {
  setupCart();
}

function addToCart(button) {
  const itemId = button.dataset.itemId;
  console.log("main.js: addToCart called for item", itemId);

  if (!itemId) {
    console.log("main.js: No item ID");
    return;
  }

  // Save original state
  const originalText = button.textContent;
  const originalBg = button.style.background;

  // Show feedback
  button.textContent = "✓ Added!";
  button.style.background = "#4caf50";

  // Make request to add item
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `../public/cart.php?add=${itemId}`, true);
  xhr.withCredentials = true;

  xhr.onload = function () {
    console.log("main.js: Response received, status:", xhr.status);

    // Reset after 1.5 seconds
    setTimeout(() => {
      button.textContent = originalText;
      button.style.background = originalBg;
    }, 1500);
  };

  xhr.onerror = function () {
    console.error("main.js: Error in XHR");
    button.textContent = originalText;
    button.style.background = originalBg;
  };

  console.log("main.js: Sending XHR request");
  xhr.send();
}
