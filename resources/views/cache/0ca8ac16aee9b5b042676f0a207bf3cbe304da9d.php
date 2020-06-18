<div class="glider-contain single-item">
    <div class="items-with-discount">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($item["discount"] == 30): ?>
                <?php echo $__env->make('components.product_card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <button aria-label="Previous" class="glider-prev">&lang;</button>
    <button aria-label="Next" class="glider-next">&rang;</button>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/items_w_discount.blade.php ENDPATH**/ ?>