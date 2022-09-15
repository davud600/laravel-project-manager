<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 100; $i++) {
            DB::table('projects')->insert([
                'id' => $i,
                'title' => 'Project ' . $i,
                'description' => 'Descriprion for project ' . $i,
                'status' => 0,
                'estimated_time' => 1800,
                'customer_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('project_employees')->insert([
                'project_id' => $i,
                'employee_id' => 2
            ]);
        }
    }
}
