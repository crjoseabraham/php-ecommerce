<div class="glider-contain single-item">
    <div class="items-with-discount glider-wrap">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($item->discount > 0): ?>
                <?php echo $__env->make('components.product_card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <button aria-label="Previous" class="glider-prev">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button aria-label="Next" class="glider-next">
        <i class="fas fa-chevron-right"></i>
    </button>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/sections/items_w_discount.blade.php ENDPATH**/ ?>