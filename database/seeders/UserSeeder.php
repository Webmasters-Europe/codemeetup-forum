<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! User::whereUsername('susi')->exists()) {
            User::create([
                'name' => 'Susi Musterfrau',
                'username' => 'susi',
                'email' => 'susi@musterfrau.de',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ])->assignRole('super-admin');
        }

        if (! User::whereUsername('max')->exists()) {
            User::create([
                'name' => 'Max Mustermann',
                'username' => 'max',
                'email' => 'max@mustermann.de',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ])->assignRole('user');
        }

        $users = User::factory(5)->create();
        foreach ($users as $user) {
            $user->assignRole('moderator');
        }

        $users = User::factory(5)->create();
        foreach ($users as $user) {
            $user->assignRole('user');
        }
    }
}
