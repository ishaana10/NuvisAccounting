<?php

namespace NuvisAccounting\Module\Contracts;

interface PublisherInterface
{
    /**
     * Publish something.
     *
     * @return mixed
     */
    public function publish();
}
