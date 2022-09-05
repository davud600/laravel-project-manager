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
        DB::table('projects')->insert([
            'id' => 1,
            'title' => 'First Project',
            'description' => 'Descriprion for the first project',
            'status' => 0,
            'estimated_time' => 1800,
            'customer_id' => 3
        ]);

        DB::table('project_employees')->insert([
            'project_id' => 1,
            'employee_id' => 2
        ]);
    }
}
