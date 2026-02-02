</main>
<footer>
    <p>&copy; 2026 Patio Café. All rights reserved.</p>
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

<script src="/final-ass/assets/js/main.js"></script>
<script src="/final-ass/assets/js/modal.js"></script>
</body>

</html>