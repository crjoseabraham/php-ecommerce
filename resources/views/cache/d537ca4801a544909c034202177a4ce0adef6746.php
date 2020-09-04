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
            Recover your password | About the fit
        </title>
    </head>

    <body id="bodyJsPointer">
        <!-- Notification -->
        <?php echo $__env->make('components.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Overlay -->
        <div id="overlay"></div>

        <!-- Navigation bar -->
        <?php echo $__env->make('sections.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Actual content -->
        <div class="container">
            <div class="forget-password__form">
                <h2 class="black">Forgot your password?</h2>
                <p>Please enter the email address you used to create your account, and we'll send you a link to reset your password.</p>
                <form action="request-password-reset" method="post">
                    <div class="form-group">
                        <label for="fp_email">Email address</label>
                        <div class="input-group">
                            <input type="email" name="email" id="fp_email" autofocus>
                            <i class="validation-status fas fa-times-circle"></i>
                        </div>
                        <p class="input-errors">
                            The email address you entered is invalid or it wasn't found in our database.
                        </p>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn--primary">
                            Send link
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?php echo $__env->make('sections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <script
            src="https://kit.fontawesome.com/eea5dcc8ef.js"
            crossorigin="anonymous"
        ></script>
        <script src="dist/assets/js/glider.min.js"></script>
        <script src="dist/assets/js/app.js"></script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/layouts/forget_password.blade.php ENDPATH**/ ?>