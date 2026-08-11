<?php

namespace NuvisAccounting\Module\Lumen;

use NuvisAccounting\Module\FileRepository;
use NuvisAccounting\Module\Lumen\Module;

class LumenFileRepository extends FileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args)
    {
        return new Module(...$args);
    }
}
