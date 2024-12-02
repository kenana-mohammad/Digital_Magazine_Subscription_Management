<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
         $role = Role::create(['guard_name' => 'api', 'name' => 'admin']);

         $role = Role::create(['guard_name' => 'api', 'name' => 'publisher']);
         $role = Role::create(['guard_name' => 'api', 'name' => 'subscriber']);


    }
}
