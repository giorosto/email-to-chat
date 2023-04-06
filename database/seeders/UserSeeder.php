<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'admin@codecamp.ge',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Dane Joe',
            'email' => 'test@codecamp.ge',
            'password' => bcrypt('password')
        ]);
    }
}
