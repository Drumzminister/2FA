<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OTPController extends Controller
{
    public function verifyOTP()
    {
        $this->validate(request(), [
            auth()->user()->OTPKey() => 'required'
        ]);

        if(request()->{auth()->user()->OTPKey()} != Cache::get(auth()->user()->OTPKey())){
            return back()->withErrors([auth()->user()->OTPKey() => 'invalid OTP']);
        }


        auth()->user()->update(['isVerified' => 1]);

        return redirect('home');
    }

    public function index()
    {
        return view('OTPVerify');
    }

    public function resendOTP()
    {
        $this->validate(request(),
            ['otp_via' => 'required']
        );

        auth()->user()->sendOTP(request('otp_via'));
        return back()->with('success', 'OTP has been resent');
    }
}
