function checkContactForm() {

    const allInput = document.getElementsByTagName("input");
    const input = document.querySelectorAll("input[type=text]");
    const email = document.getElementById("floatingEmail");
    const phone = document.getElementById("floatingPhone");
    const textarea = document.getElementById("floatingMessage");

    let empty = false;
    let totalInputs = allInput.length;
    totalInputs++;
    let filledInputs = 0;

    for (let i = 0; i < input.length; i++) {
        if (input[i].value === 0 || input[i].value === "") {
            input[i].classList.add("border", "border-danger");
            empty = true;
        } else {
            if (checkInputValidity(input[i].value)) {
                input[i].classList.add("border", "border-danger");
                empty = true;
            } else {
                if (input[i].classList.contains("border") && input[i].classList.contains("border-danger")) {
                    input[i].classList.remove("border", "border-danger");
                }
                filledInputs++;
            }
        }
    }

    if (!checkEmailValidity(email.value)) {
        email.classList.add("border", "border-danger");
        empty = true;
    } else {
        if (email.classList.contains("border") && email.classList.contains("border-danger")) {
            email.classList.remove("border", "border-danger");
        }
        filledInputs++;
    }

    if (!checkPhoneValidity(phone.value)) {
        phone.classList.add("border", "border-danger");
        empty = true;
    } else {
        if (phone.classList.contains("border") && phone.classList.contains("border-danger")) {
            phone.classList.remove("border", "border-danger");
        }
        filledInputs++;
    }

    if (checkInputValidity(textarea.value) || textarea.value === "" || textarea.value === 0) {
        textarea.classList.add("border", "border-danger");
        empty = true;
    } else {
        if (textarea.classList.contains("border") || textarea.classList.contains("border-danger")) {
            textarea.classList.remove("border", "border-danger");
        }
        filledInputs++;
    }

    if (filledInputs === totalInputs) {
        sendContactForm()
    }

}

function checkCustomForm() {

    const allInput = document.getElementsByTagName("input");
    const input = document.querySelectorAll("input[type=text]");
    const email = document.getElementById("floatingEmail");
    const phone = document.getElementById("floatingPhone");
    const textarea = document.getElementById("floatingMessage");

    let empty = false;
    let totalInputs = allInput.length;
    totalInputs++;
    let filledInputs = 0;

    for (let i = 0; i < input.length; i++) {
        if (input[i].value === 0 || input[i].value === "") {
            input[i].classList.add("border", "border-danger");
            empty = true;
        } else {
            if (checkInputValidity(input[i].value)) {
                input[i].classList.add("border", "border-danger");
                empty = true;
            } else {
                if (input[i].classList.contains("border") && input[i].classList.contains("border-danger")) {
                    input[i].classList.remove("border", "border-danger");
                }
                filledInputs++;
            }
        }
    }

    if (!checkEmailValidity(email.value)) {
        email.classList.add("border", "border-danger");
        empty = true;
    } else {
        if (email.classList.contains("border") && email.classList.contains("border-danger")) {
            email.classList.remove("border", "border-danger");
        }
        filledInputs++;
    }

    if (!checkPhoneValidity(phone.value)) {
        phone.classList.add("border", "border-danger");
        empty = true;
    } else {
        if (phone.classList.contains("border") && phone.classList.contains("border-danger")) {
            phone.classList.remove("border", "border-danger");
        }
        filledInputs++;
    }

    if (checkInputValidity(textarea.value) || textarea.value === "" || textarea.value === 0) {
        textarea.classList.add("border", "border-danger");
        empty = true;
    } else {
        if (textarea.classList.contains("border") || textarea.classList.contains("border-danger")) {
            textarea.classList.remove("border", "border-danger");
        }
        filledInputs++;
    }

    if (filledInputs === totalInputs) {
        sendCustomForm()
    }

}
