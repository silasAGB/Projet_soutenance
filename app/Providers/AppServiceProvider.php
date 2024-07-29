<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        app('boilerplate.datatables')->registerDatatable(\App\Datatables\ApprovisionnementsDatatable::class);
        View::addNamespace('boilerplate', resource_path('views/vendor/boilerplate'));
        Blade::component('boilerplate::components.smallbox', 'smallbox');
        
    }


}
