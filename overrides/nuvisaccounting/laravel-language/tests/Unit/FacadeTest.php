<?php

namespace NuvisAccounting\Language\Tests\Unit;

use NuvisAccounting\Language\Facade as LanguageFacade;
use NuvisAccounting\Language\Tests\TestCase;

class FacadeTest extends TestCase
{
    /** @test */
    public function facade_can_access_language_instance()
    {
        $this->assertInstanceOf(\NuvisAccounting\Language\Language::class, app('language'));
    }

    /** @test */
    public function facade_can_call_allowed_method()
    {
        $allowed = LanguageFacade::allowed();

        $this->assertIsArray($allowed);
    }

    /** @test */
    public function facade_can_call_getName_method()
    {
        $name = LanguageFacade::getName('en');

        $this->assertIsString($name);
    }

    /** @test */
    public function facade_can_call_country_method()
    {
        $country = LanguageFacade::country('en');

        $this->assertIsString($country);
    }
}
