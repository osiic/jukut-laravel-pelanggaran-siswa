<button id="theme-toggle" class="p-2 rounded">
    <span id="theme-icon">🌞</span>
</button>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const themeToggle = document.getElementById("theme-toggle");
        const themeIcon = document.getElementById("theme-icon");

        function setTheme(theme) {
            if (theme === "dark") {
                document.documentElement.classList.add("dark");
                localStorage.setItem("theme", "dark");
                themeIcon.textContent = "🌙"; // Ubah ikon
            } else {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("theme", "light");
                themeIcon.textContent = "🌞";
            }
        }

        // Cek tema dari localStorage
        const savedTheme = localStorage.getItem("theme") || "light";
        setTheme(savedTheme);

        // Toggle saat tombol ditekan
        themeToggle.addEventListener("click", () => {
            const currentTheme = document.documentElement.classList.contains("dark") ? "light" : "dark";
            setTheme(currentTheme);
        });
    });
</script>
