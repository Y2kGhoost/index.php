// script/dark_mod.js
document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const html = document.documentElement;
    
    // Check for saved user preference
    const currentTheme = localStorage.getItem('theme') || 'light';
    if (currentTheme === 'dark') {
        html.classList.add('dark');
        darkModeToggle.innerHTML = '<i class="fas fa-sun mr-2"></i>Mode Clair';
    }

    // Toggle dark mode
    darkModeToggle.addEventListener('click', function() {
        html.classList.toggle('dark');
        const theme = html.classList.contains('dark') ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
        
        if (theme === 'dark') {
            darkModeToggle.innerHTML = '<i class="fas fa-sun mr-2"></i>Mode Clair';
        } else {
            darkModeToggle.innerHTML = '<i class="fas fa-moon mr-2"></i>Mode Sombre';
        }
    });
});