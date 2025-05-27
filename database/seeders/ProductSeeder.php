<?php
// database/seeders/ProductSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Exécuter le seeder pour remplir la table products avec 20 produits réalistes.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Riz Makalioka', 'description' => 'Riz blanc de qualité supérieure, 50kg', 'retail_price' => 120000, 'wholesale_price' => 108000],
            ['name' => 'Huile de tournesol Vita', 'description' => 'Huile alimentaire, 1L', 'retail_price' => 8000, 'wholesale_price' => 7200],
            ['name' => 'Sucre Cristal', 'description' => 'Sucre blanc, 1kg', 'retail_price' => 4000, 'wholesale_price' => 3600],
            ['name' => 'Farine T55', 'description' => 'Farine de blé pour pain, 1kg', 'retail_price' => 3500, 'wholesale_price' => 3150],
            ['name' => 'Pâtes Spaghetti Barilla', 'description' => 'Pâtes italiennes, 500g', 'retail_price' => 5000, 'wholesale_price' => 4500],
            ['name' => 'Sardines en boîte', 'description' => 'Sardines à l’huile, 125g', 'retail_price' => 2500, 'wholesale_price' => 2250],
            ['name' => 'Lait en poudre Nido', 'description' => 'Lait en poudre, 400g', 'retail_price' => 15000, 'wholesale_price' => 13500],
            ['name' => 'Savon de Marseille', 'description' => 'Savon naturel, 100g', 'retail_price' => 2000, 'wholesale_price' => 1800],
            ['name' => 'Détergent Omo', 'description' => 'Poudre à laver, 1kg', 'retail_price' => 7000, 'wholesale_price' => 6300],
            ['name' => 'Biscuits Tiko', 'description' => 'Biscuits sucrés, 200g', 'retail_price' => 3000, 'wholesale_price' => 2700],
            ['name' => 'Jus de mangue Ceres', 'description' => 'Jus de fruit, 1L', 'retail_price' => 6000, 'wholesale_price' => 5400],
            ['name' => 'Eau minérale Viso', 'description' => 'Eau en bouteille, 1.5L', 'retail_price' => 2000, 'wholesale_price' => 1800],
            ['name' => 'Café Kapoaka', 'description' => 'Café moulu malgache, 250g', 'retail_price' => 10000, 'wholesale_price' => 9000],
            ['name' => 'Thé vert Mlesna', 'description' => 'Thé en sachet, 100g', 'retail_price' => 5000, 'wholesale_price' => 4500],
            ['name' => 'Poisson séché', 'description' => 'Poisson salé séché, 500g', 'retail_price' => 12000, 'wholesale_price' => 10800],
            ['name' => 'Piment vert', 'description' => 'Piment frais, 100g', 'retail_price' => 1000, 'wholesale_price' => 900],
            ['name' => 'Haricots rouges', 'description' => 'Haricots secs, 1kg', 'retail_price' => 4500, 'wholesale_price' => 4050],
            ['name' => 'Tomates en conserve', 'description' => 'Tomates pelées, 400g', 'retail_price' => 3000, 'wholesale_price' => 2700],
            ['name' => 'Beurre Star', 'description' => 'Beurre pasteurisé, 200g', 'retail_price' => 6000, 'wholesale_price' => 5400],
            ['name' => 'Poulet entier', 'description' => 'Poulet frais, 1.5kg', 'retail_price' => 20000, 'wholesale_price' => 18000],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}