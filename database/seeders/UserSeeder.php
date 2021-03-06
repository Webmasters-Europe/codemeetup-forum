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
        if (!User::whereUsername('susi')->exists()) {
            User::create([
                'name' => 'Susi Musterfrau',
                'username' => 'susi',
                'email' =>  'susi@musterfrau.de',
                'password' => Hash::make('password'),
                'email_verified_at' => now()
            ]);
        }
        User::factory(5)->create();
    }
}
