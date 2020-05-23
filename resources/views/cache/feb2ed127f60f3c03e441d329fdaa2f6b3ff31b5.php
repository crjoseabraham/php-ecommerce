<div class="modal__title">
    <h3>Welcome back</h3>
    <p>Become a Member — you'll enjoy exclusive deals, offers, invites and rewards.</p>
</div>

<form action="login" method="post" id="login_form" class="mt-4">
    <label for="email">Email</label>
    <input type="email" name="email" id="email">

    <label for="pass">Password</label>
    <input type="password" name="password" id="pass">

    <div class="inline-sb mt-2">
        <div class="inline-group">
            <input type="checkbox" name="remember_me" id="checkbox">
            <label for="checkbox">Keep me signed in</label>
        </div>
        <div class="inline">
            <a href="#" class="simple">I forgot my password</a>
        </div>
    </div>

    <button type="submit" class="btn btn--primary mt-4">Log In</button>
</form><?php /**PATH /var/www/html/shoppingcart/resources/views/components/login_form.blade.php ENDPATH**/ ?>