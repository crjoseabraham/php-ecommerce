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
        <?php echo $__env->make('components.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Overlay -->
        <div id="overlay"></div>

        <!-- Navigation bar -->
        <?php echo $__env->make('sections.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="container cart-checkout">
            <!-- Left side: Cart -->
            <div class="cart-content">
                <h4>Your Shopping Cart <span class="count"><?php echo e(count($cart)); ?></span></h4>

                <table class="cart">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="product__details">
                                        <img src="./img/product/<?php echo e($item->product_id); ?>.jpg" alt="<?php echo e($item->description); ?>">
                                        <div class="product__details-info">
                                            <h5><?php echo e($item->description); ?></h5>
                                            <p>Code: <?php echo e($item->product_id); ?></p>
                                            <p>Size: <?php echo e($item->size); ?></p>
                                            <button type="button" class="remove-item" id="remove-item" data-remove="<?php echo e($item->product_id); ?>">
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
                                        <input type="number" name="quantity" id="qty-field" value="<?php echo e($item->quantity); ?>" readonly>
                                    </div>
                                </td>
                                <td>
                                    <span class="product__price">$<?php echo e($item->subtotal); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="cart-subtotal">
                    Order subtotal:
                    <span class="amount">
                        <?php
                            $amount = 0;
                            foreach($cart as $item) {
                                $amount += $item->subtotal;
                            }
                        ?>
                        $<?php echo e($amount); ?>

                    </span>
                </div>
            </div>
            <!-- Right side: Payment -->
            <div class="payment-content">
                <h4>Payment content</h4>
            </div>
        </div>

        <!-- Footer -->
        <?php echo $__env->make('sections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <script
            src="https://kit.fontawesome.com/eea5dcc8ef.js"
            crossorigin="anonymous"
        ></script>
        <script src="dist/assets/js/app.js"></script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/layouts/checkout_page.blade.php ENDPATH**/ ?>