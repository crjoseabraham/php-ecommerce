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
            <a href="https://github.com/crjoseabraham/shoppingcart" target="_blank" class="simple">
                <i class="fab fa-github"></i>
            </a>
            <a href="#" class="simple" data-popup="login">Log In</a>
            <a href="#" class="simple" data-popup="signup">Sign Up</a>
        </div>
    </div>

    <div class="container menu__popup">
        <button id="close-popup" class="btn btn--link"><i class="fas fa-times"></i></button>

        <div class="popup__content" data-popupname="login">
            <?php echo $__env->make('components/login_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="popup__content" data-popupname="signup">
            <?php echo $__env->make('components/register_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        
    </div>
</nav><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/sections/navbar.blade.php ENDPATH**/ ?>