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
            <a href="#" class="simple" data-popup="cart">
                Cart <?php echo e(isset($session["user"]) ? "(".count(App\Controller\Products::getCart()).")" : ""); ?>

            </a>
            <a
                href="<?php echo e(isset($session["user"]) ? "profile" : '#'); ?>"
                class="simple"
                <?php echo e(!isset($session["user"]) ? "data-popup=login" : ''); ?>

            >
                <?php echo e(isset($session["user"]) ? "Profile" : "Sign In"); ?>

            </a>
            <?php if(isset($session["user"])): ?>
            <form action="logout" method="post" class="link-form">
                <button type="submit" class="btn btn--simple">
                    Log Out
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