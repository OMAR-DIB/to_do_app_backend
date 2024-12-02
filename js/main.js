// Apply theme on page load
const savedTheme = localStorage.getItem('theme') || 'light-mode';
document.body.classList.add(savedTheme);
updateThemeClasses(savedTheme);

function updateThemeClasses(theme) {
    const header = document.querySelector('header');
    const container = document.querySelector('.container');
    const inputs = document.querySelectorAll('input, select, textarea');
    const buttons = document.querySelectorAll('.button');
    const title = document.querySelector('h1');

    // Update classes
    header.className = theme;
    container.className = `container ${theme}`;
    inputs.forEach(input => {
        input.classList.remove('light-mode', 'dark-mode');
        input.classList.add(theme);
    });
    buttons.forEach(button => {
        button.classList.remove('light-mode', 'dark-mode');
        button.classList.add(theme);
    });
    title.className = theme;
}


// Theme toggle
const themeToggle = document.getElementById('themeToggle');
themeToggle.addEventListener('click', () => {
    const newTheme = document.body.classList.contains('light-mode') ? 'dark-mode' : 'light-mode';
    document.body.className = newTheme;
    localStorage.setItem('theme', newTheme);
    updateThemeClasses(newTheme);
});
