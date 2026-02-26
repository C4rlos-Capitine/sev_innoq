<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'quidgest',
            'email' => 'carlos.mutemba@quidgest.co.mz',
            'password' => Hash::make('12345678'), // Use a secure password in production
        ]);
    }
}
