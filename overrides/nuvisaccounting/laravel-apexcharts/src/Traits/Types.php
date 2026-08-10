<?php

namespace NuvisAccounting\Apexcharts\Traits;

use NuvisAccounting\Apexcharts\Types\Area;
use NuvisAccounting\Apexcharts\Types\Bar;
use NuvisAccounting\Apexcharts\Types\Donut;
use NuvisAccounting\Apexcharts\Types\HeatMap;
use NuvisAccounting\Apexcharts\Types\HorizontalBar;
use NuvisAccounting\Apexcharts\Types\Line;
use NuvisAccounting\Apexcharts\Types\Pie;
use NuvisAccounting\Apexcharts\Types\PolarArea;
use NuvisAccounting\Apexcharts\Types\Radar;
use NuvisAccounting\Apexcharts\Types\Radial;

trait Types
{
    public function area(): Area
    {
        return new Area();
    }

    public function bar(): Bar
    {
        return new Bar();
    }

    public function donut(): Donut
    {
        return new Donut();
    }

    public function heatMap(): HeatMap
    {
        return new HeatMap();
    }

    public function horizontalBar(): HorizontalBar
    {
        return new HorizontalBar();
    }

    public function line(): Line
    {
        return new Line();
    }

    public function pie(): Pie
    {
        return new Pie();
    }

    public function polarArea(): PolarArea
    {
        return new PolarArea();
    }

    public function radar(): Radar
    {
        return new Radar();
    }

    public function radial(): Radial
    {
        return new Radial();
    }
}
