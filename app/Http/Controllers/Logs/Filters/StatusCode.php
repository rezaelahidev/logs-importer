<?php

namespace App\Http\Controllers\Logs\Filters;

class StatusCode extends Filter
{
    use HandlersTrait;

    public function setName(): void
    {
        $this->name = 'status_code';
    }
}
