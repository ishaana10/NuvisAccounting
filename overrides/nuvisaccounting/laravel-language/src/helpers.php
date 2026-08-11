<?php

if (!function_exists('language')) {
    /**
     * Get the language instance.
     *
     * @return \NuvisAccounting\Language\Language
     */
    function language(): \NuvisAccounting\Language\Language
    {
        return app('language');
    }
}
