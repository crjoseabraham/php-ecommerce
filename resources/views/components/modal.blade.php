<div class="modal" id="modal">
    <div class="modal__content">
        <button id="close-modal" class="btn btn--link"><i class="fas fa-times"></i></button>
        <!-- Display/Hide content for a specific template -->
        <div class="template" data-template="login_form">
            @include('components.login_form')
        </div>

        <div class="template" data-template="register_form">
            @include('components.register_form')
        </div>
    </div>
</div>