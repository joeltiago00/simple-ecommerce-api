<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\BelongsTo;
use Jenssegers\Mongodb\Relations\HasOne;

class PasswordReset extends Model
{
    use HasFactory;

    protected $collection = 'password_resets';

    protected $fillable = [
        'user_id', 'user_email', 'token', 'expired_at', 'deleted_at', 'status'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function passwordResetHistory(): HasOne
    {
        return $this->hasOne(PasswordResetHistory::class);
    }
}
