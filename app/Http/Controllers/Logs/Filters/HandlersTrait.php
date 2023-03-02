<?php

namespace App\Http\Controllers\Logs\Filters;

use App\Http\Requests\LogsCountRequest;

trait HandlersTrait
{
    public function __construct()
    {
        $this->setName();
    }

    public function handle(LogsCountRequest $request): void
    {
        $param = Utils::convertToParamName($this->name);

        if (!$request->has($param)) {

            parent::handle($request);

            return;
        }

        $this->setBuilder($request, $param);

        if (!$this->nextHandler) {

            return;
        }

        $this->nextHandler->handle($request);
    }
}
