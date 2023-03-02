<?php

namespace App\Http\Controllers\Logs\Filters;

use App\Http\Requests\LogsCountRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class EndDate extends Filter
{
    use HandlersTrait;

    public function setName(): void
    {
        $this->name = 'end_date';
    }
}
