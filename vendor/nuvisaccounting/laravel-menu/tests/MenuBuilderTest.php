<?php

namespace NuvisAccounting\Menu\Tests;

use NuvisAccounting\Menu\MenuBuilder;
use NuvisAccounting\Menu\MenuItem;
use Illuminate\Config\Repository;

class MenuBuilderTest extends TestCase
{
    /** @test */
    public function it_makes_a_menu_item()
    {
        $builder = new MenuBuilder('main', app(Repository::class));

        self::assertInstanceOf(MenuItem::class, $builder->url('hello', 'world'));
    }
}
