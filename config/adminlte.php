<?php

return [
    'title'         => 'FactuStock',
    'title_prefix'  => '',
    'title_postfix' => '',

    'logo'           => '<img src="/images/factustock-logo.jpeg" style="height:35px;"> <b>Factu</b>Stock',
    'logo_img'       => '/images/factustock-logo.jpeg',
    'logo_img_class' => 'brand-image',
    'logo_img_xl'    => null,
    'logo_img_xl_class' => 'brand-image',
    'logo_img_alt'   => 'FactuStock',

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path'   => '/images/factustock-logo.jpeg',
            'alt'    => 'FactuStock',
            'class'  => '',
            'width'  => 50,
            'height' => 50,
        ],
    ],

    'preloader' => [
        'enabled' => false,
    ],

    'skin'   => 'dark',
    'layout' => null,

    'classes_body'            => '',
    'classes_brand'           => 'background-color:#0C447C',
    'classes_brand_text'      => '',
    'classes_content_header'  => '',
    'classes_content_body'    => '',
    'classes_sidebar'         => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav'     => '',
    'classes_topnav'          => 'navbar-white navbar-light',
    'classes_topnav_nav'      => 'navbar-expand',
    'classes_topnav_container'=> 'container-fluid',

    'sidebar_mini'        => 'lg',
    'sidebar_collapse'    => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_scrollbar_theme'    => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion'       => true,
    'sidebar_nav_animation_speed' => 300,

    'right_sidebar'              => false,
    'right_sidebar_icon'         => 'fas fa-cogs',
    'right_sidebar_theme'        => 'dark',
    'right_sidebar_slide'        => true,
    'right_sidebar_push'         => true,
    'right_sidebar_scrollbar_theme'     => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    'use_route_url' => false,

    'dashboard_url' => '/dashboard',

    'logout_url'    => 'logout',
    'logout_method' => 'POST',

    'login_url'  => 'login',
    'register_url' => false,
    'password_reset_url'   => 'password.request',
    'password_email_url'   => 'password.email',
    'profile_url' => false,

    'locale' => null,

    'use_ico_only'      => false,
    'use_full_favicon'  => false,

    'google_fonts' => [
        'allowed' => true,
    ],

    'adminlte_plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'],
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css'],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css'],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js'],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8'],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                ['type' => 'css', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css'],
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js'],
            ],
        ],
    ],

    'menu' => [
        [
            'text'       => 'Dashboard',
            'url'        => 'dashboard',
            'icon'       => 'fas fa-tachometer-alt',
            'icon_color' => 'blue',
        ],

        // ── VENTAS (admin y vendedor) ──────────────────────
        ['header' => 'VENTAS', 'can' => 'vendedor'],

        [
            'text'       => 'Clientes',
            'url'        => 'clientes',
            'icon'       => 'fas fa-users',
            'icon_color' => 'teal',
            'can'        => 'vendedor',
        ],
        [
            'text'       => 'Cotizaciones',
            'url'        => 'cotizaciones',
            'icon'       => 'fas fa-file-alt',
            'icon_color' => 'cyan',
            'can'        => 'vendedor',
        ],
        [
            'text'       => 'Facturas',
            'url'        => 'facturas',
            'icon'       => 'fas fa-file-invoice-dollar',
            'icon_color' => 'green',
            'can'        => 'vendedor',
        ],

        // ── INVENTARIO (solo admin) ────────────────────────
        ['header' => 'INVENTARIO', 'can' => 'admin'],

        [
            'text'       => 'Productos',
            'url'        => 'productos',
            'icon'       => 'fas fa-boxes',
            'icon_color' => 'yellow',
            'can'        => 'admin',
        ],
        [
            'text'       => 'Entradas',
            'url'        => 'entradas',
            'icon'       => 'fas fa-truck-loading',
            'icon_color' => 'orange',
            'can'        => 'admin',
        ],

        // ── ADMINISTRACIÓN (solo admin) ────────────────────
        ['header' => 'ADMINISTRACION', 'can' => 'admin'],

        [
            'text'       => 'Usuarios',
            'url'        => 'usuarios',
            'icon'       => 'fas fa-user-cog',
            'icon_color' => 'red',
            'can'        => 'admin',
        ],
    ],

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],
];