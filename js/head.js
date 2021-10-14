function showAdminUsers() {
    let adminUsers = document.getElementById('adminUsers')
    let users = document.getElementById('users')

    adminUsers.classList.remove('hide')
    adminUsers.classList.add('show')

    if (users.classList.contains('show')) {
        users.classList.remove('show')
        users.classList.add('hide')
    }
}

function showUsers() {
    let adminUsers = document.getElementById('adminUsers')
    let users = document.getElementById('users')

    users.classList.remove('hide')
    users.classList.add('show')

    if (adminUsers.classList.contains('show')) {
        adminUsers.classList.remove('show')
        adminUsers.classList.add('hide')
    }
}