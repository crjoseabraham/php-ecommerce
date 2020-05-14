<div class="modal" id="modal">
    this is the modal bitch
    <div class="modal__content" data-template="login">
        <button id="close-modal" class="btn btn--link"><i class="fas fa-times"></i></button>
        <?php echo $__env->make('components.login_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="modal__content" data-template="register">
        <button id="close-modal" class="btn btn--link"><i class="fas fa-times"></i></button>
        
        REEG
    </div>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/nav_modal.blade.php ENDPATH**/ ?>