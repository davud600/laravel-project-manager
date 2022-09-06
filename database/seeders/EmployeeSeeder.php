<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'e',
            'email' => 'e@gmail.com',
            'password' => Hash::make('chkdsk34'),
            'company' => "d's company",
            'role' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => 2
        ]);
    }
}
