<section class="container newsletter">
    <div class="newsletter__container">
        <div class="newsletter__background"></div>
        <div class="newsletter__form">
            <h2>Subscribe to our newsletter!</h2>
            <p>Enter your email in the following input so you can be notified of upcoming apparel and offers:</p>
            <form action="subscribe" class="mt-2" method="post">
                <!-- Email -->
                <div class="form-group">
                    <label for="newsletter_email">Email address</label>
                    <div class="input-group">
                        <input type="email" name="email" id="newsletter_email" placeholder="Enter your email">
                        <i class="validation-status fas fa-times-circle"></i>
                    </div>
                    <p class="input-errors"> Invalid email address </p>
                </div>
                <button class="btn btn--primary mt-2" type="submit">Submit</button>
            </form>
        </div>
    </div>
</section>