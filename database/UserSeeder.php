<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nick_name' => 'rubenMkda',
            'first_name' => 'Rubén',
            'last_name' => 'Moncada',
            'email' => 'moncadaruben22@gmail.com',
            'phone' => '+584248392312',
            'email_verified_at' => Carbon::now(),
            'phone_verified_at' => null,
            'password' => Hash::make('123'),
            'profile_photo_path' => null,
        ]);

    }
}
