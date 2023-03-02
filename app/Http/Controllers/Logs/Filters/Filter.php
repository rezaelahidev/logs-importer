<?php

namespace App\Http\Controllers\Logs\Filters;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use App\Http\Requests\LogsCountRequest;

abstract class Filter implements NeedSetup, Handler
{
    /**
     * Store the next Filter handler object
     *
     * @var self
     */
    protected $nextHandler;

    /**
     * Store filter name
     *
     * @var string $name
     */
    protected $name;

    /**
     * Store the Model table name
     *
     * @var string $table
     */
    protected $table = 'logs';

    /**
     * Store the object of Illuminate\Contracts\Database\Query\Builder
     *
     * @var Builder $builder
     */
    protected $builder;

    /**
     * Setup next Filter object
     *
     * @param Handler $handler
     *
     * @return void
     */
    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;

        return $this->nextHandler;
    }

    /**
     * Retrieve the builder query object.
     *
     * @param LogsCountRequest $request
     *
     * @since 1.0.0
     * @return void
     */
    public function handle(LogsCountRequest $request): void
    {
        if (!$this->nextHandler) {
            return;
        }

        $this->nextHandler->handle($request);
    }

    /**
     * Retrieve builder property.
     *
     * @since 1.0.0
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    /**
     * Setup builder property.
     *
     * @since 1.0.0
     * @return void
     */
    public function setBuilder(LogsCountRequest $request, string $param): void
    {
        if ($this->builder instanceof Builder && $this->nextHandler) {

            $this->nextHandler->builder = $this->wheres($request, $param);

            return;
        }

        if (!$this->nextHandler) {

            $this->builder = $this->wheres($request, $param);

            return;
        }

        $this->nextHandler->builder = $this->wheres($request, $param, DB::table($this->table));
    }

    /**
     * Collect from result of wheres condition.
     *
     * @since 1.0.0
     * @return Builder
     */
    private function wheres(LogsCountRequest $request, string $param, Builder $builder = null): Builder
    {
        return !$builder ? $this->builder->where(
            $this->name,
            $request->input($param)
        ) : $builder->where(
            $this->name,
            $request->input($param)
        );
    }
}
