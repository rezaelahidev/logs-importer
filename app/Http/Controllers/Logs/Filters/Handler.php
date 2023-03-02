<?php

namespace App\Http\Controllers\Logs\Filters;

use App\Http\Requests\LogsCountRequest;

interface Handler
{
    /**
     * Setup next handler
     *
     * @since 1.0.0
     * @return Handler
     */
    public function setNext(Handler $handler): Handler;

    /**
     * Handling request with just exactly available filter param.
     *
     * @param LogsCountRequest $request
     *
     * @since 1.0.0
     * @return void
     */
    public function handle(LogsCountRequest $request): void;
}
