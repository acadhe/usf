<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //user subscribes topic 1 and 2
        $users = User::all();
        foreach($users as $user){
            DB::table('subscriptions')->insert([
                ['user_id' => $user->id,'article_id' => 1],
                ['user_id' => $user->id,'article_id' => 2]
            ]);
        }
        
    }
}