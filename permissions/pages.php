<?php

$menuItems = [
    "head" => [
        ['head_dashboard?headPage=adminUsers', 'Dashboard'],
        ['admin_dashboard?adminPage=orders', 'Admin Dashboard'],
        ['#', array(
            ['admin_acc', 'Mijn Account'],
            ['php/logout.php', 'Uitloggen']
        )]
    ],
    "admin" => [
        ['admin_dashboard?adminPage=orders', 'Dashboard'],
        ['#', array(
            ['admin_acc', 'Mijn Account'],
            ['php/logout.php', 'Uitloggen']
        )]
    ],
    "user" => [
        ['home', 'Home'],
        ['products', 'Producten'],
        ['packages', 'Pakketten'],
        ['custom', 'Maatwerk'],
        ['contact', 'Contact'],
        ['about', 'Over Ons'],
        ['#', array(
            ['user_acc', 'Mijn Account'],
            ['php/logout.php', 'Uitloggen']
        )]
    ],
    "guest" => [
        ['home', 'Home'],
        ['products', 'Producten'],
        ['packages', 'Pakketten'],
        ['custom', 'Maatwerk'],
        ['contact', 'Contact'],
        ['about', 'Over Ons'],
        ['login', '<i class="bi bi-person"></i>']
    ]
];
