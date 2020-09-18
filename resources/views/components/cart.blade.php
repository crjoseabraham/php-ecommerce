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
                <th class="image-thead">&nbsp;</th>
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
                <td class="image-tbody">
                    <img src="./img/product/{{ $item->product_id }}.jpg" alt="{{ $item->description }}">
                </td>
                <td class="cart-item-details">
                    <div class="cart-item-info">
                        <span class="description"> {{ $item->description }} </span>
                        <span class="extra">
                            Size: {{ $item->size }}. Product code: {{ $item->product_id }}
                        </span>
                    </div>
                </td>
                <td>
                    @if ($item->discount > 0)
                        ${{ round($item->price - ($item->price * ($item->discount / 100)), 2) }}
                    @else
                        ${{ $item->price }}
                    @endif
                </td>
                <td data-label="Quantity:&nbsp;">
                    {{ $item->quantity }}
                </td>
                <td class="cart-subtotal">
                    ${{ $item->subtotal }}
                </td>
                <td class="cart-remove-btn">
                    <button class="remove-btn" id="cart-remove-btn" data-item="{{ $item->product_id }}">
                        Remove
                    </button>
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
            Total items: <span>${{ round(array_sum(array_column((array) $cart, 'subtotal')), 2) }}</span>
        </span>
        <button type="submit" class="btn btn--primary">Proceed to checkout</button>
    </form>
</div>