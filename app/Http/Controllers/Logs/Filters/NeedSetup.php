<?php

namespace App\Http\Controllers\Logs\Filters;

interface NeedSetup
{
    /**
     * Setup name prop.
     *
     * @return void
     */
    public function setName(): void;
}
