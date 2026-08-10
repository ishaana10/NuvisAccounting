<?php

namespace NuvisAccounting\Apexcharts\Tests;

use NuvisAccounting\Apexcharts\Facade;
use NuvisAccounting\Apexcharts\Provider;
use Orchestra\Testbench\TestCase as TestBenchTestCase;

class TestCase extends TestBenchTestCase
{
    /**
     * Load the package service provider.
     */
    protected function getPackageProviders($app): array
    {
        return [
            Provider::class,
        ];
    }
}
