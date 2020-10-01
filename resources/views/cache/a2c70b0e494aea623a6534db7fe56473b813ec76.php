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
            <?php echo e($item->description); ?> | About the Fit
        </title>
    </head>

    <body id="bodyJsPointer">
        <!-- Notification -->
        <?php echo $__env->make('components.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Overlay -->
        <div id="overlay"></div>
        <!-- Navigation bar -->
        <?php echo $__env->make('sections.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!--                Product details                     -->
        <div class="container">
            <div class="product-container">
                <div class="product-container__img">
                    <img src="./img/product/<?php echo e($item->product_id); ?>.jpg" alt="<?php echo e($item->description); ?>">
                </div>
                <div class="product-container__details">
                    <h2 class="sans"><?php echo e($item->description); ?></h2>
                    <p class="product-code">Code: <?php echo e($item->product_id); ?></p>
                    <div class="product-price mt-2">
                        <?php if($item->discount > 0): ?>
                        <h2 class="price-to-show sans">
                            $<?php echo e(App\Controller\Merchandise\Products::calculateDiscount($item)); ?>

                        </h2>
                        <h3 class="original-price sans">
                            (lowered from $<?php echo e($item->price); ?>)
                        </h3>
                        <?php else: ?>
                        <h2 class="price-to-show sans">$<?php echo e($item->price); ?></h2>
                        <?php endif; ?>
                    </div>
                    <p class="description mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio voluptatum excepturi ex sequi impedit odio voluptas eaque, doloremque deleniti assumenda!</p>

                    <!-- "Add to cart" form start -->
                    <form action="add-to-cart.<?php echo e($item->product_id); ?>" method="post" id="add-to-cart">
                        <?php if(!empty($item->sizes)): ?>
                        <div class="sizes mt-2 form-group">
                            <h5 class="details-title sans">Select your size:</h5> <br>
                            <div class="input-group">
                            <?php $__currentLoopData = $item->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="radio" name="size" id="size-<?php echo e($size); ?>" value="<?php echo e($size); ?>">
                                <label for="size-<?php echo e($size); ?>"><?php echo e($size); ?></label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <p class="input-errors">
                                Please select a size
                            </p>
                        </div>
                        <?php endif; ?>

                        <h5 class="details-title mt-2 sans">Select quantity:</h5>
                        <select name="quantity" id="quantity-selectbox">
                            <?php for($i = 1; $i <= 20; $i++): ?>
                                <?php if($i === 1): ?>
                                <option value="<?php echo e($i); ?>" selected> <?php echo e($i); ?> </option>
                                <?php else: ?>
                                <option value="<?php echo e($i); ?>"> <?php echo e($i); ?> </option>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </select>

                        <button type="submit" class="btn btn--primary mt-2">
                            <i class="fas fa-shopping-bag"></i>
                            &nbsp; Add to cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!--                Product details end                 -->

        <!-- Footer -->
        <?php echo $__env->make('sections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <script
            src="https://kit.fontawesome.com/eea5dcc8ef.js"
            crossorigin="anonymous"
        ></script>
        <script src="dist/assets/js/app.js"></script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/layouts/product_details.blade.php ENDPATH**/ ?>