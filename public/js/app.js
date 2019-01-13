/**
 * Update total amount with the transport type costs
 */

const selectTransport = document.getElementById("transport-type");
const initialSubtotal = parseFloat(document.getElementById("cart__total").innerHTML);

selectTransport.onchange = () => {
    let transportValue = selectTransport.options[selectTransport.selectedIndex].value;
    transportValue = parseFloat(transportValue);
    let total = initialSubtotal + transportValue; 
    document.getElementById("cart__total").innerHTML = total;
}