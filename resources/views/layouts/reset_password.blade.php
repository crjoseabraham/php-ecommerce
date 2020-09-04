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
            Create a new password | About the fit
        </title>
    </head>

    <body id="bodyJsPointer">
        <!-- Notification -->
        @include('components.notification')

        <!-- Overlay -->
        <div id="overlay"></div>

        <!-- Navigation bar -->
        @include('sections.navbar')

        <!-- Actual content -->
        <div class="container">
            <div class="reset-password__form">
                <h2 class="black">Create a new password</h2>
                <p>Enter your new password and confirm. The password needs at least: <br> <strong class="tulip">4 characters, 1 uppercase letter, 1 lowercase letter, 1 number</strong></p>
                <form action="update-forgotten-password_{{ $id }}-{{ $token }}" method="post">
                    <!-- Password -->
                    <div class="form-group">
                        <label for="rp_pass">New password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="rp_pass" autofocus>
                            <i class="validation-status fas fa-times-circle"></i>
                        </div>
                        <p class="input-errors">
                            The password doesn't have the required characters to be valid.
                        </p>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="form-group">
                        <label for="rp_conf">Confirm password</label>
                        <div class="input-group">
                            <input type="password" name="passwordConfirmation" id="rp_conf">
                            <i class="validation-status fas fa-times-circle"></i>
                        </div>
                        <p class="input-errors">Password and confirmation don't match</p>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn--primary">
                            Update password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        @include('sections.footer')

        <script
            src="https://kit.fontawesome.com/eea5dcc8ef.js"
            crossorigin="anonymous"
        ></script>
        {{-- <script src="dist/assets/js/glider.min.js"></script> --}}
        <script src="dist/assets/js/app.js"></script>
    </body>
</html>