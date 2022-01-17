<?php

namespace Database\Seeders;

use App\Models\Role;
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
        /** @var User $user */
        $user = User::create([
            'name' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'admin@admin.ru',
        ]);

        $adminRole = Role::ofAdmin()->first();
        $user->roles()->attach($adminRole);

    }
}
