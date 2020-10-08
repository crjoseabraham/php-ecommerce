export default class CartUI {
    constructor() {
        // If user is in the 'cart' page, then set variables.
        if (window.location.pathname.search("cart-checkout") > 0) {
            this.parent = document.getElementById("cart-checkout");
            this.cart_table = this.parent.querySelector("table.cart");
        } else {
            this.parent = null;
            this.cart_table = null;
        }
    }

    eventListeners() {
        if (this.parent !== null) {
            this.parent.addEventListener("click", this.parentEventHandler.bind(this));
            this.parent
                .querySelector("#shipping")
                .addEventListener("change", this.setShippingOption);
        }
    }

    parentEventHandler(event) {
        if (
            event.target.parentElement.id === "control-up" ||
            event.target.parentElement.id === "control-down"
        )
            this.changeQuantity(event);

        if (event.target.id === "remove-item") this.removeItem(event);
    }

    changeQuantity(event) {
        let row = event.target.closest("tr");
        let button = event.target.parentElement;
        let qty_input = row.querySelector("#qty-field");
        let qty = parseInt(qty_input.value);

        if (
            !(button.id === "control-down" && qty === 1) &&
            !(button.id === "control-up" && qty === 20)
        ) {
            button.id === "control-up" ? qty_input.value++ : qty_input.value--;

            // AJAX CALL, send qty_input.value
            this.updateQuantityInDb(row.dataset.product, qty_input.value)
                .then((data) => {
                    row.querySelector("#product-price").innerHTML = `$${data.subtotal}`;
                    this.parent.querySelector(
                        ".cart-subtotal .amount"
                    ).innerHTML = `${data.cart_total}`;
                    document.getElementById(
                        "payment-cart-total"
                    ).innerHTML = `${data.cart_total}`;
                    document.getElementById(
                        "order-total"
                    ).innerHTML = `${data.cart_total}`;
                    this.setShippingOption();
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    }

    async updateQuantityInDb(item_id, quantity) {
        let form_data = new FormData();
        form_data.append("item", item_id);
        form_data.append("quantity", quantity);
        let settings = {
            method: "POST",
            body: form_data,
            processData: false,
            contentType: false
        };

        const response = await fetch(
            `http://localhost/shoppingcart/change-quantity`,
            settings
        );
        const data = await response.json();
        return data;
    }

    removeItem(event) {
        let row = event.target.closest("tr");
        let item_id = parseInt(row.dataset.product);

        this.removeItemFromDb(item_id)
            .then((data) => {
                this.cart_table.deleteRow(row.rowIndex);
                this.parent.querySelector(
                    ".cart-subtotal .amount"
                ).innerHTML = `${data.cart_total}`;
                document.getElementById(
                    "payment-cart-total"
                ).innerHTML = `${data.cart_total}`;
                document.getElementById("order-total").innerHTML = `${data.cart_total}`;
                this.setShippingOption();
            })
            .catch((error) => {
                console.error(error);
            });
    }

    async removeItemFromDb(item_id) {
        let form_data = new FormData();
        form_data.append("item", item_id);
        let settings = {
            method: "POST",
            body: form_data,
            processData: false,
            contentType: false
        };

        const response = await fetch(
            `http://localhost/shoppingcart/remove-item`,
            settings
        );
        const data = await response.json();
        return data;
    }

    setShippingOption() {
        let order_total = document.getElementById("order-total");
        let order_total_value = parseFloat(
            document.querySelector(".cart-subtotal .amount").innerHTML
        );
        let option = document.getElementById("shipping");
        let total = 0;
        let tax = 0;

        switch (parseInt(option.value)) {
            case 0:
                total = order_total_value;
                break;

            case 7:
                tax = (order_total_value * 0.07).toFixed(2);
                total = (order_total_value + order_total_value * 0.07).toFixed(2);
                break;
        }

        order_total.innerText = total;
        document.getElementById("tax").innerText = tax;
    }
}
