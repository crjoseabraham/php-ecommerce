import "../sass/main.scss";
import UserInterface from "./UserInterface";

const UI = new UserInterface();
UI.starters();

/**
 * Remove item from cart
 *
 * removeItem(event) {
        if (event.target.classList.contains("remove-btn")) {
            let item_id = event.target.dataset.item;
            // AJAX CALL
            const resource = this.http.baseURL + "remove-item";
            const data = new FormData();
            data.append("item", item_id);

            fetch(resource, {
                method: "POST",
                body: data
            })
                .then(function (response) {
                    if (response.ok) {
                        return response.text();
                    } else {
                        throw "Error en la llamada Ajax";
                    }
                })
                .then(function (texto) {
                    console.log(texto);
                })
                .catch(function (err) {
                    console.log(err);
                });
        }
    }
 */
