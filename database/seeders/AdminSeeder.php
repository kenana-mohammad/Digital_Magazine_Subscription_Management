<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin=User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
             'role' => 'admin'
        ]);
        $admin->assignRole(Role::where('name','admin')->first());

    }
}
