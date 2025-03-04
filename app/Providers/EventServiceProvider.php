<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use App\Events\ProductionCompleted;
use App\Listeners\CheckStockAfterProduction;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,

        ],

        \App\Events\CreerProduit::class => [
            \App\Listeners\CreerProduitSmallBox::class,
        ],
        \App\Events\CreerMatierePremiere::class => [
            \App\Listeners\CreerMatierPremiereSmallBox::class,
        ],

        ProductionCompleted::class => [
            CheckStockAfterProduction::class,
        ],
    ];



    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
