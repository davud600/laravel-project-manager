<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 3,
            'name' => 'c',
            'email' => 'c@gmail.com',
            'password' => Hash::make('chkdsk34'),
            'company' => "c's company",
            'role' => 0
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 3,
            'model_type' => 'App\Models\User',
            'model_id' => 3
        ]);
    }
}
