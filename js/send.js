function sendContactForm() {

    let company = document.forms["contactForm"].getElementsByTagName('input');
    let textarea = document.getElementById('floatingMessage');
    let contactInfoCompany = [];

    for (const information of company) {
        let inputInfo = information.parentElement.getElementsByTagName('input')
        contactInfoCompany.push(inputInfo[0].value)
    }

    let data = 'info=' + contactInfoCompany + '&message=' + textarea.value;

    jQuery.ajax({
        type: "POST",
        url: "php/contact.php",
        data: data,
        dataType: "HTML",
        success: function (data) {
            toastr.info(data)
            setTimeout(function () {
                window.location.href = 'contact'
            }, 3000);
        }
    })

}

function sendCustomForm() {

    let company = document.forms["customForm"].getElementsByTagName('input');
    let textarea = document.getElementById('floatingMessage');
    let customInfoCompany = [];

    for (const information of company) {
        let inputInfo = information.parentElement.getElementsByTagName('input')
        customInfoCompany.push(inputInfo[0].value)
    }

    let data = 'info=' + customInfoCompany + '&message=' + textarea.value;

    jQuery.ajax(
        {
            type: "POST",
            url: "php/custom.php",
            data: data,
            dataType: "HTML",
            success: function (data) {
                toastr.info(data)
                setTimeout(function () {
                    window.location.href = 'custom'
                }, 3000);
            }
        }
    )

}

function processOrder() {
    let company = document.forms["orderInfoForm"].getElementsByTagName('input')
    let price = document.getElementById("priceExcl").value
    let customInfoCompany = []

    for (const information of company) {
        let inputInfo = information.parentElement.getElementsByTagName('input')
        customInfoCompany.push(inputInfo[0].value)
    }

    let data = 'info=' + customInfoCompany + '&price=' + price

    jQuery.ajax({
        type: "POST",
        url: "php/order_process.php",
        data: data,
        dataType: "HTML",
        success: function (data) {
            location.href = data
            // console.log(data)
        }
    })
}

function register() {
    let register = document.forms["registerForm"].getElementsByTagName('input')
    let registerInfo = []

    for (const information of register) {
        let inputInfo = information.parentElement.getElementsByTagName('input')
        registerInfo.push(inputInfo[0].value)
    }

    let data = 'info=' + registerInfo

    jQuery.ajax(
        {
            type: "POST",
            url: "php/register.php",
            data: data,
            dataType: "HTML",
            success: function (data) {
                if (data === 'true') {
                    location.href = 'user_acc'
                } else {
                    toastr.info(data)
                }
            }
        }
    )
}

function editUserInfo() {
    let user = document.forms["userEditForm"].getElementsByTagName('input')
    let login = document.getElementById('userEditUser')
    let userInfo = []

    for (const information of user) {
        let inputInfo = information.parentElement.getElementsByTagName('input')
        userInfo.push(inputInfo[0].value)
    }

    let data = 'info=' + userInfo + '&login=' + login.value

    jQuery.ajax(
        {
            type: "POST",
            url: "php/user_edit_acc.php",
            data: data,
            dataType: "HTML",
            success: function (data) {
                if (data === 'true') {
                    toastr.info('Gegevens opgeslagen')
                    setTimeout(function () {
                        window.location.href = 'user_acc'
                    }, 3000);
                } else {
                    toastr.info('Er is iets fout gegaan')
                }
            }
        }
    )
}

function editPassword() {
    const opsw = document.getElementById("oldEditPassword")
    const npsw = document.getElementById("newEditPassword")
    let login = document.getElementById("loginEditPassword")

    let data = 'old=' + opsw.value + '&new=' + npsw.value + '&login=' + login.value

    jQuery.ajax(
        {
            type: "POST",
            url: "php/edit_password.php",
            data: data,
            dataType: "HTML",
            success: function (data) {
                if (data === 'true') {
                    toastr.info('Wachtwoord is gewijzigd')
                    setTimeout(function () {
                        window.location.href = 'user_acc'
                    }, 3000);
                } else {
                    toastr.info(data)
                }
            }
        }
    )
}
