export default class UI {
    constructor(HttpRequest) {
        // For HTTP Requests
        this.HttpRequest = HttpRequest;

        // UI elements
        this.modal = document.getElementById("modal");

        // Set event listeners
        document
            .getElementById("bodyJsPointer")
            .addEventListener("click", this.eventsHandler.bind(this));
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
        event.preventDefault();

        if (event.target.hasAttribute("data-template")) {
            this.showModal(event.target.dataset.template);
        }
    }

    /**
     * Find a view to display in modal
     * @param {string} view Reference name to the desired view
     */
    showModal(view) {
        this.HttpRequest.get(view)
            .then((view_html) => {
                console.log(JSON.parse(view_html)); // <----- DELETE
                this.deleteElementContent(this.modal.querySelector(".modal__content"));
                this.modal
                    .querySelector(".modal__content")
                    .insertAdjacentHTML("afterbegin", JSON.parse(view_html));
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                this.modal.classList.toggle("active");
            });
    }

    /**
     * Ehm.. hide the modal, what else do you want from me?
     */
    hideModal() {
        // code here
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
