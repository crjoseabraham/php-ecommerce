import { UI } from './ui'

const ui = new UI()

// SET EVENT LISTENERS

// General button event listener
document.querySelector('body').addEventListener('click', e => {
	let button

	// Get the clicked button
	if (e.target.localName === "button")
		button = e.target
	if (e.target.parentElement.localName === "button")
		button = e.target.parentElement

	if (button)
	{
		// Case 1: The clicked button is a toggler
		if (button.classList.contains('left-sidebar-toggle') || 
				button.classList.contains('right-sidebar-toggle') || 
				button.classList.contains('modal-toggle'))
		{
			ui.overlay()
			ui.toggleActive(button)
		}

		// Case 2: The button is a .container changer
		if (button.classList.contains('load-template'))
		{
			// Get template name
			let template = button.classList[Array.from(button.classList).indexOf('load-template') + 1]
			// Get element where the content will be loaded in
			let parent = button.getAttribute("id")
			// Load template
			ui.emptyContainer(document.querySelector(`.${parent} > .container`))

			setTimeout(() => {
				ui.loadTemplate(template, document.querySelector(`.${parent} > .container`))
			}, 100);
		}
	}
})

// Modal
document.querySelectorAll('.item').forEach(itemDiv => {
	itemDiv.addEventListener('click', () => {
		let route = itemDiv.getAttribute('data-target')
		let modal = document.getElementById('modal')

		// Show modal
		ui.overlay()
		ui.toggleActive(modal)

		// Load modal content
		ui.emptyContainer(modal)
		setTimeout(() => {
			ui.loadTemplate(route, modal)
		}, 100);

		// Load modal event listeners
		document.querySelector('.modal').addEventListener('click', ui.modalEvents)
	})
})