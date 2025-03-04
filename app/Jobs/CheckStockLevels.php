<?php

namespace App\Jobs;

use App\Models\MatierePremiere;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\StockAlert;
use App\Models\StockAlertLog;

class CheckStockLevels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Vérification des niveaux de stock démarrée');

        $matieresPremieres = MatierePremiere::all();
        $alertCount = 0;

        foreach ($matieresPremieres as $matiere) {
            if ($matiere->qte_stock <= $matiere->stock_min) {
                // Vérifier si une alerte a déjà été envoyée aujourd'hui pour cette matière
                $lastAlert = StockAlertLog::where('id_mp', $matiere->id_MP)
                    ->whereDate('created_at', today())
                    ->first();

                if (!$lastAlert) {
                    try {
                        // Envoyer une alerte par email
                        Mail::to(config('mail.from.address'))->send(new StockAlert($matiere));

                        // Enregistrer l'alerte dans les logs
                        StockAlertLog::create([
                            'id_mp' => $matiere->id_MP,
                            'qte_stock' => $matiere->qte_stock,
                            'stock_min' => $matiere->stock_min,
                            'status' => 'sent'
                        ]);

                        Log::info("Alerte de stock envoyée pour {$matiere->nom_MP}");
                        $alertCount++;
                    } catch (\Exception $e) {
                        Log::error("Erreur lors de l'envoi de l'alerte pour {$matiere->nom_MP}: " . $e->getMessage());

                        // Enregistrer l'échec dans les logs
                        StockAlertLog::create([
                            'id_mp' => $matiere->id_MP,
                            'qte_stock' => $matiere->qte_stock,
                            'stock_min' => $matiere->stock_min,
                            'status' => 'failed',
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }
        }

        Log::info("Vérification des niveaux de stock terminée. {$alertCount} alertes envoyées.");
    }
}
