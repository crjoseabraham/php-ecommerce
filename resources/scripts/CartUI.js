export default class CartUI {
    constructor() {
        this.URL = "http://localhost/shoppingcart";

        this.cartDOM = {
            parent: document.querySelector(".cart-content"),
            total: document.querySelector(".cart-footer #total-items"),
        };
    }

    eventListeners() {
        this.cartDOM.parent.addEventListener(
            "click",
            this.parentEventHandler.bind(this)
        );
    }

    parentEventHandler(event) {
        if (event.target.classList.contains("remove-btn"))
            this.removeItem(event);
    }

    clearCartDiv() {
        while (this.cartDOM.parent.firstChild)
            this.cartDOM.parent.removeChild(this.cartDOM.parent.firstChild);
    }

    async getCart() {
        const response = await fetch(`${this.URL}/get-cart`);
        const data = await response.json();
        return data;
    }

    removeItem(event) {
        let item_id = event.target.dataset.item;
        let form_data = new FormData();
        form_data.append("item", item_id);

        this.removeFromCart(form_data)
            .then((result) => {
                this.getCart().then((cart) => {
                    this.clearCartDiv();
                    this.renderCart(cart);
                    this.calculateTotal(cart);
                });
            })
            .catch((error) => {
                alert(error);
            });
    }

    async removeFromCart(form_data) {
        let settings = {
            method: "POST",
            body: form_data,
            processData: false,
            contentType: false,
        };

        const response = await fetch(`${this.URL}/remove-item`, settings);
        const data = await response.json();
        return data;
    }

    calculateTotal(data) {
        let total_value = data.reduce((prev, cur) => {
            return (parseFloat(prev) + parseFloat(cur.subtotal)).toFixed(2);
        }, 0);

        this.cartDOM.total.innerHTML = total_value;
    }

    renderCart(data) {
        this.clearCartDiv();
        let html = `
        <table>
            <caption>Your shopping cart</caption>
            <thead>
                <tr>
                    <th class="image-thead">&nbsp;</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
        `;

        data.forEach((item) => {
            html += `
            <tr data-item="${item.product_id}">
                <td class="image-tbody">
                    <img src="./img/product/${item.product_id}.jpg" alt="${
                item.description
            }">
                </td>
                <td class="cart-item-details">
                    <div class="cart-item-info">
                        <span class="description">
                            <a href="product_details.${
                                item.product_id
                            }" class="simple">
                                ${item.description}
                            </a>
                        </span>
                        <span class="extra">
                            Size: ${item.size}. Product code: ${item.product_id}
                        </span>
                    </div>
                </td>
                <td>
                    $${
                        item.discount > 0
                            ? (
                                  item.price -
                                  item.price * (item.discount / 100)
                              ).toFixed(2)
                            : item.price
                    }
                </td>
                <td data-label="Quantity:&nbsp;">
                    ${item.quantity}
                </td>
                <td class="cart-subtotal">
                    $${item.subtotal}
                </td>
                <td class="cart-remove-btn">
                    <button type="submit" class="remove-btn" data-item="${
                        item.product_id
                    }">
                        Remove
                    </button>
                </td>
            </tr>
            `;
        });

        html += `
            </tbody>
        </table>
        `;

        this.cartDOM.parent.innerHTML = html;
    }
}
