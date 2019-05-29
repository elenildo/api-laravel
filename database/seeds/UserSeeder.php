<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<10; $i++){
            DB::table('users')->insert([
                'name' => str_random(10),
                'email' => str_random(10).'@test.com',
                'password' => bcrypt('123')
            ]);
        }
    }
}
