<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Dao Registration
        $this->app->bind('App\Contracts\Dao\Import\ImportDaoInterface', 'App\Dao\Import\ImportDao');
        $this->app->bind('App\Contracts\Services\Import\ImportServiceInterface', 'App\Services\Import\ImportService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
