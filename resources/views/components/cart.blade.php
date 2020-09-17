@php
    if (isset($session["user"]))
        $cart = App\Controller\Products::getCart();
@endphp

<div class="cart-content">
    @if (isset($cart))
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
            @foreach ($cart as $item)
            <tr>
                <td data-label="Image">
                    <img src="./img/product/{{ $item->product_id }}.jpg" alt="{{ $item->description }}">
                </td>
                <td data-label="Item">
                    <div class="cart-item-info">
                        <span class="description"> {{ $item->description }} </span>
                        <span class="extra">
                            Size: {{ $item->size }}. Product code: {{ $item->product_id }}
                        </span>
                    </div>
                </td>
                <td data-label="Price">
                    @if ($item->discount > 0)
                        ${{ $item->price - ($item->price * ($item->discount / 100)) }}
                    @else
                        ${{ $item->price }}
                    @endif
                </td>
                <td data-label="Qty">
                    {{ $item->quantity }}
                </td>
                <td data-label="Subtotal">
                    ${{ $item->subtotal }}
                </td>
                <td data-label="RemoveButton">
                    <i class="fas fa-times-circle red"></i>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Endof cart format -->
    @else
    Your cart is empty we
    @endif
</div>
<div class="cart-action-buttons">
    <form action="proceed-checkout" method="post" class="cart-form">
        <span class="cart-total">
            <i class="fas fa-shopping-bag"></i>
            Total items: <span>${{ $item->subtotal }}</span>
        </span>
        <button type="submit" class="btn btn--primary">Proceed to checkout</button>
    </form>
</div>