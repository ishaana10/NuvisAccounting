<?php

namespace NuvisAccounting\Firewall\Tests\Feature;

use NuvisAccounting\Firewall\Middleware\Ip;
use NuvisAccounting\Firewall\Models\Ip as Model;
use NuvisAccounting\Firewall\Tests\TestCase;

class IpTest extends TestCase
{
    public function testShouldAllow()
    {
        $this->assertEquals('next', (new Ip())->handle($this->app->request, $this->getNextClosure()));
    }

    public function testShouldBlock()
    {
        Model::create(['ip' => '127.0.0.1', 'log_id' => 1]);

        $this->assertEquals('403', (new Ip())->handle($this->app->request, $this->getNextClosure())->getStatusCode());
    }
}
