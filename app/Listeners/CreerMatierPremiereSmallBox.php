<?php

namespace App\Listeners;

use App\Events\CreerMatierePremiere;
use App\Models\Smallbox;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreerMatierPremiereSmallBox
{
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
     * @param  \App\Events\CreerMatierePremiere  $event
     * @return void
     */
    public function handle(CreerMatierePremiere $event)
    {
        Smallbox::create([
            'name' => $event->MatierePremiere->nom,
            'quantity' => $event->MatierePremiere->quantité,
            'unit' => $event->MatierePremiere->unité,
            'type' => 'MatierePremiere',
        ]);
    }
}
