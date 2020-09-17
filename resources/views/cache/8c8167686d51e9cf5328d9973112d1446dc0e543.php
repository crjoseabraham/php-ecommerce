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
                <th>&nbsp;</th>
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
                <td data-label="Image">
                    <img src="./img/product/<?php echo e($item->product_id); ?>.jpg" alt="<?php echo e($item->description); ?>">
                </td>
                <td data-label="Item">
                    <div class="cart-item-info">
                        <span class="description"> <?php echo e($item->description); ?> </span>
                        <span class="extra">
                            Size: <?php echo e($item->size); ?>. Product code: <?php echo e($item->product_id); ?>

                        </span>
                    </div>
                </td>
                <td data-label="Price">
                    <?php if($item->discount > 0): ?>
                        $<?php echo e($item->price - ($item->price * ($item->discount / 100))); ?>

                    <?php else: ?>
                        $<?php echo e($item->price); ?>

                    <?php endif; ?>
                </td>
                <td data-label="Qty">
                    <?php echo e($item->quantity); ?>

                </td>
                <td data-label="Subtotal">
                    $<?php echo e($item->subtotal); ?>

                </td>
                <td data-label="RemoveButton">
                    <i class="fas fa-times-circle red"></i>
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
            Total items: <span>$<?php echo e($item->subtotal); ?></span>
        </span>
        <button type="submit" class="btn btn--primary">Proceed to checkout</button>
    </form>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/cart.blade.php ENDPATH**/ ?>