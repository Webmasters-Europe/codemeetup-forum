<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    public function testElementsPresent()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/')
                ->assertTitle('Codemeetup-Forum')
                ->assertSee('Home')
                ->assertVisible('#search')
                ->assertVisible('#login')
                ->assertVisible('#password')
                ->assertVisible('#remember')
                ->assertSee('Login')
                ->assertSee('Forgot Your Password?')
                ->assertSee('Login with Google')
                ->assertSee('Login with Github')
                ->assertVisible('#to-registration');

        });
    }

    public function testToggleLoginAndRegistrationForms()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/');

            // Click on "I'm not registered yet" - toggle from login to registration form:
            $browser->click('#to-registration')
                ->assertMissing('#login')
                ->assertMissing('#password')
                ->assertVisible('#name')
                ->assertVisible('#username')
                ->assertSee('Login with Google')
                ->assertSee('Login with Github');

            // Click on "I'm already registered" - toggle from registration to login form:
            $browser->click('#to-login')
                ->assertVisible('#login')
                ->assertVisible('#password')
                ->assertMissing('#name')
                ->assertMissing('#username');
        });
    }

    public function testClickForgotYourPasswordLink()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/');

            $browser->click('@forgot-password')
                ->assertPathIs('/password/reset')
                ->assertSee('Send Password Reset Link')
                ->assertVisible('#login')
                ->assertVisible('#password')
                ->assertPresent('#email');

        });
    }

    public function testLoginWithInvalidData()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/');

            $this->browse(function ($browser) {
                $browser->type('login', 'John Doe')
                    ->type('password', '123')
                    ->click('@login-button')
                    ->assertSee('These credentials do not match our records.');
            });

        });
    }
}
