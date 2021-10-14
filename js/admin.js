function showProductsCRUD() {
    let products = document.getElementById('CRUD_Products')
    let filters = document.getElementById('CRUD_Filters')
    let category = document.getElementById('CRUD_Category')
    let offers = document.getElementById('CRUD_Offers')
    let coupons = document.getElementById('CRUD_Coupons')
    let order = document.getElementById('orderOverview')

    products.classList.remove('hide')
    products.classList.add('show')

    if (filters.classList.contains('show')) {
        filters.classList.remove('show')
        filters.classList.add('hide')
    }
    if (category.classList.contains('show')) {
        category.classList.remove('show')
        category.classList.add('hide')
    }
    if (offers.classList.contains('show')) {
        offers.classList.remove('show')
        offers.classList.add('hide')
    }
    if (order.classList.contains('show')) {
        order.classList.remove('show')
        order.classList.add('hide')
    }
    if (coupons.classList.contains('show')) {
        coupons.classList.remove('show')
        coupons.classList.add('hide')
    }
}

function showFiltersCRUD() {
    let products = document.getElementById('CRUD_Products')
    let filters = document.getElementById('CRUD_Filters')
    let category = document.getElementById('CRUD_Category')
    let offers = document.getElementById('CRUD_Offers')
    let coupons = document.getElementById('CRUD_Coupons')
    let order = document.getElementById('orderOverview')

    filters.classList.remove('hide')
    filters.classList.add('show')

    if (products.classList.contains('show')) {
        products.classList.remove('show')
        products.classList.add('hide')
    }
    if (category.classList.contains('show')) {
        category.classList.remove('show')
        category.classList.add('hide')
    }
    if (offers.classList.contains('show')) {
        offers.classList.remove('show')
        offers.classList.add('hide')
    }
    if (order.classList.contains('show')) {
        order.classList.remove('show')
        order.classList.add('hide')
    }
    if (coupons.classList.contains('show')) {
        coupons.classList.remove('show')
        coupons.classList.add('hide')
    }
}

function showOrders() {
    let products = document.getElementById('CRUD_Products')
    let filters = document.getElementById('CRUD_Filters')
    let category = document.getElementById('CRUD_Category')
    let offers = document.getElementById('CRUD_Offers')
    let coupons = document.getElementById('CRUD_Coupons')
    let order = document.getElementById('orderOverview')

    order.classList.remove('hide')
    order.classList.add('show')

    if (products.classList.contains('show')) {
        products.classList.remove('show')
        products.classList.add('hide')
    }
    if (category.classList.contains('show')) {
        category.classList.remove('show')
        category.classList.add('hide')
    }
    if (filters.classList.contains('show')) {
        filters.classList.remove('show')
        filters.classList.add('hide')
    }
    if (offers.classList.contains('show')) {
        offers.classList.remove('show')
        offers.classList.add('hide')
    }
    if (coupons.classList.contains('show')) {
        coupons.classList.remove('show')
        coupons.classList.add('hide')
    }
}

function showCategories() {
    let products = document.getElementById('CRUD_Products')
    let filters = document.getElementById('CRUD_Filters')
    let category = document.getElementById('CRUD_Category')
    let offers = document.getElementById('CRUD_Offers')
    let coupons = document.getElementById('CRUD_Coupons')
    let order = document.getElementById('orderOverview')

    category.classList.remove('hide')
    category.classList.add('show')

    if (products.classList.contains('show')) {
        products.classList.remove('show')
        products.classList.add('hide')
    }
    if (filters.classList.contains('show')) {
        filters.classList.remove('show')
        filters.classList.add('hide')
    }
    if (offers.classList.contains('show')) {
        offers.classList.remove('show')
        offers.classList.add('hide')
    }
    if (order.classList.contains('show')) {
        order.classList.remove('show')
        order.classList.add('hide')
    }
    if (coupons.classList.contains('show')) {
        coupons.classList.remove('show')
        coupons.classList.add('hide')
    }
}

function showOffers() {
    let products = document.getElementById('CRUD_Products')
    let filters = document.getElementById('CRUD_Filters')
    let category = document.getElementById('CRUD_Category')
    let offers = document.getElementById('CRUD_Offers')
    let coupons = document.getElementById('CRUD_Coupons')
    let order = document.getElementById('orderOverview')

    offers.classList.remove('hide')
    offers.classList.add('show')

    if (products.classList.contains('show')) {
        products.classList.remove('show')
        products.classList.add('hide')
    }
    if (filters.classList.contains('show')) {
        filters.classList.remove('show')
        filters.classList.add('hide')
    }
    if (category.classList.contains('show')) {
        category.classList.remove('show')
        category.classList.add('hide')
    }
    if (order.classList.contains('show')) {
        order.classList.remove('show')
        order.classList.add('hide')
    }
    if (coupons.classList.contains('show')) {
        coupons.classList.remove('show')
        coupons.classList.add('hide')
    }
}

function showCoupons() {
    let products = document.getElementById('CRUD_Products')
    let filters = document.getElementById('CRUD_Filters')
    let category = document.getElementById('CRUD_Category')
    let offers = document.getElementById('CRUD_Offers')
    let coupons = document.getElementById('CRUD_Coupons')
    let order = document.getElementById('orderOverview')

    coupons.classList.remove('hide')
    coupons.classList.add('show')

    if (products.classList.contains('show')) {
        products.classList.remove('show')
        products.classList.add('hide')
    }
    if (filters.classList.contains('show')) {
        filters.classList.remove('show')
        filters.classList.add('hide')
    }
    if (category.classList.contains('show')) {
        category.classList.remove('show')
        category.classList.add('hide')
    }
    if (order.classList.contains('show')) {
        order.classList.remove('show')
        order.classList.add('hide')
    }
    if (offers.classList.contains('show')) {
        offers.classList.remove('show')
        offers.classList.add('hide')
    }
}

function senderInput(sender) {
    let message = document.getElementById('message').parentElement

    if (sender === 'senderPostNL') {
        if (message.classList.contains('show')) {
            message.classList.remove('show')
            message.classList.add('hide')
        }
    } else if (sender === 'sender4YouOffice') {
        message.classList.remove('hide')
        message.classList.add('show')
    }
}

function showCustomEmail() {
    let email = document.getElementById("emailMessageBlock")
    let standard = document.getElementById("emailMessageBlockStandard")

    if (email.classList.contains('show')) {
        email.classList.remove("show")
        email.classList.add("hide")
        standard.classList.remove("hide")
        standard.classList.add("show")
    } else if (standard.classList.contains('show')) {
        standard.classList.remove("show")
        standard.classList.add("hide")
        email.classList.remove("hide")
        email.classList.add("show")
    }

}


