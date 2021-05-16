<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            ['title' => 'test title 1', 'description' => 'test description 1'],
            ['title' => 'test title 2', 'description' => 'test description 2'],
            ['title' => 'test title 3', 'description' => 'test description 3'],
            ['title' => 'test title 4', 'description' => 'test description 4'],
            ['title' => 'test title 5', 'description' => 'test description 5'],
        ]);
    }
}
