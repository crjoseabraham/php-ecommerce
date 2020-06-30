<div class="item-details">
    <div class="item-details__picture">
        <img src="./img/product/<?php echo e($product_id); ?>.jpg" alt="<?php echo e($description); ?>">
    </div>
    <div class="item-details__info">
        <h3 class="sans fs16"><?php echo e($description); ?></h3>
        <h4 class="sans fs18 mt-2">$<?php echo e($price); ?></h4>
        <button class="btn btn--primary"> Add to cart</button>
    </div>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/item_details.blade.php ENDPATH**/ ?>