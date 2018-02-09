<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'title' => 'Client',
            'permissions' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('user_roles')->insert([
            'title' => 'Standard User',
            'permissions' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('user_roles')->insert([
            'title' => 'Project Manager',
            'permissions' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
