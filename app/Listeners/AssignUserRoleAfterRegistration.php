<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class AssignUserRoleAfterRegistration
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle(Registered $event): void
    {
        $event->user->assignRole('user');
    }
}
