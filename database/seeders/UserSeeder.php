<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hypercare.test'],
            [
                'name' => 'Admin Hypercare',
                'password' => Hash::make('ezagans'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'doctor@hypercare.test'],
            [
                'name' => 'Dr. Smith',
                'password' => Hash::make('password'),
                'role' => 'doctor',
            ]
        );

        User::updateOrCreate(
            ['email' => 'nurse@hypercare.test'],
            [
                'name' => 'Nurse Joy',
                'password' => Hash::make('password'),
                'role' => 'nurse',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@hypercare.test'],
            [
                'name' => 'Staff Member',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );
    }
}
