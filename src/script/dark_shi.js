var THEME_KEY = 'theme';
var DarkModeToggle = /** @class */ (function () {
    function DarkModeToggle(toggleButtonId) {
        this.toggleButton = this.getElementOrThrow(toggleButtonId);
        this.htmlElement = document.documentElement;
        this.init();
    }
    DarkModeToggle.prototype.getElementOrThrow = function (id) {
        var element = document.getElementById(id);
        if (!element) {
            throw new Error("Element with ID '".concat(id, "' not found"));
        }
        return element;
    };
    DarkModeToggle.prototype.getSystemPreference = function () {
        return window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
    };
    DarkModeToggle.prototype.getSavedTheme = function () {
        var savedTheme = localStorage.getItem(THEME_KEY);
        return savedTheme === 'dark' ? 'dark' : 'light';
    };
    DarkModeToggle.prototype.setTheme = function (theme) {
        this.htmlElement.classList.toggle('dark', theme === 'dark');
        localStorage.setItem(THEME_KEY, theme);
        this.updateButtonIcon(theme);
    };
    DarkModeToggle.prototype.updateButtonIcon = function (theme) {
        this.toggleButton.innerHTML = theme === 'dark'
            ? '<i class="fas fa-sun mr-2"></i>NOT WORKING'
            : '<i class="fas fa-moon mr-2"></i>NOT WORKING';
    };
    DarkModeToggle.prototype.init = function () {
        var _this = this;
        var initialTheme = this.getSavedTheme() || this.getSystemPreference();
        this.setTheme(initialTheme);
        this.toggleButton.addEventListener('click', function () {
            var newTheme = _this.htmlElement.classList.contains('dark')
                ? 'light'
                : 'dark';
            _this.setTheme(newTheme);
        });
    };
    return DarkModeToggle;
}());
document.addEventListener('DOMContentLoaded', function () {
    try {
        new DarkModeToggle('dark-mode-toggle');
    }
    catch (error) {
        console.error('Failed to initialize dark mode toggle:', error);
    }
});
