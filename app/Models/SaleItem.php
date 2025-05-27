<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'product_id', 'quantity', 'total'];

    // Relation avec le produit
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
