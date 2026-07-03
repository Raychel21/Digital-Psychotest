<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['Developer', 'developer@psychotest.test', UserRole::Developer],
            ['Administrator', 'admin@psychotest.test', UserRole::Administrator],
            ['Participant', 'participant@psychotest.test', UserRole::Participant],
        ];

        foreach ($users as [$name, $email, $role]) {
            User::query()->updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => 'password',
                    'role' => $role,
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
