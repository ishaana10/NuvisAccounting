<?php

namespace NuvisAccounting\Firewall\Middleware;

use NuvisAccounting\Firewall\Abstracts\Middleware;

class Whitelist extends Middleware
{
    public function check($patterns)
    {
        return ($this->isWhitelist() === false);
    }
}
