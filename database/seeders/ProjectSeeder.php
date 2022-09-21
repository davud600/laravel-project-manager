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
        for ($i = 1; $i <= 25; $i++) {
            DB::table('projects')->insert([
                'id' => $i,
                'title' => 'Project ' . $i,
                'description' => 'Descriprion for project ' . $i,
                'status' => 0,
                'estimated_time' => 1800,
                'customer_id' => rand(30, 39),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            for ($j = 0; $j < rand(1, 9); $j++) {
                $employeeId = rand(20, 29);

                if (
                    DB::table('project_employees')
                    ->where('project_id', $i)
                    ->where('employee_id', $employeeId)
                    ->first() == null
                ) {
                    DB::table('project_employees')->insert([
                        'project_id' => $i,
                        'employee_id' => $employeeId
                    ]);
                }
            }
        }
    }
}
