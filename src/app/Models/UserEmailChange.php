<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\BelongsTo;

class UserEmailChange extends Model
{
    use HasFactory;

    protected $collection = 'user_email_changes';

    protected $fillable = [
        'user_id', 'new_user_email', 'token', 'expired_at', 'deleted_at', 'status', 'old_user_email'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
