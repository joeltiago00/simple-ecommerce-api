<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $collection = 'items';

    protected $fillable = [
        'name', 'description', 'specifications', 'price', 'quantity', 'category', 'is_physical', 'images'
    ];
}
