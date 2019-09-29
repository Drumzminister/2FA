@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verify OTP</div>

                <div class="card-body">
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach

                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="/verifyOTP" method="POST">
                        @csrf
                        <h1>Enter OTP</h1>

                        <div class="form-group">
                            <input type="text" name="{{auth()->user()->OTPKey()}}" class="form-control">
                        </div>

                        <input type="submit" value="SUBMIT" class="form-control">
                    </form>

                        <br><br>
                    <form action="/resendOTP" method="POST">
                            @csrf
                        <h3>Resend OTP</h3>


                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="sms" name="otp_via" value="sms">
                            <label for="sms" class="form-check-label">SMS</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="email" class="form-check-input" name="otp_via" value="email">
                            <label for="email" class="form-check-label">Email</label>
                        </div>
                            <input type="submit" value="Resend OTP" class="form-control">
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
