<section class="container best-sellers">
    <div class="carousel-group">
        <h4 class="section-title">Best Sellers</h4>

        <div class="glider-contain multiple-items mt-2">
            <div class="best-sellers-carousel glider-wrap">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('components.product_card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <button aria-label="Previous" class="glider-prev best-prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button aria-label="Next" class="glider-next best-next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <div class="carousel-group">
        <h4 class="section-title">New Arrivals</h4>

        <div class="glider-contain multiple-items mt-2">
            <div class="just-arrived-carousel glider-wrap">
                <?php $__currentLoopData = $products2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('components.product_card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <button aria-label="Previous" class="glider-prev ja-prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button aria-label="Next" class="glider-next ja-next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/sections/best_sellers.blade.php ENDPATH**/ ?>