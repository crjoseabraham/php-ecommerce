export default class UI {
    constructor() {
        // UI elements
        this.modal = document.getElementById("modal");
        this.body = document.getElementById("bodyJsPointer");

        // Set event listeners
        this.body.addEventListener("click", this.eventsHandler.bind(this));
    }

    /**
     * Determine if user is on mobile or desktop
     */
    isMobile() {
        return window.innerWidth <= 800;
    }

    /**
     * Conditions for the "click" event in the app in order to redirect to the right method
     * @param {object} event Clicked element
     */
    eventsHandler(event) {
        // Show modal
        if (event.target.hasAttribute("data-template")) {
            event.preventDefault();
            this.showModal(event.target.dataset.template);
        }
        // Hide modal
        if (event.target.parentElement.id === "close-modal") {
            this.hideModal();
        }
    }

    /**
     * Show modal. Display correct content div, hide the rest
     * @param {string} data_template Reference name to the desired view
     */
    showModal(data_template) {
        this.modal.classList.add("active");
        this.body.classList.add("noscroll");

        const content_divs = this.modal.querySelectorAll(".modal__content .template");

        content_divs.forEach((div) => {
            div.classList.remove("active");

            if (div.dataset.template === data_template) {
                div.classList.add("active");
            }
        });
    }

    /**
     * Ehm.. hide the modal, what else do you want from me?
     */
    hideModal() {
        this.modal.classList.remove("active");
        this.body.classList.remove("noscroll");
    }

    /**
     * Clean the inner HTML from a given element
     * @param {object} element div/element to erase content from
     */
    deleteElementContent(element) {
        while (element.firstChild) {
            element.removeChild(element.lastChild);
        }
    }
}
