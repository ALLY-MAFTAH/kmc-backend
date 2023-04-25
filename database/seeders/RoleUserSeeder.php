<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => Role::ADMIN,
                'status' => true,
                'description' => 'A system administrator',
            ],
            [
                'name' => Role::STAFF,
                'status' => true,
                'description' => 'An organization staff',
            ],
        ])->each(function ($role) {
            Role::create($role);
        });

        Role::where('name', Role::ADMIN)->first()->save(
            [

                User::create(
                    [
                        'first_name' => 'Ally',
                        'middle_name' => 'Waziri',
                        'last_name' => 'Maftah',
                        'status' => true,
                        'role_id' => 1,
                        'nida' => '1996021721000032121',
                        'phone_no' => '0714871033',
                        'email' => 'admin@kmc.com',
                        'password' => Hash::make('12312345'),
                    ],
                ),
            ]
        );
        Role::where('name', Role::STAFF)->first()->save(
            [
                User::create(
                    [
                        'first_name' => 'Abul',
                        'middle_name' => 'Fadhwl',
                        'last_name' => 'Ally',
                        'status' => true,
                        'role_id' => 1,
                        'phone_no' => '0620650411',
                        'nida' => '1996021721000032122',
                        'email' => 'staff@gmail.com',
                        'password' => Hash::make('12312345'),
                    ],
                ),

            ]
        );

    }
}
