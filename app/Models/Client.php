<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use Hasfactory;
    protected $fillable = ['name', 'email', 'phone'];
}
