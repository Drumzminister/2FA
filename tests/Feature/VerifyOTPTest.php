<?php

namespace Tests\Feature;

use App\User;
use Cache;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class VerifyOTPTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     * @test
     *
     */
    public function user_must_provide_otp_when_verifying_otp()
    {
        $this->withExceptionHandling();

        $user = $this->logInUser();

        $user->generateAndCacheOTP();

        $this->post('verifyOTP')->assertSessionHasErrors(auth()->user()->OTPKey());

    }

    /**
     *
     * @test
     *
     */
    public function user_can_submit_otp_and_get_verified()
    {

        $user = $this->logInUser();
        $OTP = $user->generateAndCacheOTP();

        $this->post('verifyOTP', [auth()->user()->OTPKey() => $OTP])->assertRedirect('/home');

        $this->assertDatabaseHas('users', ['isVerified' => 1]);
    }

    /**
     *
     * @test
     *
     */
    public function user_can_see_verify_otp_page_if_authenticated()
    {
        $user = $this->logInUser();

        $this->get('verifyOTP')->assertStatus(200)->assertSee('Enter OTP');
    }

    /**
     *
     * @test
     *
     */
    public function user_can_not_see_verify_otp_page_if_unauthenticated()
    {
        $this->withExceptionHandling();

        $this->get('verifyOTP')->assertRedirect('/login');
    }

    /**
     *
     * @test
     *
     */
    public function invalid_otp_returns_error_message()
    {
        $this->withExceptionHandling();

        $user = $this->logInUser();

        $user->generateAndCacheOTP();

        $this->post('verifyOTP', [auth()->user()->OTPKey() => 'dfdfddddfd'])->assertSessionHasErrors(auth()->user()->OTPKey());

    }

}
