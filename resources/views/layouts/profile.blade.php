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

    <body id="bodyJsPointer" class="light-grey">
        <!-- Notification -->
        @include('components.notification')

        <!-- Navigation bar -->
        @include('sections.navbar')

        <!-- Actual content -->
        <div class="container profile-container">
            <div class="profile-content">
                <!-- Account info -->
                <div class="content-section">
                    <div class="content-title">
                        <span>Account Information</span>
                    </div>
                    <div class="content-body">
                        <table class="account-info">
                            <tbody>
                                <tr>
                                    <td class="title">Account ID:</td>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <td class="title">Name:</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="title">Email Address:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="title">Member since:</td>
                                    <td>Random date</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Edit basic info -->
                <div class="content-section">
                    <div class="content-title">
                        <span>Edit basic information</span>
                    </div>
                    <div class="content-body">
                        <form action="update-profile/basic" method="post">
                            <!-- Name -->
                            <div class="form-group">
                                <label for="edit_name">Name</label>
                                <div class="input-group">
                                    <input type="text" name="name" id="edit_name" value="{{ $user->name }}">
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
                                    <input type="email" name="email" id="edit_email" value="{{ $user->email }}">
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
                </div>
                <!-- Change pass -->
                <div class="content-section">
                    <div class="content-title">
                        <span>Change your password</span>
                    </div>
                    <div class="content-body">
                        <p>Password needs at least: 4 characters, 1 uppercase letter, 1 lowercase letter, 1 number</p>
                        <form action="update-profile/password/{{ $user->id }}" method="post" class="mt-2">
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
                </div>
                <!-- Purchases -->
                <div class="content-section">
                    <div class="content-title">
                        <span>Purchase history</span>
                    </div>
                    <div class="content-body">
                        @if (empty($orders))
                            Your purchases will be listed with full detail below. For now, there's nothing here.
                        @else
                            <table class="purchases">
                                <thead>
                                    <tr>
                                        <td>#ID</td>
                                        <td>Date/Time</td>
                                        <td>Amount</td>
                                        <td>Print</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>${{ $order->amount }}</td>
                                        <td><i class="fas fa-file-download"></i></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('sections.footer')

        <script
            src="https://kit.fontawesome.com/eea5dcc8ef.js"
            crossorigin="anonymous"
        ></script>
        <script src="dist/assets/js/app.js"></script>
    </body>
</html>