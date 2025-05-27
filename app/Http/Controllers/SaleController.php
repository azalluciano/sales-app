<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Afficher la liste des ventes
     */
    public function index()
    {
        return Sale::with(['client', 'items.product'])->get();
    }

    /**
     * Créer une nouvelle vente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            // Générer une référence automatique
            $date = now()->format('Ymd');
            $count = Sale::whereDate('created_at', now())->count() + 1;
            $reference = sprintf('SALE-%s-%03d', $date, $count);

            $sale = Sale::create([
                'reference' => $reference,
                'client_id' => $validated['client_id'],
                'total' => 0,
            ]);

            $total = 0;
            // Parcours de chaque item envoyé dans la validation
            foreach ($validated['items'] as $item) {
                // Recherche du produit correspondant à l'ID dans l'item
                $product = Product::find($item['product_id']);
                // Calcul du total partiel pour cet item (prix unitaire * quantité)
                $itemTotal = $product->retail_price * $item['quantity'];
                // Création d'une ligne de vente (SaleItem) liée à la vente
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                ]);
                $total += $itemTotal;
            }
            // Mise à jour du total global dans la table sales
            $sale->update(['total' => $total]);
            return $sale->load(['client', 'items.product']);
        });
    }

    /**
     * Afficher une vente spécifique
     */
    public function show(Sale $sale)
    {
        return $sale->load(['client', 'items.product']);
    }

    /**
     * / Mettre à jour une vente
     */
    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'client_id' => 'exists:clients,id',
            'items' => 'array',
            'items.*.product_id' => 'exists:products,id',
            'items.*.quantity' => 'integer|min:1',
        ]);
        return DB::transaction(function () use ($validated, $sale) {
        
            // Si un nouveau client est sélectionn, on met à jour le client de la vente
            if (isset($validated['client_id'])) {
                $sale->update(['client_id' => $validated['client_id']]);
            }
        
            // Si des articles sont fournis, on met à jour les lignes de vente
            if (isset($validated['items'])) {
                // On supprime toutes les lignes existantes pour repartir propre
                $sale->items()->delete();
        
                $total = 0;
        
                // On recrée les lignes une par une
                foreach ($validated['items'] as $item) {
                    $product = Product::find($item['product_id']); 
                    $itemTotal = $product->retail_price * $item['quantity']; 
        
                    // On enregistre la nouvelle ligne de vente
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'total' => $itemTotal,
                    ]);
        
                    $total += $itemTotal;
                }
        
                // Une fois toutes les lignes recréées, on met à jour le total de la ventes
                $sale->update(['total' => $total]);
            }
        
            // On retourne la vente avec ses relations client et produits pour affichage complet
            return $sale->load(['client', 'items.product']);
        });
        
    }

    /**
     * Supprimer une vente
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return response()->noContent();
    }

    public function salesByClient() 
    {
        // Total des ventes par client et par produit
        return Client::select([
            'clients.id as client_id',
            'clients.name as client_name',
            'clients.email as client_email',
            'products.id as product_id',
            'products.name as product_name',
            DB::raw('SUM(sale_items.quantity) as total_quantity'),
            DB::raw('SUM(sale_items.total) as total_sales')
        ])
            ->leftJoin('sales', 'clients.id', '=', 'sales.client_id')
            ->leftJoin('sale_items', 'sales.id', '=', 'sale_items.sale_id')
            ->leftJoin('products', 'sale_items.product_id', '=', 'products.id')
            ->groupBy([
                'clients.id',
                'clients.name',
                'clients.email',
                'products.id',
                'products.name',
            ])
            ->orderBy('clients.name', 'ASC')
            ->orderBy('total_sales', 'DESC')
            ->get();
    }
}
