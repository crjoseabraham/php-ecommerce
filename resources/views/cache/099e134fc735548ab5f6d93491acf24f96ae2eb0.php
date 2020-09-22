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
            Your Profile | About the fit
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
        <div class="container profile-container">
            <div class="profile-content">
                <ul class="profile-content__menu">
                    <li class="profile-content__option active" data-action="basic_info">Basic Information</li>
                    <li class="profile-content__option" data-action="change_pass">Change password</li>
                </ul>
                <div class="profile-content__body">
                    <!-- ALWAYS VISIBLE -->
                    <div class="profile-user-data">
                        <h5>Account information:</h5>
                        <table>
                            <tr>
                                <td class="cell-title">
                                    ID:
                                </td>
                                <td><?php echo e($user->id); ?></td>
                            </tr>
                            <tr>
                                <td class="cell-title">
                                    Name:
                                </td>
                                <td><?php echo e($user->name); ?></td>
                            </tr>
                            <tr>
                                <td class="cell-title">
                                    Email:
                                </td>
                                <td><?php echo e($user->email); ?></td>
                            </tr>
                            <tr>
                                <td class="cell-title">
                                    Registered:
                                </td>
                                <td>Sep 17, 2020</td>
                            </tr>
                        </table>
                    </div>
                    <!-- Basic Info -->
                    <div class="profile-template active" data-action="basic_info">
                        <h5>Edit your data:</h5>
                        <form action="update-profile/basic" method="post">
                            <!-- Name -->
                            <div class="form-group">
                                <label for="edit_name">Name</label>
                                <div class="input-group">
                                    <input type="text" name="name" id="edit_name" value="<?php echo e($user->name); ?>">
                                    <i class="validation-status fas fa-times-circle"></i>
                                </div>
                                <p class="input-errors">
                                    Name can only contain letters and must be at least 2 characters long
                                </p>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="edit_email">Email address</label>
                                <div class="input-group">
                                    <input type="email" name="email" id="edit_email" value="<?php echo e($user->email); ?>">
                                    <i class="validation-status fas fa-times-circle"></i>
                                </div>
                                <p class="input-errors"> Invalid email address </p>
                                <p class="input-errors email-taken">This email is already registered</p>
                            </div>

                            <button type="submit" class="btn btn--primary">
                                Save Changes
                            </button>
                        </form>
                    </div>
                    <!-- Change Password -->
                    <div class="profile-template" data-action="change_pass">
                        <h5>Want to change your password?</h5>
                        <p class="center">Password needs at least: 4 characters, 1 uppercase letter, 1 lowercase letter, 1 number</p>
                        <form action="update-profile/password/<?php echo e($user->id); ?>" method="post" class="mt-2">
                            <!-- New Pass -->
                            <div class="form-group">
                                <label for="edit_pass">New password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="edit_pass">
                                    <i class="validation-status fas fa-times-circle"></i>
                                </div>
                                <p class="input-errors">
                                    Password does not meet the requirements
                                </p>
                            </div>

                            <!-- Password Confirmation -->
                            <div class="form-group">
                                <label for="edit_passConf">Confirm password</label>
                                <div class="input-group">
                                    <input type="password" name="passwordConfirmation" id="edit_passConf">
                                    <i class="validation-status fas fa-times-circle"></i>
                                </div>
                                <p class="input-errors">Password and confirmation don't match</p>
                            </div>

                            <button type="submit" class="btn btn--primary">
                                Save Changes
                            </button>
                        </form>
                    </div>

                    <div class="mt-2 profile-delete">
                        <a href="confirm-delete-account" class="simple red">Delete your account</a>
                    </div>
                </div>
            </div>

            <div class="profile-content">
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
</html><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/layouts/profile.blade.php ENDPATH**/ ?>