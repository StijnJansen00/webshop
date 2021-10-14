function checkInputValidity(input) {
    return /[`!@#$%^&*()_+\-=\[\]{};':"|,.<>\/?~]/.test(input)
}

function checkZipcodeValidity(input) {
    return /^[0-9]{4}[A-Za-z]{2}$/.test(input)
}

function checkEmailValidity(input) {
    return /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(input)
}

function checkPhoneValidity(input) {
    return /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/.test(input)
}

function checkKvKValidity(input) {
    return /^[0-9]{8}$/.test(input)
}

function checkPasswordValidity(input) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(input)
}