<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Relations\BelongsTo;

class ImageProfileHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $collection = 'image_profile_history';

    protected $fillable = [
        'user_id', 'old_image', 'new_image'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
