<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use Hasfactory;

    protected $fillable = ['name', 'description', 'retail_price', 'wholesale_price'];

}
