import FormValidations from "./FormValidations";

export default class UI {
    constructor(HttpRequest) {
        // For HTTP Requests
        this.http = HttpRequest;

        // UI elements
        this.body = document.getElementById("bodyJsPointer");
        this.notification = document.querySelector(".notification");
        this.forms = document.querySelectorAll("form");
        this.profile_parent = document.getElementById("profile-content-parent");

        // Set event listeners
        document.querySelectorAll("[data-popup]").forEach((popup_pointer) => {
            popup_pointer.addEventListener("click", this.showPopup.bind(this));
        });

        // Close popup or notification
        document
            .getElementById("close-popup")
            .addEventListener("click", this.closePopup.bind(this));

        if (this.notification !== null) {
            this.notification.addEventListener(
                "click",
                this.closeNotification.bind(this)
            );
        }

        if (this.profile_parent !== null) {
            this.profile_parent.addEventListener(
                "click",
                this.profileContentChanger.bind(this)
            );
        }

        // Load other elements on startup
        this.loadFormEvents();
        this.loadCarousels();
        this.stickyNav();
    }

    // -------------------------------------------------
    // RELATED TO THE DOM AND NOT TO SPECIFIC WEBAPP ACTIONS

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

    // -------------------------
    // SHOW OR HIDE UI ELEMENTS

    /**
     * Display popup content
     * @param {object} event Mouse Event
     */
    showPopup(event) {
        event.preventDefault();

        let popup_parent = document.querySelector(".menu__popup");
        let popup_content_divs = document.querySelectorAll(".popup__content");
        let overlay = document.getElementById("overlay");

        popup_content_divs.forEach((content_div) => {
            if (event.target.dataset.popup === content_div.dataset.popupname) {
                if (content_div.classList.contains("active")) {
                    content_div.classList.remove("active");
                    popup_parent.classList.remove("active");
                } else {
                    overlay.classList.add("active");
                    this.body.classList.add("noscroll");
                    popup_parent.classList.add("active");
                    content_div.classList.toggle("active");
                }
            } else content_div.classList.remove("active");
        });

        if (!popup_parent.classList.contains("active")) {
            overlay.classList.remove("active");
            this.body.classList.remove("noscroll");
        }
    }

    // Close the popup
    closePopup(event) {
        document.querySelectorAll(".popup__content").forEach((content) => {
            content.classList.remove("active");
        });

        document.querySelector(".menu__popup").classList.remove("active");
        overlay.classList.remove("active");
        this.body.classList.remove("noscroll");
    }

    // Profile page tabs system
    profileContentChanger(event) {
        // If a <li> was clicked
        if (event.target.classList.contains("profile-content__option")) {
            let menu_options = Array.from(
                document
                    .querySelector(".profile-content__menu")
                    .getElementsByTagName("li")
            );
            let containers = Array.from(
                document
                    .querySelector(".profile-content__body")
                    .getElementsByClassName("profile-template")
            );

            // If it has "active" do nothing, if not, toggle "active"
            if (!event.target.classList.contains("active")) {
                // Find correct <div> for the clicked <li>
                let corresponding_div = containers.find(
                    (div) => div.dataset.action === event.target.dataset.action
                );
                // Remove "active" from the others <div> and <li>
                menu_options.forEach((li) => {
                    if (li.dataset.action !== event.target.dataset.action) {
                        li.classList.remove("active");
                    }
                });
                containers.forEach((div) => {
                    if (div.dataset.action !== event.target.dataset.action) {
                        div.classList.remove("active");
                    }
                });
                // Finally, add the "active" state to the correct elements
                corresponding_div.classList.add("active");
                event.target.classList.add("active");
            }
        }
    }

    // Close the notification
    closeNotification(event) {
        if (event.target.id === "close-notification")
            document.querySelector(".notification").style.display = "none";
    }

    // ---------------------------------------
    // THINGS THAT MUST BE LOADED ON STARTUP

    /**
     * Load Event listeners for the forms
     */
    loadFormEvents() {
        this.body.addEventListener("submit", (event) => {
            event.preventDefault();
            // Login gets validated in the backend anyway
            if (event.target.id === "login_form") event.target.submit();
            else {
                let validations_class = new FormValidations(event.target);
                validations_class.validateSubmit();
            }
        });
    }

    /**
     * Make navbar sticky on scroll
     */
    stickyNav() {
        window.addEventListener("scroll", () => {
            let navbar = document.getElementById("menu");
            navbar.classList.toggle("sticky", window.scrollY > 0);
        });
    }

    /**
     * Init Glider.js carousel
     */
    loadCarousels() {
        new Glider(document.querySelector(".items-with-discount"), {
            slidesToShow: 2,
            slidesToScroll: 2,
            scrollLock: true,
            itemWidth: 155,
            rewind: true,
            draggable: true,
            arrows: {
                prev: ".glider-prev",
                next: ".glider-next"
            },
            responsive: [
                {
                    breakpoint: 320,
                    settings: {
                        itemWidth: 197,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 400,
                    settings: {
                        itemWidth: 197,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        itemWidth: 160,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 550,
                    settings: {
                        itemWidth: 170,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 601,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        new Glider(document.querySelector(".best-sellers-carousel"), {
            slidesToShow: 2,
            slidesToScroll: 2,
            itemWidth: 172,
            scrollLock: true,
            draggable: true,
            rewind: true,
            arrows: {
                prev: ".best-prev",
                next: ".best-next"
            },
            responsive: [
                {
                    breakpoint: 400,
                    settings: {
                        itemWidth: 197,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        itemWidth: 160,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 550,
                    settings: {
                        itemWidth: 170,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        itemWidth: 170,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 760,
                    settings: {
                        itemWidth: 190,
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                }
            ]
        });

        new Glider(document.querySelector(".just-arrived-carousel"), {
            slidesToShow: 2,
            slidesToScroll: 2,
            itemWidth: 172,
            scrollLock: true,
            draggable: true,
            rewind: true,
            arrows: {
                prev: ".ja-prev",
                next: ".ja-next"
            },
            responsive: [
                {
                    breakpoint: 400,
                    settings: {
                        itemWidth: 197,
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 499,
                    settings: {
                        itemWidth: 160,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 550,
                    settings: {
                        itemWidth: 170,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        itemWidth: 170,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 760,
                    settings: {
                        itemWidth: 180,
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                }
            ]
        });

        this.hideFFScrollbars();
    }
}
