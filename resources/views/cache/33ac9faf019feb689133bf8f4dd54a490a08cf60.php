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
            About the fit | An ecommerce app made with PHP and vanilla JS
        </title>
    </head>

    <body id="bodyJsPointer">
        <!-- Notification -->
        <?php echo $__env->make('components.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Overlay -->
        <div id="overlay"></div>

        <!-- Navigation bar -->
        <?php echo $__env->make('sections.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Header -->
        <?php echo $__env->make('sections.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Special offers -->
        <?php echo $__env->make('sections.offers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Instagram banner -->
        <?php echo $__env->make('sections.banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Best Sellers and New pieces -->
        <?php echo $__env->make('sections.best_sellers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Blog -->
        <?php echo $__env->make('sections.blog', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Newsletter -->
        <?php echo $__env->make('sections.newsletter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Footer -->
        <?php echo $__env->make('sections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <script
            src="https://kit.fontawesome.com/eea5dcc8ef.js"
            crossorigin="anonymous"
        ></script>
        <script src="dist/assets/js/glider.min.js"></script>
        <script src="dist/assets/js/app.js"></script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/layouts/home.blade.php ENDPATH**/ ?>