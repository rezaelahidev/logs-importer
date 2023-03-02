<?php

namespace App\Providers;

use App\Http\Controllers\Logs\Filters\{
    EndDate,
    StartDate,
    StatusCode,
    ServiceName,
};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('EndDate', EndDate::class);
        $this->app->bind('StartDate', StartDate::class);
        $this->app->bind('StatusCode', StatusCode::class);
        $this->app->bind('ServiceName', ServiceName::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
