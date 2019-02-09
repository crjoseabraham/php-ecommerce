/**
 * Update total amount with the transport type costs
 */
const selectTransport = document.getElementsByName('transport-type');
const initialSubtotal = (document.getElementById("cart__total") !== null) ? parseFloat(document.getElementById("cart__total").innerHTML) : 0;

selectTransport.forEach(thisOption => {
	thisOption.addEventListener('change', () => {
		let total = initialSubtotal + parseFloat(thisOption.value);
		document.getElementById("cart__total").innerHTML = total;
	});
});

/**
 * Arrow buttons functionality
 * + or - number of items to add
 */
const arrowButtons = document.querySelectorAll('.product-card__arrow-button');

arrowButtons.forEach(thisButton => {
	thisButton.addEventListener('click', () =>  {
		if (thisButton.classList.contains('arrow-button--up')) {
			let inputField = thisButton.nextElementSibling.nextElementSibling.nextElementSibling;
			inputField.value++;
		} else {
			let inputField = thisButton.nextElementSibling.nextElementSibling;
			if (inputField.value > 0)
				inputField.value--;
		}
	});
});

/**
 * Responsive button
 * Shows cart when 'checked'
 */
const responsiveCheckbox = document.getElementById('responsive');

responsiveCheckbox.addEventListener('change', () => {
	document.querySelector('.sidebar__content').style.display = (responsiveCheckbox.checked) ? 'block' : 'none';
});