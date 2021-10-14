function showInfo() {
    let info = document.getElementById("orderInfo")
    let btn = document.getElementById("btnInfo")

    btn.classList.remove('show')
    btn.classList.add('hide')

    info.classList.remove('hide')
    info.classList.add('show')

}

function companyInfo() {
    let radioPrivate = document.getElementById("private")
    let radioBusiness = document.getElementById("business")
    let info = document.getElementById("companyInfo")

    if (radioPrivate.checked) {
        if (info.classList.contains("show")) {
            info.classList.remove("show")
            info.classList.add("hide")

            document.getElementById('CompanyName').removeAttribute('required')
            document.getElementById('KvK').removeAttribute('required')
        }
    }
    if (radioBusiness.checked) {
        if (info.classList.contains("hide")) {
            info.classList.remove("hide")
            info.classList.add("show")

            document.getElementById('CompanyName').setAttribute('required', 'required')
            document.getElementById('KvK').setAttribute('required', 'required')
        }
    }
}

function showDiffAddress() {
    let checkbox = document.getElementById('addressInfo')
    let diffAddress = document.getElementById('diffAddress')

    if (checkbox.checked) {
        if (diffAddress.classList.contains('hide')) {
            diffAddress.classList.remove('hide')
            diffAddress.classList.add('show')
        }
        document.getElementById('InvoiceName').setAttribute('required', 'required')
        document.getElementById('InvoiceSurname').setAttribute('required', 'required')
        document.getElementById('InvoicePhone').setAttribute('required', 'required')
        document.getElementById('InvoiceStreet').setAttribute('required', 'required')
        document.getElementById('InvoiceNumber').setAttribute('required', 'required')
        document.getElementById('InvoiceCity').setAttribute('required', 'required')
        document.getElementById('InvoiceZipcode').setAttribute('required', 'required')

        document.getElementById('checked').value = 'true';

    } else {
        if (diffAddress.classList.contains('show')) {
            diffAddress.classList.remove('show')
            diffAddress.classList.add('hide')
        }
        document.getElementById('InvoiceName').removeAttribute('required')
        document.getElementById('InvoiceSurname').removeAttribute('required')
        document.getElementById('InvoicePhone').removeAttribute('required')
        document.getElementById('InvoiceStreet').removeAttribute('required')
        document.getElementById('InvoiceNumber').removeAttribute('required')
        document.getElementById('InvoiceCity').removeAttribute('required')
        document.getElementById('InvoiceZipcode').removeAttribute('required')

        document.getElementById('checked').value = 'false';
    }
}

function deleteProduct(id, action, priceExcl, supply) {
    jQuery.ajax(
        {
            type: "POST",
            url: "php/edit_cart.php",
            data: "id=" + id + "&action=" + action + '&supply=' + supply,
            dataType: "text",
            success: function (data) {

                const qt = document.getElementById("quantity" + id)
                const exclPrice = document.getElementById("excl" + id)
                const inclPrice = document.getElementById("incl" + id)
                let totalExcl = document.getElementById("totalExcl")
                let totalIncl = document.getElementById("totalIncl")
                let send = document.getElementById("sendPrice")

                const exclT = totalExcl.textContent
                const inclT = totalIncl.textContent

                let exclN = exclT.replace('€', '')
                exclN = exclN.replace(',', '.')
                let inclN = inclT.replace('€', '')
                inclN = inclN.replace(',', '.')

                exclN = Number(exclN)
                inclN = Number(inclN)

                if (data === "limit"){
                    toastr.info('Max aantal bereikt')
                } else if (data === "plus") {
                    qt.innerHTML++;
                    const priceExclRounded = (Math.round((priceExcl * qt.innerHTML) * 100) / 100).toFixed(2)
                    const priceInclRounded = (Math.round(((priceExcl * 1.21) * qt.innerHTML) * 100) / 100).toFixed(2)
                    exclPrice.innerText = '€' + priceExclRounded.replace('.', ',')
                    inclPrice.innerText = '€' + priceInclRounded.replace('.', ',')

                    exclN = exclN + priceExcl
                    inclN = inclN + (priceExcl * 1.21)

                    let exclx = parseFloat(exclN).toFixed(2)
                    let inclx = parseFloat(inclN).toFixed(2)

                    totalExcl.innerText = '€' + exclx.replace('.', ',')
                    totalIncl.innerText = '€' + inclx.replace('.', ',')

                    if (exclx < 65.00) {
                        send.innerText = '€6,95'
                    } else {
                        send.innerText = '€0,00'
                    }

                } else if (data === "min") {
                    qt.innerHTML--;
                    const priceExclRounded = (Math.round((priceExcl * qt.innerHTML) * 100) / 100).toFixed(2)
                    const priceInclRounded = (Math.round(((priceExcl * 1.21) * qt.innerHTML) * 100) / 100).toFixed(2)
                    exclPrice.innerText = '€' + priceExclRounded.replace('.', ',')
                    inclPrice.innerText = '€' + priceInclRounded.replace('.', ',')

                    exclN = exclN - priceExcl
                    inclN = inclN - (priceExcl * 1.21)

                    let exclx = parseFloat(exclN).toFixed(2)
                    let inclx = parseFloat(inclN).toFixed(2)

                    totalExcl.innerText = '€' + exclx.replace('.', ',')
                    totalIncl.innerText = '€' + inclx.replace('.', ',')

                    if (exclx < 65.00) {
                        send.innerText = '€6,95'
                    } else {
                        send.innerText = '€0,00'
                    }

                } else if (data === "delete") {
                    location.href = window.location;
                }

            }
        }
    )
}

