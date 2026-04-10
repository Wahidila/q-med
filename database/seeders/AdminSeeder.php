<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat atau memperbarui akun Admin
        User::updateOrCreate(
        ['email' => 'admin@q-med.my.id'],
        [
            'name' => 'Administrator',
            'password' => Hash::make('qmedadmin123!'),
        ]
        );
    }
}
