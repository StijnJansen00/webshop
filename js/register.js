function checkRegister() {

    const allInput = document.forms["registerForm"].getElementsByTagName("input")
    const username = document.getElementById("usernameRegister")
    const psw = document.getElementById("passwordRegister")
    const rpsw = document.getElementById("repeatPasswordRegister")
    const pswMessage = document.getElementById("passwordMessage")
    const name = document.getElementById("nameRegister")
    const surname = document.getElementById("surnameRegister")
    const email = document.getElementById("emailRegister")
    const phone = document.getElementById("phoneRegister")
    const street = document.getElementById("streetRegister")
    const number = document.getElementById("numberRegister")
    const zipcode = document.getElementById("zipcodeRegister")
    const city = document.getElementById("cityRegister")

    let totalInputs = 0
    let filledInputs = 1

    for (let i = 0; i < allInput.length; i++) {
        if (allInput[i].hasAttribute("required")) {
            totalInputs++
        }
    }

    if (checkInputValidity(username.value) || username.value === 0 || username.value === '') {
        username.classList.add("border-2", "border-danger")
    } else {
        if (username.classList.contains("border-2") && username.classList.contains("border-danger")) {
            username.classList.remove("border-2", "border-danger")
        }
        filledInputs++
    }

    if (!checkPasswordValidity(psw.value) || psw.value === 0 || psw.value === '' || psw.value !== rpsw.value) {
        psw.classList.add("border-2", "border-danger")
        rpsw.classList.add("border-2", "border-danger")
        pswMessage.innerHTML = '<p>' +
            'Wachtwoord moet het volgende hebben:<br>' +
            'Een kleineletter<br>' +
            'Een hoofdletter<br>' +
            'Een cijfer<br>' +
            'Een !@#\$%^&* character</p>'
    } else {
        if (psw.classList.contains("border-2") && psw.classList.contains("border-danger")) {
            psw.classList.remove("border-2", "border-danger")
            rpsw.classList.remove("border-2", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(name.value) || name.value === 0 || name.value === '') {
        name.classList.add("border-2", "border-danger")
    } else {
        if (name.classList.contains("border-2") && name.classList.contains("border-danger")) {
            name.classList.remove("border-2", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(surname.value) || surname.value === 0 || surname.value === '') {
        surname.classList.add("border-2", "border-danger")
    } else {
        if (surname.classList.contains("border-2") && surname.classList.contains("border-danger")) {
            surname.classList.remove("border-2", "border-danger")
        }
        filledInputs++
    }

    if (!checkEmailValidity(email.value)) {
        email.classList.add("border-2", "border-danger")
    } else {
        if (email.classList.contains("border-2") && email.classList.contains("border-danger")) {
            email.classList.remove("border-2", "border-danger")
        }
        filledInputs++
    }

    if (!checkPhoneValidity(phone.value)) {
        phone.classList.add("border-2", "border-danger")
    } else {
        if (phone.classList.contains("border-2") && phone.classList.contains("border-danger")) {
            phone.classList.remove("border-2", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(street.value) || street.value === 0 || street.value === '') {
        street.classList.add("border-2", "border-danger")
    } else {
        if (street.classList.contains("border-2") && street.classList.contains("border-danger")) {
            street.classList.remove("border-2", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(number.value) || number.value === 0 || number.value === '') {
        number.classList.add("border-2", "border-danger")
    } else {
        if (number.classList.contains("border-2") && number.classList.contains("border-danger")) {
            number.classList.remove("border-2", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(city.value) || city.value === 0 || city.value === '') {
        city.classList.add("border-2", "border-danger")
    } else {
        if (city.classList.contains("border-2") && city.classList.contains("border-danger")) {
            city.classList.remove("border-2", "border-danger")
        }
        filledInputs++
    }

    if (!checkZipcodeValidity(zipcode.value)) {
        zipcode.classList.add("border-2", "border-danger")
    } else {
        if (zipcode.classList.contains("border-2") && zipcode.classList.contains("border-danger")) {
            zipcode.classList.remove("border-2", "border-danger")
        }
        filledInputs++
    }

    if (filledInputs === totalInputs) {
        register()
    }

}