<?php

namespace NuvisAccounting\Apexcharts\Types;

use NuvisAccounting\Apexcharts\Chart;

class PolarArea extends Chart
{
    public function __construct()
    {
        parent::__construct();

        $this->setType('polarArea');
    }

    public function addPolarAreas(array $data): PolarArea
    {
        return $this->setSeries($data);
    }
}
