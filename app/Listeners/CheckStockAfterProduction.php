<?php

namespace App\Listeners;

use App\Events\ProductionCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\CheckStockLevels;

class CheckStockAfterProduction implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductionCompleted  $event
     * @return void
     */
    public function handle(ProductionCompleted $event)
    {
        // Lancer la vérification des stocks immédiatement après une production
        CheckStockLevels::dispatch();
    }
}
