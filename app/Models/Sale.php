<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use Hasfactory;

    protected $fillable = ['reference', 'client_id', 'total'];

    // Relation avec le client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relation avec les éléments de vente
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
