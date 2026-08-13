<?php

namespace NuvisAccounting\Module\Providers;

use NuvisAccounting\Module\Contracts\ActivatorInterface;
use NuvisAccounting\Module\Contracts\RepositoryInterface;
use NuvisAccounting\Module\Lumen\LumenFileRepository;
use NuvisAccounting\Module\Support\Stub;

class Lumen extends Main
{
    /**
     * Booting the package.
     */
    public function boot()
    {
        $this->setupStubPath();
    }

    /**
     * Register all modules.
     */
    public function register()
    {
        $this->registerNamespaces();
        $this->registerServices();
        $this->registerModules();
        $this->registerProviders();
    }

    /**
     * Setup stub path.
     */
    public function setupStubPath()
    {
        Stub::setBasePath(__DIR__ . '/Commands/stubs');

        if (app('module')->config('stubs.enabled') === true) {
            Stub::setBasePath(app('module')->config('stubs.path'));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function registerServices()
    {
        $this->app->singleton(RepositoryInterface::class, function ($app) {
            $path = $app['config']->get('module.paths.modules');

            return new LumenFileRepository($app, $path);
        });

        $this->app->singleton(ActivatorInterface::class, function ($app) {
            $class = $app['config']->get('module.activator');

            return new $class($app);
        });

        $this->app->alias(RepositoryInterface::class, 'module');
    }
}
