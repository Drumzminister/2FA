<?php

namespace Tests\Feature;

use App\Notifications\OTPNotification;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResendOTPTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     * @test
     *
     */
    public function user_can_request_new_otp()
    {
        Notification::fake();

        $user = $this->logInUser();

        $this->post('/resendOTP', ['otp_via' => 'email']);

        Notification::assertSentTo([$user], OTPNotification::class);

    }

}
