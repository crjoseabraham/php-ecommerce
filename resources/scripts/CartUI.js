export default class CartUI {
    constructor() {
        this.URL = "http://localhost/shoppingcart/";

        this.cartDOM = {
            parent: document.querySelector(".cart-content"),
            removeBtn: document.querySelectorAll(".remove-btn")
        };
    }

    eventListeners() {
        if (!(this.cartDOM.removeBtn === null)) {
            this.cartDOM.removeBtn.forEach((btn) => {
                btn.addEventListener("click", this.removeItem.bind(this));
            });
        }
    }

    removeItem(event) {
        const item_id = event.target.dataset.item;
        const data = new FormData();
        data.append("item", item_id);

        fetch(this.URL + "remove-item", {
            method: "POST",
            body: data
        })
            .then(function (response) {
                if (response.ok) return response.text();
                else throw "Error in Ajax Call";
            })
            .then((exec_result) => {
                this.removeItemFromUI(item_id);
                this.recalculateTotal();
            })
            .catch((err) => console.error(err));
    }

    removeItemFromUI(item_id) {
        const tbody = this.cartDOM.parent.querySelector("table > tbody");
        const row = Array.from(
            this.cartDOM.parent.querySelectorAll("table > tbody > tr")
        ).find((row) => row.dataset.item === item_id);

        tbody.removeChild(row);
    }

    recalculateTotal() {
        fetch(this.URL + "get-cart")
            .then((resp) => resp.json())
            .then((data) => {
                let total_container = document.getElementById("total-items");
                let total_value = data.reduce(function (prev, cur) {
                    return (parseFloat(prev) + parseFloat(cur.subtotal)).toFixed(2);
                }, 0);
                total_container.innerHTML = total_value;

                // Update cart items counter
                let cart_counter = document.getElementById("cart-counter");
                cart_counter.innerHTML = data.length;
            })
            .catch((err) => console.error(err));
    }
}
