<?php

namespace NuvisAccounting\Module\Laravel;

use NuvisAccounting\Module\FileRepository;
use NuvisAccounting\Module\Laravel\Module;

class LaravelFileRepository extends FileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args)
    {
        return new Module(...$args);
    }
}
