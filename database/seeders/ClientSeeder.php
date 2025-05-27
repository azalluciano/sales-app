<?php
// database/seeders/ClientSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Exécuter le seeder pour remplir la table clients avec 5 clients malgaches.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Rakoto Jean',
                'email' => 'rakoto.jean@gmail.com',
                'phone' => '+261 34 12 345 67',

            ],
            [
                'name' => 'Rasoanirina Marie',
                'email' => 'marie.rasoanirina@yahoo.com',
                'phone' => '+261 33 98 765 43',

            ],
            [
                'name' => 'Andriamihaja Paul',
                'email' => 'paul.andriamihaja@outlook.com',
                'phone' => '+261 32 22 334 45',

            ],
            [
                'name' => 'Ramanantsoa Lala',
                'email' => 'lala.ramanantsoa@gmail.com',
                'phone' => '+261 34 56 789 01',

            ],
            [
                'name' => 'Razafindrakoto Solo',
                'email' => 'solo.razafindrakoto@gmail.com',
                'phone' => '+261 33 11 223 34',

            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}