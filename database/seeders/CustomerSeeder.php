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
            'role' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 3,
            'model_type' => 'App\Models\User',
            'model_id' => 3
        ]);

        for ($i = 30; $i < 40; $i++) {
            DB::table('users')->insert([
                'id' => $i,
                'name' => 'Customer ' . $i,
                'email' => 'c' . $i . '@gmail.com',
                'password' => Hash::make('chkdsk34'),
                'company' => "Customer inc company",
                'role' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('model_has_roles')->insert([
                'role_id' => 3,
                'model_type' => 'App\Models\User',
                'model_id' => $i
            ]);
        }
    }
}
