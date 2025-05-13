type Theme = 'light' | 'dark';
const THEME_KEY = 'theme';

class DarkModeToggle {
  private readonly toggleButton: HTMLElement;
  private readonly htmlElement: HTMLElement;

  constructor(toggleButtonId: string) {
    this.toggleButton = this.getElementOrThrow(toggleButtonId);
    this.htmlElement = document.documentElement;
    this.init();
  }

  private getElementOrThrow(id: string): HTMLElement {
    const element = document.getElementById(id);
    if (!element) {
      throw new Error(`Element with ID '${id}' not found`);
    }
    return element;
  }

  private getSystemPreference(): Theme {
    return window.matchMedia('(prefers-color-scheme: dark)').matches 
      ? 'dark' 
      : 'light';
  }

  private getSavedTheme(): Theme {
    const savedTheme = localStorage.getItem(THEME_KEY);
    return savedTheme === 'dark' ? 'dark' : 'light';
  }

  private setTheme(theme: Theme): void {
    this.htmlElement.classList.toggle('dark', theme === 'dark');
    localStorage.setItem(THEME_KEY, theme);
    this.updateButtonIcon(theme);
  }

  private updateButtonIcon(theme: Theme): void {
    this.toggleButton.innerHTML = theme === 'dark'
      ? '<i class="fas fa-sun mr-2"></i>Light Mode'
      : '<i class="fas fa-moon mr-2"></i>Dark Mode';
  }

  private init(): void {
    const initialTheme = this.getSavedTheme() || this.getSystemPreference();
    this.setTheme(initialTheme);

    this.toggleButton.addEventListener('click', () => {
      const newTheme = this.htmlElement.classList.contains('dark') 
        ? 'light' 
        : 'dark';
      this.setTheme(newTheme);
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  try {
    new DarkModeToggle('dark-mode-toggle');
  } catch (error) {
    console.error('Failed to initialize dark mode toggle:', error);
  }
});