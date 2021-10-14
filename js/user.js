function checkUserEdit() {

    const allInput = document.forms["userEditForm"].getElementsByTagName("input")
    const input = document.forms["userEditForm"].querySelectorAll("input[type=text]")
    const street = document.getElementById("userEditStreet")
    const number = document.getElementById("userEditNumber")
    const zipcode = document.getElementById("userEditZipcode")
    const city = document.getElementById("userEditCity")
    const phone = document.getElementById("userEditPhone")
    const company = document.getElementById("userEditCompany")
    const kvk = document.getElementById("userEditKvk")

    let empty = false
    let totalInputs = 0
    let filledInputs = 0

    for (let i = 0; i < allInput.length; i++) {
        if (allInput[i].hasAttribute("required")) {
            totalInputs++
        }
    }

    if (checkInputValidity(street.value) || street.value === 0 || street.value === '') {
        street.classList.add("border", "border-danger")
        empty = true
    } else {
        if (street.classList.contains("border") && street.classList.contains("border-danger")) {
            street.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(number.value) || number.value === 0 || number.value === '') {
        number.classList.add("border", "border-danger")
        empty = true
    } else {
        if (number.classList.contains("border") && number.classList.contains("border-danger")) {
            number.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(city.value) || city.value === 0 || city.value === '') {
        city.classList.add("border", "border-danger")
        empty = true
    } else {
        if (city.classList.contains("border") && city.classList.contains("border-danger")) {
            city.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (!checkZipcodeValidity(zipcode.value)) {
        zipcode.classList.add("border", "border-danger")
        empty = true
    } else {
        if (zipcode.classList.contains("border") && zipcode.classList.contains("border-danger")) {
            zipcode.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (!checkPhoneValidity(phone.value)) {
        phone.classList.add("border", "border-danger")
        empty = true
    } else {
        if (phone.classList.contains("border") && phone.classList.contains("border-danger")) {
            phone.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (company.value !== '') {
        if (checkInputValidity(street.value) || street.value === 0 || street.value === '') {
            street.classList.add("border", "border-danger")
            empty = true
        } else {
            if (street.classList.contains("border") && street.classList.contains("border-danger")) {
                street.classList.remove("border", "border-danger")
            }
            filledInputs++
            totalInputs++
        }
    }

    if (kvk.value !== '') {
        if (!checkKvKValidity(kvk.value)) {
            kvk.classList.add("border", "border-danger")
            empty = true
        } else {
            if (kvk.classList.contains("border") && kvk.classList.contains("border-danger")) {
                kvk.classList.remove("border", "border-danger")
            }
            filledInputs++
            totalInputs++
        }
    }

    if (filledInputs === totalInputs) {
        editUserInfo()
    }

}