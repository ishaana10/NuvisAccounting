<?php

namespace NuvisAccounting\Firewall\Middleware;

use NuvisAccounting\Firewall\Abstracts\Middleware;

class Swear extends Middleware
{
    public function getPatterns()
    {
        $patterns = [];

        if (! $words = config('firewall.middleware.' . $this->middleware . '.words')) {
            return $patterns;
        }

        foreach ((array) $words as $word) {
            $patterns[] = '#\b' . $word . '\b#i';
        }

        return $patterns;
    }
}
