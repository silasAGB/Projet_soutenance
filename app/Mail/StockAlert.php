<?php

   namespace App\Mail;

   use App\Models\MatierePremiere;
   use Illuminate\Bus\Queueable;
   use Illuminate\Mail\Mailable;
   use Illuminate\Queue\SerializesModels;

   class StockAlert extends Mailable
   {
       use Queueable, SerializesModels;

       public $matiere;

       public function __construct(MatierePremiere $matiere)
       {
           $this->matiere = $matiere;
       }

       public function build()
       {
           return $this->subject('Alerte de Stock - ' . $this->matiere->nom_MP)
                       ->view('boilerplate::emails.stock_alert')
                       ->with([
                           'nom' => $this->matiere->nom_MP,
                           'quantite' => $this->matiere->qte_stock,
                           'stock_min' => $this->matiere->stock_min,
                       ]);
       }
   }
