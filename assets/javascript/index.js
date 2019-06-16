import { UI } from './ui'

const ui = new UI()

// SET EVENT LISTENERS

// Header/Navbar event listener
document.querySelector('header').addEventListener('click', e => {
	let button

	// Get the clicked button
	if (e.target.localName === "button")
		button = e.target
	if (e.target.parentElement.localName === "button")
		button = e.target.parentElement

	if (button)
	{
		// Case 1: The clicked button is a sidebar toggler
		if (button.classList.contains('left-sidebar-toggle') || button.classList.contains('right-sidebar-toggle'))
		{
			ui.overlay()
			ui.toggleSidebar(button)
		}

		// Case 2: The button is a .container changer
		if (button.classList.contains('load-template'))
		{
			// Get template name
			let template = button.classList[Array.from(button.classList).indexOf('load-template') + 1]
			// Get corresponding sidebar
			let sidebar = button.getAttribute("id")
			// Load template
			ui.emptyContainer(document.querySelector(`.${sidebar} > .container`))

			setTimeout(() => {				
				ui.loadTemplate(template, document.querySelector(`.${sidebar} > .container`))
			}, 100);
		}
	}
})

// Submit form to add item
const addItemForms = document.querySelectorAll('.item')
addItemForms.forEach(form => {
	form.addEventListener('click', () => form.submit())
})