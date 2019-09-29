<?php

namespace Tests\Feature;

use App\Mail\OTP;
use App\Notifications\OTPNotification;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     * @test
     *
     */
    public function an_otp_email_is_sent_when_user_is_logged_in()
    {
        Notification::fake();

        $user = factory(User::class)->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password', 'otp_via' => 'email']);

        Notification::assertSentTo([$user], OTPNotification::class);
    }

    /**
     *
     * @test
     *
     */
    public function an_otp_email_is_not_sent_when_user_provide_incorrect_credentials()
    {
        $this->withExceptionHandling();

        Notification::fake();

        $user = factory(User::class)->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'passwordsd']);

        Notification::assertNotSentTo([$user], OTPNotification::class);
    }

    /**
     *
     * @test
     *
     */
    public function otp_is_stored_in_cache_for_the_user()
    {
        $user = factory(User::class)->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password', 'otp_via' => 'email']);

       $this->assertNotNull($user->OTP());
    }
}
