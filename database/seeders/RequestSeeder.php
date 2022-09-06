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
        DB::table('requests')->insert([
            'title' => 'First Request of this project',
            'description' => 'I want new feature. (This one is a finished request)',
            'project_id' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('requests')->insert([
            'title' => 'Second Request of this project',
            'description' => 'I am requesting a new feature for this project, I want a new feature.',
            'project_id' => 1,
            'status' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
