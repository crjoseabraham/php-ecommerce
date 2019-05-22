// /**
//  * Update total amount with the transport type costs
//  */
// const selectTransport = document.getElementsByName('transport-type');
// const initialSubtotal = (document.getElementById("cart__total") !== null) ? parseFloat(document.getElementById("cart__total").innerHTML) : 0;

// selectTransport.forEach(thisOption => {
// 	thisOption.addEventListener('change', () => {
// 		let total = initialSubtotal + parseFloat(thisOption.value);
// 		document.getElementById("cart__total").innerHTML = total;
// 	});
// });

/**
 * Arrow buttons functionality
 * + or - number of items to add
 */
const arrowButtons = document.querySelectorAll('.arrow-button');

arrowButtons.forEach(thisButton => {
	thisButton.addEventListener('click', () =>  {
		if (thisButton.classList.contains('plus')) {
			let inputField = thisButton.previousElementSibling;
			inputField.value++;
		} else {
			let inputField = thisButton.nextElementSibling;
			if (inputField.value > 1)
				inputField.value--;
		}
	});
});

// /**
//  * Responsive button
//  * Shows cart when 'checked'
//  */
// const responsiveCheckbox = document.getElementById('responsive');

// responsiveCheckbox.addEventListener('change', () => {
// 	document.querySelector('.sidebar__content').style.display = (responsiveCheckbox.checked) ? 'block' : 'none';
// });