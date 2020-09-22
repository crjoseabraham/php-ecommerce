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
                Cart (<span id='cart-counter'><?php echo e(isset($session["user"]) ? count(App\Controller\Merchandise\Products::getCart()) : "0"); ?></span>)
            </a>
            <a
                href="<?php echo e(isset($session["user"]) ? "profile" : '#'); ?>"
                class="simple"
                <?php echo e(!isset($session["user"]) ? "data-action=login" : ''); ?>

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
        <div class="popup__content" data-action="login">
            <?php echo $__env->make('components/login_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="popup__content" data-action="signup">
            <?php echo $__env->make('components/register_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="popup__content" data-action="cart">
            <?php echo $__env->make('components/cart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/sections/navbar.blade.php ENDPATH**/ ?>