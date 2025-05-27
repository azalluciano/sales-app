<?php
// app/Console/Commands/FillMadagascarData.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FillMadagascarData extends Command
{
    /**
     * 
     *
     * @var string
     */
    protected $signature = 'db:fill-mg';

    /**
     * 
     *
     * @var string
     */
    protected $description = 'Remplir la base de données avec 5 clients et 20 produits malgaches';

    /**
     *
     */
    public function handle(): void
    {
        $this->info('Remplissage de la base de données avec des données malgaches...');

        try {
            Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
            $this->info('Base de données remplie avec succès : 5 clients et 20 produits.');
        } catch (\Exception $e) {
            $this->error('Erreur lors du remplissage : ' . $e->getMessage());
        }
    }
}