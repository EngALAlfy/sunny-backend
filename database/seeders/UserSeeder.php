<?php

namespace Database\Seeders;

use App\Models\User;
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
        // admin user
        User::factory()->create(['email' => 'admin']);
        // demo user
        User::factory()->create(['email' => 'demo']);
    }
}
