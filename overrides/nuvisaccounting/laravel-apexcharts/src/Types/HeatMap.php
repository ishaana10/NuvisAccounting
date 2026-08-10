<?php

namespace NuvisAccounting\Apexcharts\Types;

use NuvisAccounting\Apexcharts\Chart;
use Illuminate\Support\Collection;

class HeatMap extends Chart
{
    public function __construct()
    {
        parent::__construct();

        $this->setType('heatmap');
    }

    public function addHeat(string $name, array|Collection $data): HeatMap
    {
        $type = $this->getType();

        return $this->setDataset($name, $type, $data);
    }
}
