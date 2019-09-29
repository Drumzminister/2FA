<?php

namespace App;

use App\Mail\OTP;
use App\Notifications\OTPNotification;
use Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'isVerified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function OTP()
    {
        return Cache::get($this->OTPKey());
    }

    public function OTPKey()
    {
        return "OTP_for_{$this->id}";
    }

    public function generateAndCacheOTP()
    {
        $OTP = rand(100000, 999999);
        Cache::put($this->OTPKey(), $OTP, now()->addMinutes(5));
        return $OTP;
    }

    public function sendOTP($otpMedium)
    {
        $this->notify(new OTPNotification($this->generateAndCacheOTP(), $otpMedium));
    }

    public function routeNotificationForKarix()
    {
        return $this->email;
    }
}