function checkCartInfo() {
    const allInput = document.forms["orderInfoForm"].getElementsByTagName("input")
    const companyName = document.getElementById("CompanyName")
    const kvk = document.getElementById("KvK")
    const name = document.getElementById("Name")
    const surname = document.getElementById("Surname")
    const email = document.getElementById("Email")
    const phone = document.getElementById("Phone")
    const street = document.getElementById("Street")
    const number = document.getElementById("StrNumber")
    const zipcode = document.getElementById("Zipcode")
    const city = document.getElementById("City")
    const checkbox = document.getElementById('addressInfo')

    let totalInputs = 0
    let filledInputs = 0

    for (let i = 0; i < allInput.length; i++) {
        if (allInput[i].hasAttribute("required")) {
            totalInputs++
        }
    }

    if (companyName.value !== '') {
        if (checkInputValidity(companyName.value)) {
            companyName.classList.add("border", "border-danger")
        } else {
            if (companyName.classList.contains("border") && companyName.classList.contains("border-danger")) {
                companyName.classList.remove("border", "border-danger")
            }
            filledInputs++
        }
    } else {
        if (companyName.classList.contains("border") && companyName.classList.contains("border-danger")) {
            companyName.classList.remove("border", "border-danger")
        }
        totalInputs++
    }

    if (kvk.value !== '') {
        if (!checkKvKValidity(kvk.value)) {
            kvk.classList.add("border", "border-danger")
        } else {
            if (kvk.classList.contains("border") && kvk.classList.contains("border-danger")) {
                kvk.classList.remove("border", "border-danger")
            }
            filledInputs++
        }
    } else {
        if (kvk.classList.contains("border") && kvk.classList.contains("border-danger")) {
            kvk.classList.remove("border", "border-danger")
        }
        totalInputs++
    }

    if (checkInputValidity(name.value) || name.value === 0 || name.value === '') {
        name.classList.add("border", "border-danger")
    } else {
        if (name.classList.contains("border") && name.classList.contains("border-danger")) {
            name.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(surname.value) || surname.value === 0 || surname.value === '') {
        surname.classList.add("border", "border-danger")
    } else {
        if (surname.classList.contains("border") && surname.classList.contains("border-danger")) {
            surname.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (!checkEmailValidity(email.value)) {
        email.classList.add("border", "border-danger")
    } else {
        if (email.classList.contains("border") && email.classList.contains("border-danger")) {
            email.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (!checkPhoneValidity(phone.value)) {
        phone.classList.add("border", "border-danger")
    } else {
        if (phone.classList.contains("border") && phone.classList.contains("border-danger")) {
            phone.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(street.value) || street.value === 0 || street.value === '') {
        street.classList.add("border", "border-danger")
    } else {
        if (street.classList.contains("border") && street.classList.contains("border-danger")) {
            street.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(number.value) || number.value === 0 || number.value === '') {
        number.classList.add("border", "border-danger")
    } else {
        if (number.classList.contains("border") && number.classList.contains("border-danger")) {
            number.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (checkInputValidity(city.value) || city.value === 0 || city.value === '') {
        city.classList.add("border", "border-danger")
    } else {
        if (city.classList.contains("border") && city.classList.contains("border-danger")) {
            city.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (!checkZipcodeValidity(zipcode.value)) {
        zipcode.classList.add("border", "border-danger")
    } else {
        if (zipcode.classList.contains("border") && zipcode.classList.contains("border-danger")) {
            zipcode.classList.remove("border", "border-danger")
        }
        filledInputs++
    }

    if (checkbox.checked) {
        const invoiceName = document.getElementById("InvoiceName")
        const invoiceSurname = document.getElementById("InvoiceSurname")
        const invoicePhone = document.getElementById("InvoicePhone")
        const invoiceStreet = document.getElementById("InvoiceStreet")
        const invoiceNumber = document.getElementById("InvoiceNumber")
        const invoiceZipcode = document.getElementById("InvoiceZipcode")
        const invoiceCity = document.getElementById("InvoiceCity")

        if (checkInputValidity(invoiceName.value) || invoiceName.value === 0 || invoiceName.value === '') {
            invoiceName.classList.add("border", "border-danger")
        } else {
            if (invoiceName.classList.contains("border") && invoiceName.classList.contains("border-danger")) {
                invoiceName.classList.remove("border", "border-danger")
            }
            filledInputs++
        }

        if (checkInputValidity(invoiceSurname.value) || invoiceSurname.value === 0 || invoiceSurname.value === '') {
            invoiceSurname.classList.add("border", "border-danger")
        } else {
            if (invoiceSurname.classList.contains("border") && invoiceSurname.classList.contains("border-danger")) {
                invoiceSurname.classList.remove("border", "border-danger")
            }
            filledInputs++
        }

        if (!checkPhoneValidity(invoicePhone.value)) {
            invoicePhone.classList.add("border", "border-danger")
        } else {
            if (invoicePhone.classList.contains("border") && invoicePhone.classList.contains("border-danger")) {
                invoicePhone.classList.remove("border", "border-danger")
            }
            filledInputs++
        }

        if (checkInputValidity(invoiceStreet.value) || invoiceStreet.value === 0 || invoiceStreet.value === '') {
            invoiceStreet.classList.add("border", "border-danger")
        } else {
            if (invoiceStreet.classList.contains("border") && invoiceStreet.classList.contains("border-danger")) {
                invoiceStreet.classList.remove("border", "border-danger")
            }
            filledInputs++
        }

        if (checkInputValidity(invoiceNumber.value) || invoiceNumber.value === 0 || invoiceNumber.value === '') {
            invoiceNumber.classList.add("border", "border-danger")
        } else {
            if (invoiceNumber.classList.contains("border") && invoiceNumber.classList.contains("border-danger")) {
                invoiceNumber.classList.remove("border", "border-danger")
            }
            filledInputs++
        }

        if (checkInputValidity(invoiceCity.value) || invoiceCity.value === 0 || invoiceCity.value === '') {
            invoiceCity.classList.add("border", "border-danger")
        } else {
            if (invoiceCity.classList.contains("border") && invoiceCity.classList.contains("border-danger")) {
                invoiceCity.classList.remove("border", "border-danger")
            }
            filledInputs++
        }

        if (!checkZipcodeValidity(invoiceZipcode.value)) {
            invoiceZipcode.classList.add("border", "border-danger")
        } else {
            if (invoiceZipcode.classList.contains("border") && invoiceZipcode.classList.contains("border-danger")) {
                invoiceZipcode.classList.remove("border", "border-danger")
            }
            filledInputs++
        }
    }

    if (filledInputs === totalInputs) {
        processOrder()
    }
}