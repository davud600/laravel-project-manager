<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $projectId = rand(1, 100);

            DB::table('requests')->insert([
                'title' => 'Request ' . $i . ' for project ' . $projectId,
                'description' => 'I am requesting a new feature for this project, I want a new feature.',
                'project_id' => $projectId,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
