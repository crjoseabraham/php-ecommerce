<a href="product_details.<?php echo e($item->product_id); ?>">
    <div class="product__card">
        <div class="product__card-image-container">
            <?php if($item->discount > 0): ?>
            <span class="discount-badge">
                <?php echo e($item->discount); ?>% <br> <p>OFF</p>
            </span>
            <?php endif; ?>
            <img src="./img/product/<?php echo e($item->product_id); ?>.jpg" alt="<?php echo e($item->description); ?>">
        </div>

        <div class="product__card-details-container">
            <p class="description"><?php echo e($item->description); ?></p>
            <div class="price-container">
                <?php if($item->discount > 0): ?>
                    <span class="price-with-discount">
                        $<?php echo e(App\Controller\Merchandise\Products::calculateDiscount($item)); ?>

                    </span>
                    <span class="original-price">(lowered from $<?php echo e($item->price); ?>)</span>
                <?php else: ?>
                    <span class="original-price">$<?php echo e($item->price); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</a><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/product_card.blade.php ENDPATH**/ ?>