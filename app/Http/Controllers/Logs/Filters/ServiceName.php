<?php

namespace App\Http\Controllers\Logs\Filters;

class ServiceName extends Filter
{
    use HandlersTrait;

    public function setName(): void
    {
        $this->name = 'service_name';
    }
}
