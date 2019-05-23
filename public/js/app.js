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
	})
})


/**
 * Show total amount in confirm-payment page
 * Update total amount adding the transport type costs
 */
const initialSubtotal = parseFloat(document.querySelector(".confirm-subtotal").innerHTML);
const shipping = document.querySelector("#shipping");

// Show starter value
document.querySelector(".total-amount").innerHTML = 
  parseInt(shipping.value) === 7 ? (initialSubtotal + (initialSubtotal * 0.07)).toFixed(2) : initialSubtotal;

// Update total amount when <select> value has changed
shipping.addEventListener('change', () => {
  let total = 0;

  switch(parseInt(shipping.value))
  {
    case 7:
      total = (initialSubtotal + (initialSubtotal * 0.07)).toFixed(2);
      break;
    case 0:
      total = initialSubtotal;
      break;
  }

  document.querySelector(".total-amount").innerHTML = total;
})