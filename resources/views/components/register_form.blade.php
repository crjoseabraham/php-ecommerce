<div class="popup_signup">
    <h3>Become a Member</h3>
    <p class="mt-2">Become a Member — you'll enjoy exclusive deals, offers, invites and rewards.</p>

    <form action="signup" method="post" id="register_form">
        <div class="input-group">
            <label for="signup_name">What's your name?</label>
            <input type="text" name="signup_name" id="signup_name" placeholder="Monica Hall">

            <label for="signup_email">Your email:</label>
            <input type="email" name="signup_email" id="signup_email" placeholder="e.g. monicahall@piedpiper.com">
        </div>

        <div class="input-group">
            <label for="pass">Create a password: <span class="warning">Password must contain at least 6 characters, 1 capital letter and 1 number</span></label>
            <input type="password" name="password" id="pass">

            <label for="passconf">Confirm your password:</label>
            <input type="password" name="password_confirmation" id="passconf">
        </div>

        <button type="submit" class="btn btn--primary">Sign Up</button>
    </form>
</div>