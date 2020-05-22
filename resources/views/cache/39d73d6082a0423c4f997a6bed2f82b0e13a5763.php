<div class="modal" id="modal">
    <div class="modal__content">
        <button id="close-modal" class="btn btn--link"><i class="fas fa-times"></i></button>
        <!-- Display/Hide content for a specific template -->
        <div class="template" data-template="login_form">
            <?php echo $__env->make('components.login_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="template" data-template="register_form">
            <?php echo $__env->make('components.register_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div><?php /**PATH /var/www/html/shoppingcart/resources/views/components/modal.blade.php ENDPATH**/ ?>