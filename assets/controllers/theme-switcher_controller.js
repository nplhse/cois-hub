import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  connect () {
    const userTheme = localStorage.getItem('user-theme')
    const browserTheme = window.matchMedia?.('(prefers-color-scheme: dark)')?.matches ? 'dark' : 'light'
    const darkMode = (userTheme ?? browserTheme) === 'dark'

    document.body.setAttribute('data-bs-theme', darkMode ? 'dark' : 'light')
  }

  switch () {
    let currentTheme = localStorage.getItem('user-theme')
    if (!currentTheme) {
      currentTheme = document.body.getAttribute('data-bs-theme')
    }

    const theme = currentTheme === 'dark' ? 'light' : 'dark'
    localStorage.setItem('user-theme', theme)
    document.body.setAttribute('data-bs-theme', theme)
  }
}
