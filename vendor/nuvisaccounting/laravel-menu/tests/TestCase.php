<?php

namespace NuvisAccounting\Menu\Tests;

use NuvisAccounting\Menu\Provider;
use Collective\Html\HtmlServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            HtmlServiceProvider::class,
            Provider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('menu', [
            'styles' => [
                'bs3-navbar' => \NuvisAccounting\Menu\Presenters\Bootstrap3\Navbar::class,
                'bs3-navbar-right' => \NuvisAccounting\Menu\Presenters\Bootstrap3\NavbarRight::class,
                'bs3-nav-pills' => \NuvisAccounting\Menu\Presenters\Bootstrap3\NavPills::class,
                'bs3-nav-tab' => \NuvisAccounting\Menu\Presenters\Bootstrap3\NavTab::class,
                'bs3-sidebar' => \NuvisAccounting\Menu\Presenters\Bootstrap3\Sidebar::class,
                'bs3-navmenu' => \NuvisAccounting\Menu\Presenters\Bootstrap3\Nav::class,
            ],

            'ordering' => false,
        ]);
    }
}
