<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Afficher la liste des produits
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Créer un nouveau produit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'retail_price' => 'required|numeric|min:0',
            'wholesale_price' => 'required|numeric|min:0',
        ]);

        return Product::create($validated);
    }

    /**
     * Afficher un produit spécifique
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Mettre à jour un produit
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'retail_price' => 'numeric|min:0',
            'wholesale_price' => 'numeric|min:0',
        ]);

        $product->update($validated);
        return $product;
    }

    /**
     * Supprimer un produit
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
