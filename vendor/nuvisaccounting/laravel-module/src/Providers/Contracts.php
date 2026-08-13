<?php

namespace NuvisAccounting\Module\Providers;

use NuvisAccounting\Module\Contracts\RepositoryInterface;
use NuvisAccounting\Module\Laravel\LaravelFileRepository;
use Illuminate\Support\ServiceProvider;

class Contracts extends ServiceProvider
{
    /**
     * Register some binding.
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, LaravelFileRepository::class);
    }
}
