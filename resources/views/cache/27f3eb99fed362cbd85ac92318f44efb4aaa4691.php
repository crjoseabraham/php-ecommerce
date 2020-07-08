<div class="item-details__picture">
    <img src="./img/product/<?php echo e($product_id); ?>.jpg" alt="<?php echo e($description); ?>">
</div>
<div class="item-details__info">
    <!-- Title and price -->
    <h3 class="sans fs20"><?php echo e($description); ?></h3>
    <h4 class="sans fs20">$<?php echo e($price); ?></h4>
    <!-- Star rating system -->
    <form action="rate-item/<?php echo e($product_id); ?>" class="rating">
        <button type="submit" class="btn btn--mini ml-2">Submit Vote</button>

        <input type="radio" id="star5" name="rating" value="5" />
        <label class="full" for="star5" title="Awesome - 5 stars"></label>

        <input type="radio" id="star4" name="rating" value="4" />
        <label class="full" for="star4" title="Good - 4 stars"></label>

        <input type="radio" id="star3" name="rating" value="3" />
        <label class="full" for="star3" title="It's Ok - 3 stars"></label>

        <input type="radio" id="star2" name="rating" value="2" />
        <label class="full" for="star2" title="Bad - 2 stars"></label>

        <input type="radio" id="star1" name="rating" value="1" />
        <label class="full" for="star1" title="Awful - 1 star"></label>
    </form>
    <!-- Rating votes count -->
    <span class="rating-votes">Score: <?php echo e($rating); ?> from 555 votes</span>

    <!-- Options and button to add to the cart -->
    <form action="cart/add/<?php echo e($product_id); ?>" method="post" class="add-to-cart">
        <div class="select-boxes-container mt-2">
            <?php echo $__env->make('components/item_options_select_boxes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <input type="hidden" name="size" id="size" value="<?php echo e($sizes[0]); ?>">
        <input type="hidden" name="quantity" id="quantity" value="1">
        <button type="submit" class="btn btn--primary"> Add to cart</button>
    </form>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/item_details.blade.php ENDPATH**/ ?>