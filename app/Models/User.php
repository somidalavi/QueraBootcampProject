<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = [];

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

    protected $append = [
        'full_name',
        'avatar_link'
    ];

    const SUPERADMIN = 'super-admin';
    const ADMIN = 'admin';
    const USER = 'user';

    const ROLES = [
        self::SUPERADMIN => [
        'value' => self::SUPERADMIN
        ],
        self::ADMIN => [
            'value' => self::ADMIN
        ],
        self::USER => [
            'value' => self::USER
        ]
    ];

    public function getAgeAttribute ()
    {
        if (is_null($this->birth_date)) {
            return '---';
        }
        return Carbon::parse($this->birth_date)->age;
    }

    public function namePrefix ()
    {
        return (is_null($this->gender)) ? 'خانم/آقای' : ($this->gender == 1 ? 'آقای' : 'خانم');
    }

    public function getFullNameAttribute ()
    {
        if (!is_null($this->first_name) && !is_null($this->last_name)) {
            return $this->first_name . ' ' . $this->last_name;
        }

        if (!is_null($this->first_name) && is_null($this->last_name)) {
            return $this->first_name;
        }

        if (is_null($this->first_name) && !is_null($this->last_name)) {
            return $this->last_name;
        }

        return $this->mobile;
    }

    public function city ()
    {
        return $this->belongsTo(City::class);
    }

    public function provience ()
    {
        return $this->belongsTo(Provience::class);
    }


}
