<nav id="menu" class="menu">
    <div class="container menu__links">
        <div class="brand">
            <a href="/shoppingcart">
                <picture>
                    <source srcset="./img/brand/isotipo.png" media="(max-width: 768px)">
                    <source srcset="./img/brand/logotipo.png" media="(min-width: 769px)">
                    <img src="./img/brand/logotipo.png" alt="Company logo">
                </picture>
            </a>
        </div>

        <div class="links">
            <a href="https://github.com/crjoseabraham/shoppingcart" target="_blank" class="simple icon-link">
                <i class="fab fa-github"></i>
            </a>
            <a href="explore-all" class="simple">Explore</a>
            @if (isset($session["user"]))
                <a href="cart-checkout" class="simple">Cart</a>
                <a href="profile" class="simple">Profile</a>
                <form action="logout" method="post" class="link-form">
                    <button type="submit" class="btn btn--simple">
                        Log Out
                    </button>
                </form>
            @else
                <a href="#" class="simple" data-action="login">Sign In</a>
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
    </div>
</nav>