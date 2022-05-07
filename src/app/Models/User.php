<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Relations\HasMany;

class User extends Model
{
    use SoftDeletes;

    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'role', 'email_verified', 'email_verified_at', 'status',
        'image_profile'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function emailChange(): HasMany
    {
        return $this->hasMany(UserEmailChange::class);
    }

    /**
     * @return HasMany
     */
    public function passwordReset(): HasMany
    {
        return $this->hasMany(PasswordReset::class);
    }

    /**
     * @return HasMany
     */
    public function address(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return HasMany
     */
    public function imageProfileHistory(): HasMany
    {
        return $this->hasMany(ImageProfileHistory::class);
    }

    /**
     * @return HasMany
     */
    public function session(): HasMany
    {
        return $this->hasMany(Session::class);
    }
}
