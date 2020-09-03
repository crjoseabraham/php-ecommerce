//import HttpRequest from "./HttpRequest";

export default class FormValidations {
    constructor(form) {
        this.form = form;
        this.form_fields = new Object();
        this.form_inputs = this.form.querySelectorAll('input:not([type="checkbox"])');

        this.form_inputs.forEach((input) => {
            this.form_fields[input.name] = false;
        });

        this.regex = {
            name: /^[a-zA-ZÀ-ÿ ]{2,60}$/,
            email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z]+$/,
            password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{4,}$/
        };
    }

    /**
     * Utility: check if form was filled correctly
     */
    noErrors() {
        for (let key in this.form_fields) {
            if (!this.form_fields[key]) return false;
        }
        return true;
    }

    /**
     * Validate a form after clicking "submit" button
     */
    validateSubmit() {
        this.form_inputs.forEach((input) => {
            let regex = this.regex[input.name];
            if (input.name === "passwordConfirmation")
                this.validatePasswordConfirmation();
            else {
                if (regex.test(input.value.trim())) this.form_fields[input.name] = true;
            }
        });

        if (this.noErrors()) {
            this.form.submit();
            this.form.reset();
        } else this.displayStatus();
    }

    /**
     * Validate password confirmation
     */
    validatePasswordConfirmation() {
        let password_confirmation = Array.from(this.form_inputs).find(
            (input) => input.name === "passwordConfirmation"
        );
        let password_input = Array.from(this.form_inputs).find(
            (input) => input.name === "password"
        );

        if (
            password_confirmation.value === "" ||
            password_confirmation.value !== password_input.value
        ) {
            password_confirmation.closest(".form-group").classList.remove("correct");
            password_confirmation.closest(".form-group").classList.add("incorrect");
            password_confirmation.parentElement.nextElementSibling.classList.add(
                "active"
            );
            password_confirmation.nextElementSibling.classList.add("fa-times-circle");
            password_confirmation.nextElementSibling.classList.remove("fa-check-circle");
            this.form_fields.passwordConfirmation = false;
        } else {
            password_confirmation.closest(".form-group").classList.remove("incorrect");
            password_confirmation.closest(".form-group").classList.add("correct");
            password_confirmation.parentElement.nextElementSibling.classList.remove(
                "active"
            );
            password_confirmation.nextElementSibling.classList.remove("fa-times-circle");
            password_confirmation.nextElementSibling.classList.add("fa-check-circle");
            this.form_fields.passwordConfirmation = true;
        }
    }

    /**
     * Display Incorrect/Correct status and message
     */
    displayStatus() {
        this.form_inputs.forEach((input) => {
            if (!this.form_fields[input.name]) {
                input.closest(".form-group").classList.remove("correct");
                input.closest(".form-group").classList.add("incorrect");
                input.parentElement.nextElementSibling.classList.add("active");
                input.nextElementSibling.classList.add("fa-times-circle");
                input.nextElementSibling.classList.remove("fa-check-circle");
            } else {
                input.closest(".form-group").classList.remove("incorrect");
                input.parentElement.nextElementSibling.classList.remove("active");
                input.closest(".form-group").classList.add("correct");
                input.nextElementSibling.classList.remove("fa-times-circle");
                input.nextElementSibling.classList.add("fa-check-circle");
            }
        });
    }

    // ____________________
    // validateField(input) {
    //     if (input.name === "passwordConfirmation") {
    //         this.validatePasswordConfirmation();
    //     } else {
    //         let regex = this.regex[input.name];

    //         if (regex.test(input.value.trim())) {
    //             // Hide errors, display "correct" status
    //             input.closest(".form-group").classList.remove("incorrect");
    //             input.parentElement.nextElementSibling.classList.remove("active");
    //             input.closest(".form-group").classList.add("correct");
    //             input.nextElementSibling.classList.remove("fa-times-circle");
    //             input.nextElementSibling.classList.add("fa-check-circle");
    //             this.form_fields[input.name] = true;
    //         } else {
    //             // Hide "correct" status, display errors
    //             input.closest(".form-group").classList.remove("correct");
    //             input.closest(".form-group").classList.add("incorrect");
    //             input.parentElement.nextElementSibling.classList.add("active");
    //             input.nextElementSibling.classList.add("fa-times-circle");
    //             input.nextElementSibling.classList.remove("fa-check-circle");
    //             this.form_fields[input.name] = false;
    //         }
    //     }
    // }
}

// const data = new FormData(this.form);
// const url = this.baseURL + "user-exists";
// fetch(url, {
//     method: "POST",
//     body: data
// })
//     .then(function (response) {
//         if (response.ok) {
//             return response.text();
//         } else {
//             throw "Error en la llamada Ajax";
//         }
//     })
//     .then(function (texto) {
//         console.log(texto);
//     })
//     .catch(function (err) {
//         console.log(err);
//     });
