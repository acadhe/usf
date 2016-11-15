<?php

use App\Contracts\Auth\HashPasswordService;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    private $hasher;
    public function __construct(HashPasswordService $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $password = $this->hasher->hash('123');
        DB::table('users')->insert([
            ["id" => 1,"email"=>"admin@gmail.com","password" =>$password,"name"=>"Administrator","description"=>$faker->sentence,"type"=> User::TYPE_ADMIN,"tagline"=>$faker->sentence],
            ["id" => 2,"email"=>"panelist1@gmail.com","password"=>$password,"name"=>"Panelis A","description"=>$faker->sentence,"type"=> User::TYPE_PANELIST,"tagline"=>$faker->sentence],
            ["id" => 3,"email"=>"user@gmail.com","password"=>$password,"name"=>"Pengguna 1","description"=>$faker->sentence,"type"=> User::TYPE_USER,"tagline"=>$faker->sentence],
            ["id" => 4,"email"=>"panelist2@gmail.com","password"=>$password,"name"=>"Panelis B","description"=>$faker->sentence,"type"=> User::TYPE_PANELIST,"tagline"=>$faker->sentence],
            ['id' => 5,"email"=>"yafithekid212@gmail.com","password"=>$password,"name"=>"Panelis Yolo","description"=>$faker->sentence,"type"=> User::TYPE_PANELIST,"tagline"=>$faker->sentence],
            ["id" => 6,"email"=>"13512014@std.stei.itb.ac.id","password"=>$password,"name"=>"User Yolo","description"=>$faker->sentence,"type"=> User::TYPE_USER,"tagline"=>$faker->sentence]
        ]);
        if (config('database.default') == 'pgsql'){
            $count = User::count(); $count++;
            DB::statement("SELECT setval('users_id_seq',$count,FALSE)");
        }
    }
}
