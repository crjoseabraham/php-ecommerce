export default class FormValidations {
    constructor() {
        this.errors = new Object();
        this.form = undefined;
        this.inputs = undefined;

        // Possible error messages
        this.EMPTY_FIELD = "This field is required";
        this.INVALID_NAME = "Name can contain only letters";
        this.INVALID_EMAIL = "Please enter a valid email address";
        this.EMAIL_EXISTS = "This email is already registered";
        this.INVALID_PASS = "Passwords needs at least: 6 characters long, 1 capital letter and 1 number";
        this.MATCH_PASS = "Password and confirmation don't match";
    }

    /**
     * Sort form inputs by type. Set errors array. Start validation process
     * @param  {object} form Pre-submitted form
     */
    process(form) {
        this.form = form;
        this.inputs = form.querySelectorAll(`form[action='${this.form.getAttribute("action")}'] input`);

        this.inputs.forEach(input => {
            this.errors[input.name] = [];

            // Start validation process
            this[input.name](input);
        });

        console.log(this.errors);
    }

    name(input) {
        if (input.value === '') {
            this.errors[input.name].push(this.EMPTY_FIELD);
        }
    }

    email(input) {
        if (input.value === '') {
            this.errors[input.name].push(this.EMPTY_FIELD);
        }   
    }

    password(input) {
        if (input.value === '') {
            this.errors[input.name].push(this.EMPTY_FIELD);
        }
    }

    passwordConfirmation(input) {
        if (input.value === '') {
            this.errors[input.name].push(this.EMPTY_FIELD);
        }
    }
}
