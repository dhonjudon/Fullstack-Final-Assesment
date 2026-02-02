</main>
<footer>
    <p>&copy; 2026 Tushar Dhonju. All rights reserved.</p>
</footer>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Delete Item</h3>
            <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete <strong id="modalItemName"></strong>?</p>
            <p style="color: #d4a574; font-size: 0.9rem;">This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="button button-secondary" onclick="closeDeleteModal()">Cancel</button>
            <button class="button button-danger" onclick="confirmDelete()">Delete</button>
            <input type="hidden" id="modalDeleteId">
        </div>
    </div>
</div>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/modal.js"></script>

<script>
    // Add to cart functionality - inline since main.js may not load
    function setupAddToCart() {
        const buttons = document.querySelectorAll(".add-to-cart-btn");
        console.log("Footer script: Found", buttons.length, "buttons");

        buttons.forEach(btn => {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                const itemId = this.dataset.itemId;
                console.log("Footer script: Adding item", itemId);

                const originalText = this.textContent;
                this.textContent = "✓ Added!";
                this.style.background = "#4caf50";

                const xhr = new XMLHttpRequest();
                xhr.open("GET", "cart.php?add=" + itemId, true);
                xhr.withCredentials = true;

                xhr.onload = () => {
                    console.log("Added to cart");
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.background = "";
                    }, 1500);
                };

                xhr.send();
            });
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", setupAddToCart);
    } else {
        setupAddToCart();
    }
</script>

</body>

</html>