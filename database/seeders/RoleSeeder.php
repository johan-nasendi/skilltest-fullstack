<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            [
                'name' => "user",
                'display_name' => "User",
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'name' => "admin",
                'display_name' => "Admin",
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],

        ];

        DB::table('roles')->insert($roles);
    }
}
