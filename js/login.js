function showRegister() {
    document.getElementById("login").classList.remove('show')
    document.getElementById("login").classList.add('hide')

    document.getElementById("register").classList.remove('hide')
    document.getElementById("register").classList.add('show')
}

function showLogin() {
    document.getElementById("register").classList.remove('show')
    document.getElementById("register").classList.add('hide')

    document.getElementById("login").classList.remove('hide')
    document.getElementById("login").classList.add('show')
}