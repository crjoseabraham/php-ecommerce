<?php if(isset($user)): ?>
<div class="cart-content"> </div>
<div class="cart-footer">
    <span class="cart-total">
        <i class="fas fa-shopping-bag"></i>
        Total items: $<span id="total-items"></span>
    </span>
    <a href="checkout-page" class="btn btn--primary">Proceed to checkout</a>
</div>
<?php else: ?>
<div class="cart-content empty">
    <i class="fas fa-exclamation-circle"></i>
    Your cart is empty
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/cart.blade.php ENDPATH**/ ?>