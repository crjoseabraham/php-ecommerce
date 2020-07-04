<div class="select-boxes__wrapper">
    <!-- Size selctor -->
    <ul class="select--default">
        <li>
            <div class="option selected">
                <?php echo e($sizes[0]); ?>

            </div>
            <p class="select--title">Size</p>
            <span class="arrow"></span>
        </li>
    </ul>

    <ul class="select--options">
        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <div class="option">
                <?php echo e($size); ?>

            </div>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>

<!-- Quantity --><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/item_options_select_boxes.blade.php ENDPATH**/ ?>