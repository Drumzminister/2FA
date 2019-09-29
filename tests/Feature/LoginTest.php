<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    /**
     *
     * @test
     *
     */
    public function after_login_user_can_not_access_homepage_until_verified()
    {
        $user = $this->logInUser();

        $this->get('/home')->assertRedirect('/verifyOTP');
    }

    /**
     *
     * @test
     *
     */
    public function after_login_user_can_access_homepage_if_verified()
    {
        $user = $this->logInUser(['isVerified' => 1]);

        $this->get('/home')->assertStatus(200);
    }
}
