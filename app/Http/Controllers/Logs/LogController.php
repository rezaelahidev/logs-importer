<?php

namespace App\Http\Controllers\Logs;

use App\Models\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Filters\{
    Filter,
    Filterable
};
use App\Http\Requests\LogsCountRequest;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Log $log
     * @param LogsCountRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Log $log, LogsCountRequest $request)
    {
        if (!$request->accepts(['application/json'])) {

            return response('logs/count', 403)
                ->header('Content-Type', 'application/json');
        }

        $validatedData = $request->validated();

        //When filter parameters was not exists return all items count value!
        if (empty($validatedData)) {

            $count = $log->count();

            return response()->json(compact('count'), 200);
        }

        return response()->json(
            [
                /**
                 * Retrieve count value after filtering with parameters!
                 */
                'count' => $this->getCount($request)
            ],
            200
        );
    }

    /**
     * @param LogsCountRequest $request
     *
     * @return int
     */
    protected function getCount(LogsCountRequest $request): int
    {
        /**
         * Get resolvers
         */
        $endDate = resolve('EndDate');
        $startDate = resolve('StartDate');
        $statusCode = resolve('StatusCode');
        $serviceName = resolve('ServiceName');

        /**
         * Creating chains of filters!
         *
         * @var Filter|Filterable $endDate
         */
        $endDate->setNext($startDate);
        $startDate->setNext($statusCode);
        $statusCode->setNext($serviceName);

        # Doing
        $endDate->handle($request);

        /**
         * Get count value after filtered results.
         */

        if ($request->has('serviceName')) {
            $count = $serviceName
                ->getBuilder()
                ->count();
        } elseif ($request->has('statusCode')) {
            $count = $statusCode
                ->getBuilder()
                ->count();
        } elseif ($request->has('startDate')) {
            $count = $startDate
                ->getBuilder()
                ->count();
        } elseif ($request->has('endDate')) {
            $count = $endDate
                ->getBuilder()
                ->count();
        }

        return $count ?? 0;
    }
}
