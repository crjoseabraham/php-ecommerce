@if (isset($user))
<div class="cart-content"> </div>
<div class="cart-footer">
    <form action="proceed-checkout" method="post" class="cart-form">
        <span class="cart-total">
            <i class="fas fa-shopping-bag"></i>
            Total items: $<span id="total-items"></span>
        </span>
        <button type="submit" class="btn btn--primary">Proceed to checkout</button>
    </form>
</div>
@else
<div class="cart-content empty">
    <i class="fas fa-exclamation-circle"></i>
    Your cart is empty
</div>
@endif