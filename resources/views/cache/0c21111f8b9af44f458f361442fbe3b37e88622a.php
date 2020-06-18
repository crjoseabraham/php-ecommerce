<section class="container special-offers">
    <div class="special-offers__block--left center ph8">
        <h2 class="serif upper fs32">Special Offers!</h2>
        <p class="upper fs18 mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium cum deleniti, reprehenderit fugit sunt tenetur exercitationem voluptate numquam commodi. Tenetur! <br><br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui odio blanditiis, libero officia debitis consequatur?</p>
        <span class="discount">-30%</span>
    </div>
    <div class="special-offers__block--right">
        <?php echo $__env->make('components.items_w_discount', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</section><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/offers.blade.php ENDPATH**/ ?>