<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'rei'],
            [
                'name' => 'Master Admin',
                'email' => 'rei@admin.com',
                'password' => Hash::make('rei123'),
            ]
        );

        User::updateOrCreate(
            ['username' => 'sungut'],
            [
                'name' => 'Sungut Admin',
                'email' => 'sungut@admin.com',
                'password' => Hash::make('sungut123'),
            ]
        );
    }
}
