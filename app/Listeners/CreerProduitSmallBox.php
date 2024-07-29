<?php

namespace App\Listeners;

use App\Events\CreerProduit;
use App\Models\Smallbox;
use GuzzleHttp\Promise\Create;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use JeroenNoten\LaravelAdminLte\View\Components\Widget\SmallBox as WidgetSmallBox;

class CreerProduitSmallBox
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
     * @param  \App\Events\CreerProduit  $event
     * @return void
     */
    public function handle(CreerProduit $event)
    {
        Smallbox::create([
            'name' => $event->produit->nom,
            'quantity' => $event->produit->quantité,
            'unit' => $event->produit->unité,
            'type' => 'produit',
        ]);
    }
}
