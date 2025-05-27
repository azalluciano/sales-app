<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Hasfactories;

    protected $fillable = ['name', 'description', 'retail_price', 'wholesale_price'];

}
