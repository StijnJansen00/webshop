function checkEditPassword() {
    const opsw = document.getElementById("oldEditPassword")
    const npsw = document.getElementById("newEditPassword")
    const rpsw = document.getElementById("repeatEditPassword")

    if (!checkPasswordValidity(npsw.value) || npsw.value === 0 || npsw.value === '' || npsw.value !== rpsw.value) {
        npsw.classList.add("border-2", "border-danger")
        rpsw.classList.add("border-2", "border-danger")
    } else {
        if (npsw.classList.contains("border-2") && npsw.classList.contains("border-danger")) {
            npsw.classList.remove("border-2", "border-danger")
            rpsw.classList.remove("border-2", "border-danger")
        }
        editPassword()
    }
}