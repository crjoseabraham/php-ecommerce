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
            <a href="explore" class="simple">Explore</a>
            <?php if(isset($session["user"])): ?>
                <a href="cart-checkout" class="simple">Cart</a>
                <a href="profile" class="simple">Profile</a>
                <form action="logout" method="post" class="link-form">
                    <button type="submit" class="btn btn--simple">
                        Log Out
                    </button>
                </form>
            <?php else: ?>
                <a href="#" class="simple" data-action="login">Sign In</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container menu__popup">
        <button id="close-popup" class="btn btn--link">
            <i class="fas fa-times"></i>
        </button>
        <div class="popup__content" data-action="login">
            <?php echo $__env->make('components/login_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="popup__content" data-action="signup">
            <?php echo $__env->make('components/register_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/sections/navbar.blade.php ENDPATH**/ ?>