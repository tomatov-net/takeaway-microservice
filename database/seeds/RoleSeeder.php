<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Admin',
            'Operator',
            'Customer',
        ];

        foreach ($roles as $role) {
            \App\Models\Role::firstOrCreate([
                'name' => $role,
                'slug' => \Illuminate\Support\Str::slug($role),
            ]);
        }
    }
}
