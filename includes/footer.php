    <script>
        let currentTheme = localStorage.getItem('pocketledger_theme') || 'light';
        function applyTheme(theme) {
            const root = document.documentElement;
            const themeToggle = document.getElementById('theme-toggle');
            if (theme === 'dark') {
                root.classList.add('dark', 'theme-dark');
                root.classList.remove('theme-light');
                if(themeToggle) themeToggle.innerText = '☀️ LIGHT_MODE';
            } else {
                root.classList.add('theme-light');
                root.classList.remove('dark', 'theme-dark');
                if(themeToggle) themeToggle.innerText = '🌙 DARK_MODE';
            }
            localStorage.setItem('pocketledger_theme', theme);

            // Re-render dashboard & chart to apply new theme colors to canvas
            if (typeof renderDashboard === 'function') {
                renderDashboard();
            }
        }
        applyTheme(currentTheme);

        const toggleBtn = document.getElementById('theme-toggle');
        if(toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                currentTheme = currentTheme === 'light' ? 'dark' : 'light';
                applyTheme(currentTheme);
            });
        }

        // Toggle password visibility function
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerText = '🙈';
            } else {
                input.type = 'password';
                icon.innerText = '👁️';
            }
        }
    </script>
</body>
</html>
