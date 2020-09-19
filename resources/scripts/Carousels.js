export default class Carousels {
    // Hide carousels horizontal scrollbar in Firefox
    hideFFScrollbars() {
        document.addEventListener("glider-loaded", hideFFScrollBars);
        document.addEventListener("glider-refresh", hideFFScrollBars);
        function hideFFScrollBars(e) {
            var scrollbarHeight = 17; // Currently 17, may change with updates
            if (/firefox/i.test(navigator.userAgent)) {
                // This is only needed for desktop. FF for mobile uses webkit rendering engine
                if (window.innerWidth > 575) {
                    e.target.parentNode.style.height =
                        e.target.offsetHeight - scrollbarHeight + "px";
                }
            }
        }
    }

    render() {
        let carousel1 = document.querySelector(".items-with-discount");
        let carousel2 = document.querySelector(".best-sellers-carousel");
        let carousel3 = document.querySelector(".just-arrived-carousel");

        if (!(carousel1 === null))
            new Glider(carousel1, {
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

        if (!(carousel2 === null))
            new Glider(carousel2, {
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

        if (!(carousel3 === null))
            new Glider(carousel3, {
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
