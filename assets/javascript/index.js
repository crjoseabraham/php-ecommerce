import { UI } from './ui'
const path = require('path');

const ui = new UI()

/**
 * SET EVENT LISTENERS
 */
// Show sidebars
document.querySelectorAll('header > button').forEach(button => {
	button.addEventListener('click', () => {
		ui.overlay()
		ui.toggleSidebar(button)
	})
})

// All event listeners on the sidebars' elements
const sidebars = document.querySelectorAll('div[class$="-sidebar"]')

sidebars.forEach(sidebar => {
	sidebar.addEventListener('click', e => {
		let rightSidebar = document.querySelector('.right-sidebar')
		let leftSidebar = document.querySelector('.left-sidebar')
		let rightSidebarContainer = document.querySelector('.right-sidebar .container')
		let leftSidebarContainer = document.querySelector('.left-sidebar .container')

		switch (true) {
			// Hide sidebars when 'X' button is clicked
			case e.target.parentElement.classList.contains('close-menu'):
				ui.overlay()
				ui.toggleSidebar(e.target.parentElement.parentElement.parentElement.parentElement)
				break;
			// Change content of sidebar .container
			case e.target.classList.contains('change'):
				let routeToTemplate = e.target.classList[e.target.classList.length - 1]
				ui.toggleSidebar(rightSidebar)
				ui.emptyContainer(rightSidebarContainer)
				setTimeout(() => {
					ui.loadTemplate(routeToTemplate, rightSidebarContainer)
					ui.toggleSidebar(rightSidebar)
				}, 390);
				break;
		}
	})
})