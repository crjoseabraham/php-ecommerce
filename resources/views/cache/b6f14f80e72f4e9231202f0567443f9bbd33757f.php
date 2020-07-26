<nav id="menu" class="menu">
    <div class="container menu__responsive">
        <button><i class="fas fa-bars"></i></button>
        <a href="#" class="menu__brand">
            <img src="./img/brand/isotipo.png" alt="Company logo" class="menu__logo"/>
        </a>
        <button><i class="fas fa-user"></i></button>
    </div>

    <div class="container menu__links">
        <div class="brand">
            <a href="#"> <img src="./img/brand/logotipo.png" alt="Company logo"/> </a>
        </div>

        <div class="links">
            <a href="https://github.com/crjoseabraham/shoppingcart" target="_blank" class="simple icon-link">
                <i class="fab fa-github"></i>
            </a>
            <a href="#" class="simple icon-link">
                <i class="fas fa-shopping-cart" data-popup="cart"></i>
            </a>
            <a href="#" class="simple icon-link">
                <i class="fas fa-user" data-popup="<?php echo e(isset($session["user"]) ? "user" : "login"); ?>"></i>
            </a>
            <?php if(isset($session["user"])): ?>
            <form action="logout" method="post" class="link-form">
                <button type="submit" class="btn btn--icon">
                    <i class="fas fa-power-off"></i>
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>

    <div class="container menu__popup">
        <button id="close-popup" class="btn btn--link">
            <i class="fas fa-times"></i>
        </button>
        <div class="popup__content" data-popupname="user">
            Hello, user with the id <?php echo e($session["user"]); ?>

        </div>
        <div class="popup__content" data-popupname="login">
            <?php echo $__env->make('components/login_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="popup__content" data-popupname="signup">
            <?php echo $__env->make('components/register_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="popup__content" data-popupname="cart">
            <?php echo $__env->make('components/cart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/sections/navbar.blade.php ENDPATH**/ ?>