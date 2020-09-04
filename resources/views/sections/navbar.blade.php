<nav id="menu" class="menu">
    <div class="container menu__responsive">
        <button><i class="fas fa-bars"></i></button>
        <a href="/shoppingcart" class="menu__brand">
            <img src="./img/brand/isotipo.png" alt="Company logo" class="menu__logo"/>
        </a>
        <button><i class="fas fa-user"></i></button>
    </div>

    <div class="container menu__links">
        <div class="brand">
            <a href="/shoppingcart"> <img src="./img/brand/logotipo.png" alt="Company logo"/> </a>
        </div>

        <div class="links">
            <a href="https://github.com/crjoseabraham/shoppingcart" target="_blank" class="simple icon-link">
                <i class="fab fa-github"></i>
            </a>
            <a href="#" class="simple" data-popup="cart"> Cart (0) </a>
            <a href="#" class="simple" data-popup="{{ isset($session["user"]) ? "user" : "login" }}">
                {{ isset($session["user"]) ? "Profile" : "Sign In" }}
            </a>
            @if (isset($session["user"]))
            <form action="logout" method="post" class="link-form">
                <button type="submit" class="btn btn--simple">
                    Log Out
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="container menu__popup">
        <button id="close-popup" class="btn btn--link">
            <i class="fas fa-times"></i>
        </button>
        <div class="popup__content" data-popupname="user">
            Hello, user with the id {{ $session["user"] }}
        </div>
        <div class="popup__content" data-popupname="login">
            @include('components/login_form')
        </div>
        <div class="popup__content" data-popupname="signup">
            @include('components/register_form')
        </div>
        <div class="popup__content" data-popupname="cart">
            @include('components/cart')
        </div>
    </div>
</nav>