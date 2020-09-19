<nav id="menu" class="menu">
    <div class="container menu__links">
        <div class="brand">
            <a href="/shoppingcart">
                <img src="./img/brand/logotipo.png" alt="Company logo"/>
            </a>
        </div>

        <div class="links">
            <a href="https://github.com/crjoseabraham/shoppingcart" target="_blank" class="simple icon-link">
                <i class="fab fa-github"></i>
            </a>
            <a href="#" class="simple" data-action="cart">
                Cart {{ isset($session["user"]) ? "(".count(App\Controller\Products::getCart()).")" : "" }}
            </a>
            <a
                href="{{ isset($session["user"]) ? "profile" : '#' }}"
                class="simple"
                {{ !isset($session["user"]) ? "data-action=login" : '' }}
            >
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
        <div class="popup__content" data-action="login">
            @include('components/login_form')
        </div>
        <div class="popup__content" data-action="signup">
            @include('components/register_form')
        </div>
        <div class="popup__content" data-action="cart">
            @include('components/cart')
        </div>
    </div>
</nav>