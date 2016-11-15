<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleanerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("comments")->delete();
        DB::table("articles")->delete();
        DB::table("users")->delete();
    }
}
