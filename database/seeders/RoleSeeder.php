<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::updateOrCreate(['name' => 'admin'], ['description' => 'Administrator']);
        Role::updateOrCreate(['name' => 'teknisi'], ['description' => 'Teknisi']);
    }
}