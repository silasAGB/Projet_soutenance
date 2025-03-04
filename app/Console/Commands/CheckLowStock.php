<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckStockLevels;

class CheckLowStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie les niveaux de stock bas et envoie des alertes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Vérification des niveaux de stock...');

        // Dispatch le job immédiatement
        CheckStockLevels::dispatch();

        $this->info('Job de vérification des stocks mis en file d\'attente.');

        return 0;
    }
}
