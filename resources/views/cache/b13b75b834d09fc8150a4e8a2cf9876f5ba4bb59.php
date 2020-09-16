<section class="container special-offers">
    <div class="special-offers__block--left center">
        <h2 class="serif">Special Offers!</h2>
        <p class="mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium cum deleniti, reprehenderit fugit sunt tenetur exercitationem voluptate numquam commodi. Tenetur! <br><br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui odio blanditiis, libero officia debitis consequatur?</p>
        <span class="discount">-30%</span>
    </div>
    <div class="special-offers__block--right">
        <?php echo $__env->make('sections.items_w_discount', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</section><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/sections/offers.blade.php ENDPATH**/ ?>