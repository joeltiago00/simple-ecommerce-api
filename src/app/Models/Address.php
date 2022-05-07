<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Relations\HasOne;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $collection = 'addresses';

    protected $fillable = [
        'type', 'name', 'street', 'number', 'neighborhood', 'city', 'state', 'country', 'zipcode', 'user_id', 'complement',
        'deleted_at'
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
