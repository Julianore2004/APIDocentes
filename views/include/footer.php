<!-- ===== FOOTER ===== -->
    <footer class="app-footer">
      <div class="footer-container">
        <p class="footer-text">© 2025 Instituto API Docentes</p>
      </div>
    </footer>

    <script src="<?php echo BASE_URL; ?>public/js/script.js"></script>
  </body>
</html>

<style>
  /* ===== FOOTER ===== */
  .app-footer {
    background: #222;
    color: #f1f1f1;
    padding: 1.2rem 1rem;
    text-align: center;
    border-top: 2px solid #007bff;
  }

  .footer-container {
    max-width: 1200px;
    margin: 0 auto;
  }

  .footer-text {
    font-size: 0.95rem;
    letter-spacing: 0.5px;
  }

  /* Responsive opcional */
  @media (max-width: 768px) {
    .footer-text {
      font-size: 0.85rem;
    }
  }
</style>