<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::create([
            'fname'=>'Admin',
            'lname'=>'Admin',
            'mname'=>'Admin',
            'address'=>'Manila',
            'username'=>'ocmis',
            'contact'=>'09111421073',
            'email'=>'ocmis@gmail.com',
            'password'=>Hash::make('admin123'),
            'role'=>'admin'

        ]);

    }
}
