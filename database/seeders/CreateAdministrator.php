<?php

namespace Database\Seeders;

use http\Client\Curl\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdministrator extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new \App\Models\User();
        $user->email = 'admin@example.com';
        $user->password = Hash::make('password');
        $user->name = 'Admin';
        $user->save();
    }
}
