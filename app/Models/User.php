<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;


class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_type',
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'card_number',
        'dob',
        'address1',
        'address2',
        'city',
        'state',
        'postal_code',
        'phone',
        'address_confirmed_at',
        'registered_at',
        'is_disabled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function overdueBooks()
    {
        return $this->hasMany(Lend::class)->whereNull('lends.returned_date')->whereDate('lend_date', '<', Carbon::today()->subWeeks(2)->toDateString());
    }

    public function returnedBooks()
    {
        return $this->hasMany(Lend::class)->whereNotNull('lends.returned_date');
    }

}
