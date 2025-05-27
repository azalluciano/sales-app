<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Afficher la liste des clients
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * créer un nouveau client.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:clients',
            'phone' => 'nullable|string|max:20',
        ]);

        return Client::create($validated);
    }

    /**
     * Afficher un client spécifique.
     */
    public function show(Client $client)
    {
        return $client;
    }

    /**
     * Mettre à jour un client
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $client->update($validated);
        return $client;
    }

    /**
     * Supprimer un client
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return response()->noContent();
    }
}
