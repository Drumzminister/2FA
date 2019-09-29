<?php

namespace Tests\Unit;

use App\Notifications\OTPNotification;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     * @test
     */
    public function it_has_cache_key_for_otp()
    {
        $user = factory(User::class)->create();

        $this->assertEquals('OTP_for_1', $user->OTPKey());
    }

    /**
     *
     * @test
     */
    public function user_can_send_sms_otp()
    {
        $user = factory(User::class)->create();

        Notification::fake();

        $user->sendOTP('sms');

        Notification::assertSentTo([$user], OTPNotification::class);

    }


}
