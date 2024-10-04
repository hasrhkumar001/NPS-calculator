<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *  @return void
     */
    public function run(): void
    {
        // Create an admin user
        Admin::updateOrCreate(
            ['email' => 'admin@idsil.com'], // Check for existing admin user
            [
                'name' => 'Admin User',
                'password' => Hash::make('123456'), // Replace with a strong password
                 
            ]
        );
    }
}
