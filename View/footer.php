<footer class="main-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Moment Orchestra</h3>
                <p>Creăm experiențe muzicale memorabile din 2024.</p>
            </div>
            <div class="footer-section">
                <h3>Link-uri Utile</h3>
                <ul>
                    <li><a href="events.php">Evenimente</a></li>
                    <li><a href="gallery.php">Galerie</a></li>
                    <li><a href="reservations.php">Rezervări</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <p>📧 contact@momentorchestra.ro</p>
                <p>📱 +40 123 456 789</p>
                <p>📍 Roman, România</p>
            </div>
            <div class="footer-section">
                <h3>Social Media</h3>
                <div class="social-links">
                    <a href="#" title="Facebook">FB</a>
                    <a href="#" title="Instagram">IG</a>
                    <a href="#" title="YouTube">YT</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Moment Orchestra. Toate drepturile rezervate.</p>
        </div>
    </div>
</footer>

<script>
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        });
    });
</script>

<?php if (isset($extraJS)): ?>
    <?php foreach ($extraJS as $js): ?>
        <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>

</html>