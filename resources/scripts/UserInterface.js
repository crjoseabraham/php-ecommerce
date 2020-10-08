import CartUI from "./CartUI";
import Carousels from "./Carousels";
import FormValidations from "./FormValidations";

export default class UserInterface {
    constructor() {
        this.Carousels = new Carousels();
        this.CartUI = new CartUI();

        // DOM Pointers
        this.DOM = {
            body: document.getElementById("bodyJsPointer"),
            notification: document.querySelector(".notification"),
            overlay: document.getElementById("overlay"),
            navbar: document.getElementById("menu"),
            profile: document.querySelector(".profile-container")
        };
    }

    starters() {
        this.loadEventListeners();
        this.stickyNavbar();
        this.Carousels.render();
    }

    loadEventListeners() {
        this.notificationListener();
        this.DOM.navbar.addEventListener("click", this.navbarListener.bind(this));
        this.DOM.body.addEventListener("submit", this.formListener.bind(this));
        this.CartUI.eventListeners();
        if (!(this.DOM.profile === null))
            this.DOM.profile.addEventListener("click", this.profileListener.bind(this));
    }

    stickyNavbar() {
        window.addEventListener("scroll", () => {
            this.DOM.navbar.classList.toggle("sticky", window.scrollY > 0);
        });
    }

    formListener(event) {
        event.preventDefault();
        const form_class = new FormValidations();
        form_class.setFormData(event.target);
        this.formHandler(event.target, form_class);
    }

    // RIGHT NOW THIS WILL BE FILTERED WITH A SWITCH STATEMENT, BUT IF AT THE END
    // THERE AREN'T ANY OTHER SPECIFIC CASE FOR A FORM... THEN CHANGE IT FOR THIS:
    /**
     if (form.id === "add-to-cart") form_class.validateForCart();
     else form_class.validateOnSubmit();
     */
    formHandler(form, form_class) {
        switch (form.id) {
            case "add-to-cart":
                form_class.validateForCart();
                break;
            default:
                form_class.validateOnSubmit();
                break;
        }

        form_class.displayInputStatus();
        if (!form_class.hasErrors()) {
            form.submit();
            form.reset();
        }
    }

    notificationListener() {
        if (this.DOM.notification !== null) {
            this.DOM.notification.addEventListener(
                "click",
                this.closeNotification.bind(this)
            );
        }
    }

    closeNotification(event) {
        if (event.target.id === "close-notification")
            this.DOM.notification.style.display = "none";
    }

    navbarListener(event) {
        if (event.target.hasAttribute("data-action")) {
            event.preventDefault();
            this.showPopup(event);
        }

        if (
            event.target.id === "close-popup" ||
            event.target.parentElement.id === "close-popup"
        )
            this.hidePopup();
    }

    showPopup(event) {
        if (event.target.dataset.action === "cart") {
            this.CartUI.getCart()
                .then((data) => {
                    this.CartUI.renderCart(data);
                    this.CartUI.calculateTotal(data);
                })
                .catch((err) => console.log(err));
        }
        let popup = this.DOM.navbar.querySelector(".menu__popup");
        let containers = Array.from(this.DOM.navbar.querySelectorAll(".popup__content"));
        let correct_container = containers.find(
            (div) => div.dataset.action === event.target.dataset.action
        );
        popup.classList.remove("active");

        if (
            correct_container.classList.contains("active") &&
            correct_container.dataset.action === event.target.dataset.action
        ) {
            correct_container.classList.remove("active");
            this.DOM.overlay.classList.remove("active");
            this.DOM.body.classList.remove("noscroll");
        } else {
            containers.forEach((container) => {
                container.classList.remove("active");
            });
            popup.classList.add("active");
            this.DOM.overlay.classList.add("active");
            correct_container.classList.add("active");
            this.DOM.body.classList.add("noscroll");
        }
    }

    hidePopup() {
        let popup = this.DOM.navbar.querySelector(".menu__popup");
        let containers = Array.from(this.DOM.navbar.querySelectorAll(".popup__content"));

        containers.forEach((container) => {
            container.classList.remove("active");
        });

        popup.classList.remove("active");
        this.DOM.overlay.classList.remove("active");
        this.DOM.body.classList.remove("noscroll");
    }

    profileListener(event) {
        if (event.target.hasAttribute("data-action")) {
            this.profileTabChanger(event);
        }
    }

    profileTabChanger(event) {
        let menu_options = Array.from(
            document.querySelector(".profile-content__menu").getElementsByTagName("li")
        );
        let containers = Array.from(
            document
                .querySelector(".profile-content__body")
                .getElementsByClassName("profile-template")
        );
        let correct_div = containers.find(
            (div) => div.dataset.action === event.target.dataset.action
        );

        menu_options.forEach((li) => {
            if (li.dataset.action !== event.target.dataset.action)
                li.classList.remove("active");
        });
        containers.forEach((div) => {
            if (div.dataset.action !== event.target.dataset.action)
                div.classList.remove("active");
        });

        correct_div.classList.add("active");
        event.target.classList.add("active");
    }
}
