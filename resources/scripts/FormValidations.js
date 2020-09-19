export default class FormValidations {
    constructor() {
        this.regex = {
            name: /^[a-zA-ZÀ-ÿ ]{2,60}$/,
            email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z]+$/,
            password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{4,}$/
        };
    }

    setFormData(form) {
        this.form = form;
        this.form_fields = new Object();
        this.form_inputs = this.form.querySelectorAll('input:not([type="checkbox"])');
        this.form_inputs.forEach((input) => {
            this.form_fields[input.name] = false;
        });
    }

    hasErrors() {
        for (let key in this.form_fields) {
            if (!this.form_fields[key]) return true;
        }
        return false;
    }

    validateOnSubmit() {
        this.form_inputs.forEach((input) => {
            if (input.name === "passwordConfirmation") this.passwordConfirmation();
            else
                this.form_fields[input.name] = !!this.regex[input.name].test(
                    input.value.trim()
                );
        });
    }

    validateForCart() {
        let checked = Array.from(this.form_inputs).find((input) => input.checked);
        let child = this.form_inputs[0];

        if (!(checked === undefined)) this.form_fields.size = true;
    }

    passwordConfirmation() {
        let passConfirmation = Array.from(this.form_inputs).find(
            (input) => input.name === "passwordConfirmation"
        );
        let password = Array.from(this.form_inputs).find(
            (input) => input.name === "password"
        );

        if (passConfirmation.value === "" || passConfirmation.value !== password.value)
            this.form_fields.passwordConfirmation = false;
        else this.form_fields.passwordConfirmation = true;
    }

    displayInputStatus() {
        this.form_inputs.forEach((input) => {
            let form_group = input.closest(".form-group");
            let input_icon = form_group.querySelector(`input[name=${input.name}] + i`);

            if (!this.form_fields[input.name]) {
                // Error status
                form_group.classList.remove("correct");
                form_group.classList.add("incorrect");
                form_group.querySelector(".input-errors").classList.add("active");
                if (!(input_icon === null)) {
                    input_icon.classList.add("fa-times-circle");
                    input_icon.classList.remove("fa-check-circle");
                }
            } else {
                // Correct status
                form_group.classList.remove("incorrect");
                form_group.querySelector(".input-errors").classList.remove("active");
                form_group.classList.add("correct");
                if (!(input_icon === null)) {
                    input_icon.classList.remove("fa-times-circle");
                    input_icon.classList.add("fa-check-circle");
                }
            }
        });
    }
}
