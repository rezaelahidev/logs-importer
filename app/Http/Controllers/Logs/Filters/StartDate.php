<?php

namespace App\Http\Controllers\Logs\Filters;

class StartDate extends Filter
{
    use HandlersTrait;

    public function setName(): void
    {
        $this->name = 'start_date';
    }
}
