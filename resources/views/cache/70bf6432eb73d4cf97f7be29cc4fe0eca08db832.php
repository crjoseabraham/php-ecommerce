<div class="product__card" data-popup="item/<?php echo e($item["product_id"]); ?>/details" data-http="true">
    <div class="product__card-image-container">
        <img src="./img/product/<?php echo e($item["product_id"]); ?>.jpg" alt="<?php echo e($item["description"]); ?>">
        <button class="btn btn--primary" data-popup="item/<?php echo e($item["product_id"]); ?>/details" data-http="true">
            View details
        </button>
    </div>

    <div class="product__card-details-container">
        <p class="description"><?php echo e($item["description"]); ?></p>
        <div class="price-container">
            <?php if($item["discount"] > 0): ?>
                <span class="price-with-discount">
                    $ <?php echo e($item["price"] - ($item["price"] * ($item["discount"] / 100))); ?>

                </span>
                <span class="original-price stroked">$ <?php echo e($item["price"]); ?></span>
            <?php else: ?>
                <span class="original-price">$ <?php echo e($item["price"]); ?></span>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/product_card.blade.php ENDPATH**/ ?>