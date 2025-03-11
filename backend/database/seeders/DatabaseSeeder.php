<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // admin
        DB::table('admins')->insert([
            'email' => 'admin@gmail.com',
            'password_admin' => Hash::make('admin'),
        ]);
    }
}
