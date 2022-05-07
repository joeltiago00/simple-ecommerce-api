<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\BelongsTo;

class Session extends Model
{
    use HasFactory;

    protected $collection = 'sessions';

    protected $fillable = [
        'user_id', 'expired_at', 'disabled_by', 'disabled_by_session_id', 'auth_secure_token'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
