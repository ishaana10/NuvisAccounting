<?php

namespace NuvisAccounting\Module\Providers;

use NuvisAccounting\Module\Contracts\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

class Bootstrap extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {
        $this->app[RepositoryInterface::class]->boot();
    }

    /**
     * Register the provider.
     */
    public function register()
    {
        $this->app[RepositoryInterface::class]->register();
    }
}
