<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::factory(1000)->create();

        User::create([
            'name'              => 'Mark van Barneveld',
            'email'             => 'mark.van.barneveld@e-wise.nl',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',   // password
            'remember_token'    => Str::random(10),
        ]);

        User::create([
            'name'              => 'Martijn de Boer',
            'email'             => 'martijn.de.boer@e-wise.nl',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',   // password
            'remember_token'    => Str::random(10),
        ]);
    }
}
