// Check local storage for theme preference
const savedTheme = localStorage.getItem('theme') || 'light-mode';
document.body.classList.add(savedTheme);
updateThemeClasses(savedTheme); // Apply the theme to header and buttons

const themeToggle = document.getElementById('themeToggle');
themeToggle.addEventListener('click', () => {
    let newTheme;
    // Toggle between light and dark mode
    if (document.body.classList.contains('light-mode')) {
        document.body.classList.remove('light-mode');
        document.body.classList.add('dark-mode');
        newTheme = 'dark-mode';
    } else {
        document.body.classList.remove('dark-mode');
        document.body.classList.add('light-mode');
        newTheme = 'light-mode';
    }
    localStorage.setItem('theme', newTheme);
    updateThemeClasses(newTheme); // Update other elements immediately
});

// Function to update theme-related classes for header and buttons
function updateThemeClasses(theme) {
    const header = document.querySelector('header');
    const buttons = document.querySelectorAll('.button');

    // Update the header class
    header.className = theme;

    // Update all buttons with the theme class
    buttons.forEach(button => {
        button.classList.remove('light-mode', 'dark-mode');
        button.classList.add(theme);
    });
}