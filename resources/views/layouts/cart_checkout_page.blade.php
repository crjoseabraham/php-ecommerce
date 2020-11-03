<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="icon" type="image/png" href="img/brand/favicon.png" />
        <link rel="stylesheet" href="dist/assets/styles/glider.min.css" />
        <link rel="stylesheet" href="dist/assets/styles/main.css" />
        <title>
            Your cart | About the fit
        </title>
    </head>

    <body id="bodyJsPointer">
        <!-- Notification -->
        @include('components.notification')

        <!-- Overlay -->
        <div id="overlay"></div>

        <!-- Navigation bar -->
        @include('sections.navbar')

        @php
            $amount = 0;
            foreach($cart as $item) {
                $amount += $item->subtotal;
            }
        @endphp

        <div class="container cart-checkout" id="cart-checkout">
            <!-- Left side: Cart -->
            <div class="cart-content">
                <h4>Your Shopping Cart</h4>

                @if (count($cart) < 1)
                <p class="empty-cart">
                    <i class="fas fa-shopping-cart"></i> <br>
                    Your cart is empty <br>
                    <span class="small-text">Explore the store and add what you like to your cart</span>
                </p>
                @else
                <table class="cart">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                        <tr data-product="{{ $item->product_id}}">
                                <td>
                                    <div class="product__details">
                                        <img src="./img/product/{{ $item->product_id }}.jpg" alt="{{ $item->description}}">
                                        <div class="product__details-info">
                                            <h5>{{ $item->description }}</h5>
                                            <p>Code: {{ $item->product_id }}</p>
                                            <p>Size: {{ $item->size }}</p>
                                            <button type="button" class="remove-item" id="remove-item">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="product__quantity">
                                        <div class="qty-controls">
                                            <button type="button" id="control-up">
                                                <i class="fas fa-caret-up"></i>
                                            </button>
                                            <button type="button" id="control-down">
                                                <i class="fas fa-caret-down"></i>
                                            </button>
                                        </div>
                                        <input type="number" name="quantity" id="qty-field" value="{{ $item->quantity }}" readonly>
                                    </div>
                                </td>
                                <td>
                                    <span class="product__price" id="product-price">${{ $item->subtotal }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="cart-subtotal">
                    Order subtotal:
                    <p>
                        $
                        <span class="amount" id="cart-total">
                            {{ $amount }}
                        </span>
                    </p>
                </div>
                @endif
            </div>
            <!-- Right side: Payment -->
            <div class="payment-content">
                <div class="payment-content-container">
                    <h4>Order Summary</h4>
                    <form action="payment-process" id="start-payment" method="post">
                        <table class="order-details">
                            <tbody>
                                <tr>
                                    <td>Cart subtotal</td>
                                    <td>$<span id="payment-cart-total"> {{ $amount }} </span></td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>
                                        <select name="shipping" id="shipping">
                                            <option value="0" selected>Pick up at store</option>
                                            <option value="7">Delivery (+7% fee)</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td>$ <span id="tax">0</span></td>
                                </tr>
                                <tr>
                                    <td class="strong">Order Total</td>
                                    <td>$<span id="order-total">{{ $amount }}</span></td>
                                </tr>
                            </tbody>
                        </table>

                        @if (count($cart) > 0)
                        <button type="submit" class="btn btn--primary" id="pay">
                            Pay with &nbsp;<i class="fab fa-paypal"></i> PayPal
                        </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('sections.footer')

        <script
            src="https://kit.fontawesome.com/eea5dcc8ef.js"
            crossorigin="anonymous"
        ></script>
        <script src="dist/assets/js/app.js"></script>
    </body>
</html>