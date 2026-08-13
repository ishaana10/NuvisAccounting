<?php

return [

    'styles' => [
        // Boostrap 3
        'bs3-navbar' => \NuvisAccounting\Menu\Presenters\Bootstrap3\Navbar::class,
        'bs3-navbar-right' => \NuvisAccounting\Menu\Presenters\Bootstrap3\NavbarRight::class,
        'bs3-nav-pills' => \NuvisAccounting\Menu\Presenters\Bootstrap3\NavPills::class,
        'bs3-nav-tab' => \NuvisAccounting\Menu\Presenters\Bootstrap3\NavTab::class,
        'bs3-sidebar' => \NuvisAccounting\Menu\Presenters\Bootstrap3\Sidebar::class,
        'bs3-navmenu' => \NuvisAccounting\Menu\Presenters\Bootstrap3\Nav::class,

        // Zurb
        'zurb' => \NuvisAccounting\Menu\Presenters\Foundation\Zurb::class,

        // Admin
        'adminlte' => \NuvisAccounting\Menu\Presenters\Admin\Adminlte::class,
        'argon' => \NuvisAccounting\Menu\Presenters\Admin\Argon::class,
        'metronic-horizontal' => \NuvisAccounting\Menu\Presenters\Admin\MetronicHorizontal::class,
        'tailwind' => \NuvisAccounting\Menu\Presenters\Admin\Tailwind::class,
    ],

    'home_urls' => [
        '/',
    ],

    'ordering' => false,

];
