<?php
    if (isset($session["user"]))
        $cart = App\Controller\Products::getCart();
?>

<div class="cart-content">
    <?php if(isset($cart)): ?>
    <!-- Start cart format -->
    <table>
        <caption>Your shopping cart</caption>
        <thead>
            <tr>
                <th class="image-thead">&nbsp;</th>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="image-tbody">
                    <img src="./img/product/<?php echo e($item->product_id); ?>.jpg" alt="<?php echo e($item->description); ?>">
                </td>
                <td class="cart-item-details">
                    <div class="cart-item-info">
                        <span class="description"> <?php echo e($item->description); ?> </span>
                        <span class="extra">
                            Size: <?php echo e($item->size); ?>. Product code: <?php echo e($item->product_id); ?>

                        </span>
                    </div>
                </td>
                <td>
                    <?php if($item->discount > 0): ?>
                        $<?php echo e(round($item->price - ($item->price * ($item->discount / 100)), 2)); ?>

                    <?php else: ?>
                        $<?php echo e($item->price); ?>

                    <?php endif; ?>
                </td>
                <td data-label="Quantity:&nbsp;">
                    <?php echo e($item->quantity); ?>

                </td>
                <td class="cart-subtotal">
                    $<?php echo e($item->subtotal); ?>

                </td>
                <td class="cart-remove-btn">
                    <button class="remove-btn" id="cart-remove-btn" data-item="<?php echo e($item->product_id); ?>">
                        Remove
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <!-- Endof cart format -->
    <?php else: ?>
    Your cart is empty we
    <?php endif; ?>
</div>
<div class="cart-action-buttons">
    <form action="proceed-checkout" method="post" class="cart-form">
        <span class="cart-total">
            <i class="fas fa-shopping-bag"></i>
            Total items: <span>$<?php echo e(round(array_sum(array_column((array) $cart, 'subtotal')), 2)); ?></span>
        </span>
        <button type="submit" class="btn btn--primary">Proceed to checkout</button>
    </form>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/cart.blade.php ENDPATH**/ ?>