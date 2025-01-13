<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $otp = $credentials['otp'];

        return $otp == '1234';
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserAddress::Class);
    }

    public function userVehicle(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserVehicle::Class);
    }

    public function getVehicleType(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VehicleType::Class);
    }

    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Language::class,'locale', 'language_code');
    }

}
