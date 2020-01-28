<?php

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
        $items = [
            [
                'name' => 'Ivan The Customer',
                'email' => 'ivan@test.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id' => \App\Models\Role::getIdBySlug('customer'),
            ],
            [
                'name' => 'Bob The Operator',
                'email' => 'bob@takeaway.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id' => \App\Models\Role::getIdBySlug('operator'),
            ],
            [
                'name' => 'admin',
                'email' => 'admin@takeaway.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id' => \App\Models\Role::getIdBySlug('admin'),
            ],
        ];

        foreach ($items as $item) {
            \App\User::firstOrCreate([
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => $item['password'],
                'role_id' => $item['role_id'],
            ]);
        }
    }
}
