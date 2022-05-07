<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\HasOne;

class PasswordResetHistory extends Model
{
    use HasFactory;

    protected $collection = 'password_reset_history';

    protected $fillable = [
        'user_id', 'session_id', 'password_reset_id', 'changed_by'
    ];

    /**
     * @return HasOne
     */
    public function passwordReset(): HasOne
    {
        return $this->hasOne(PasswordReset::class);
    }
}
