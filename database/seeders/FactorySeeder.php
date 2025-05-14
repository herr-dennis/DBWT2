<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FactorySeeder extends Seeder
{

    public function run(){
       // $this->userData();
    }

    public function userData(){

        $faker = Factory::create();

        for($i = 0; $i < 1000; $i++){
            DB::table('ab_user')->insert([
                'id' => $i+8,
                'ab_name' => $faker->name,
                'ab_mail' => $faker->email,
                'ab_password' =>  bcrypt($faker->password()),

            ]);
        }


    }


}
