<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Max Mustermann',
            'username' => 'max',
            'email' =>  'max@mustermann.de',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email_verified_at' => '2021-01-01 12:00:00'
        ]);
        User::create([
            'name' => 'Susi Musterfrau',
            'username' => 'susi',
            'email' =>  'susi@musterfrau.de',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email_verified_at' => '2021-01-01 12:00:00'
        ]);
        User::factory(18)->create();
    }
}
