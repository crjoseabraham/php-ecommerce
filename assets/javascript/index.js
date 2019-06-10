import { UI } from './ui'

// Instantiate UI class
const ui = new UI()

// Load event listeners
document.getElementById('menu-toggle').addEventListener('click', ui.toggleMenu)
document.querySelector('.left-sidebar #close-menu').addEventListener('click', ui.toggleMenu)
document.getElementById('right-sidebar-toggle').addEventListener('click', ui.toggleForm)
document.querySelector('.right-sidebar #close-menu').addEventListener('click', ui.toggleForm)