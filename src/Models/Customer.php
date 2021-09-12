<?php

namespace Simbamahaba\Upepo\Models;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Customer extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'company', 'email', 'password', 'email_token', 'verified', 'provider', 'provider_id',
        'account_type', 'phone', 'cnp', 'region', 'city', 'address', 'rc', 'cif', 'bank_account', 'bank_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   /* public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPassword($token, $this->name));
    }*/

    public function orders()
    {
        return $this->hasMany('Decoweb\Panelpack\Models\Order');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }
}
