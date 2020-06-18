<div class="product__card">
    <div class="product__image">
        <img src="./img/product/<?php echo e($item["product_id"]); ?>.jpg" alt="Product Image">
        <div class="image__overlay"></div>
    </div>

    <div class="product__details">
        <span class="product__name"><?php echo e($item["description"]); ?></span>
        <div class="product__price">
            <?php if($item["discount"] > 0): ?>
                <span class="product__price--with-discount">
                    <?php echo e($item["price"] - ($item["price"] * ($item["discount"] / 100))); ?>

                </span>
                <span class="product__price--original stroked"><?php echo e($item["price"]); ?></span>
            <?php else: ?>
                <span class="product__price--original"><?php echo e($item["price"]); ?></span>
            <?php endif; ?>
        </div>

        <div class="product__options">
            <button class="btn btn--blank black transparent">View details</button>
            <button class="btn btn--primary mt-2">Add to cart</button>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/product_card.blade.php ENDPATH**/ ?>