<!-- Size selctor -->
<div class="select-box__wrapper">
    <ul class="select--default" id="selectSize">
        <li>
            <div class="option selected">
                <?php echo e($sizes[0]); ?>

            </div>
            <span class="arrow">
                <i class="fas fa-angle-down"></i>
            </span>
            <p class="select--title">Size</p>
        </li>
    </ul>

    <ul class="select--options" data-selectbox="selectSize">
        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <div class="option">
                <?php echo e($size); ?>

            </div>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>

<!-- Quantity -->
<div class="select-box__wrapper">
    <ul class="select--default"  id="selectQuantity">
        <li>
            <div class="option selected">
                1
            </div>
            <span class="arrow">
                <i class="fas fa-angle-down"></i>
            </span>
            <p class="select--title">Quantity</p>
        </li>
    </ul>

    <ul class="select--options" data-selectbox="selectQuantity">
        <li>
            <div class="option">
                Ay wey
            </div>
        </li>
    </ul>
</div><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/item_options_select_boxes.blade.php ENDPATH**/ ?>