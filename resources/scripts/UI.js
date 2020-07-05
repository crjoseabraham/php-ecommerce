export default class UI {
    constructor(HttpRequest) {
        // For HTTP Requests
        this.http = HttpRequest;

        // UI elements
        this.modal = document.getElementById("modal");
        this.body = document.getElementById("bodyJsPointer");

        // Set event listeners
        this.body.addEventListener("click", this.eventsHandler.bind(this));
        document.querySelectorAll(".product__card").forEach((card) => {
            card.addEventListener("click", this.displayItemDetails.bind(this));
        });

        // Load other elements on startup
        this.loadCarousels();
        this.stickyNav();
    }

    // -------------------------------------------------
    // RELATED TO THE DOM AND NOT TO SPECIFIC WEBAPP ACTIONS

    /**
     * Determine if user is on mobile or desktop
     */
    isMobile() {
        return window.innerWidth <= 800;
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

    /**
     * Hide carousels horizontal scrollbar in Firefox
     */
    hideFFScrollbars() {
        document.addEventListener("glider-loaded", hideFFScrollBars);
        document.addEventListener("glider-refresh", hideFFScrollBars);
        function hideFFScrollBars(e) {
            var scrollbarHeight = 17; // Currently 17, may change with updates
            if (/firefox/i.test(navigator.userAgent)) {
                // We only need to apply to desktop. Firefox for mobile uses
                // a different rendering engine (WebKit)
                if (window.innerWidth > 575) {
                    e.target.parentNode.style.height =
                        e.target.offsetHeight - scrollbarHeight + "px";
                }
            }
        }
    }

    // ---------------------------------------
    // THINGS THAT MUST BE LOADED ON STARTUP

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
        // Display select options if the click happens
        // on any of the ul.select--default children
        if (
            event.target.classList.contains("selected") ||
            event.target.parentElement.classList.contains("arrow") ||
            event.target.classList.contains("select--title")
        )
            this.displaySelectOptions(event.target.closest(".select--default"));
    }

    /**
     * Make navbar sticky on scroll
     */
    stickyNav() {
        window.addEventListener("scroll", () => {
            let navbar = document.getElementById("menu");
            navbar.classList.toggle("sticky", window.scrollY > 0);

            // Replace logo for the small one for responsive layout
            let img = document.querySelector(".menu__container .menu__logo");
            let original_logo = "./img/brand/logotipo.png";
            let small_logo = "./img/brand/isotipo.png";

            img.src = navbar.classList.contains("sticky") ? small_logo : original_logo;
        });
    }

    /**
     * Init Glider.js carousel
     */
    loadCarousels() {
        new Glider(document.querySelector(".items-with-discount"), {
            slidesToShow: 1,
            scrollLock: true,
            rewind: true,
            arrows: {
                prev: ".glider-prev",
                next: ".glider-next"
            }
        });

        new Glider(document.querySelector(".best-sellers-carousel"), {
            slidesToShow: 4,
            slidesToScroll: 1,
            scrollLock: true,
            rewind: true,
            arrows: {
                prev: ".best-prev",
                next: ".best-next"
            }
        });

        new Glider(document.querySelector(".just-arrived-carousel"), {
            slidesToShow: 4,
            slidesToScroll: 1,
            scrollLock: true,
            rewind: true,
            arrows: {
                prev: ".ja-prev",
                next: ".ja-next"
            }
        });

        this.hideFFScrollbars();
    }

    // -------------------------
    // SHOW OR HIDE UI ELEMENTS

    /**
     * Show modal. Display correct content div
     * @param {string} data_template Reference name to the desired view
     */
    showModal(data_template) {
        this.http
            .get(data_template)
            .then((view_html) => {
                this.deleteElementContent(
                    this.modal.querySelector(".template-container")
                );
                this.modal
                    .querySelector(".template-container")
                    .insertAdjacentHTML("afterbegin", view_html);
            })
            .catch((error_message) => {
                console.log(error_message);
            })
            .finally(() => {
                this.modal.classList.add("active");
                this.body.classList.add("noscroll");
            });
    }

    /**
     * Ehm.. hide the modal, what else do you want from me?
     */
    hideModal() {
        this.body.classList.remove("noscroll");
        this.modal.classList.remove("active");
        if (this.modal.classList.contains("large-modal"))
            this.modal.classList.remove("large-modal");
    }

    /**
     * Display modal with item details for the selected product card
     * @param {object} card The product card clicked
     */
    displayItemDetails(event) {
        event.preventDefault();
        this.showModal(event.target.closest(".product__card").dataset.template);
        this.modal.classList.toggle("large-modal");
    }

    /**
     * Display the custom select box options and add event listener for when the option is clicked
     */
    displaySelectOptions(select_default) {
        select_default.classList.toggle("active");
        // Select clicked option ->
        select_default.nextElementSibling.querySelectorAll("li").forEach((li) => {
            li.addEventListener("click", () => {
                this.selectOption(li, select_default.id);
            });
        });
    }

    /**
     * Mark an option as selected and update the hidden input value
     * @param {object} li Selected option
     */
    selectOption(li, target) {
        //set text on "selected option"
        let targetElement = document.getElementById(target);
        targetElement.querySelector(".option.selected").innerHTML = li.querySelector(
            ".option"
        ).innerText;
        //hide options box
        targetElement.classList.remove("active");
        //set hidden input value
        switch (target) {
            case "selectSize":
                document.getElementById("size").value = li.querySelector(
                    ".option"
                ).innerText;
                break;

            case "selectQuantity":
                document.getElementById("quantity").value = li.querySelector(
                    ".option"
                ).innerText;
                break;
        }
    }
}
