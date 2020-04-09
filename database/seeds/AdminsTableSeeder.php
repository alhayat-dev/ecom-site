<?php

use App\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            [
                'id' => 1,
                'name' => 'admin',
                'type' => 'admin',
                'mobile' => '03316668834',
                'email' => 'admin@mail.com',
                'password' => Hash::make("mudasser@123"),
                'image' =>  '',
                'status' => 1
            ],
            [
                'id' => 2,
                'name' => 'john',
                'type' => 'subadmin',
                'mobile' => '03316668834',
                'email' => 'john@mail.com',
                'password' => Hash::make("mudasser@123"),
                'image' =>  '',
                'status' => 1
            ],[
                'id' => 3,
                'name' => 'steve',
                'type' => 'subadmin',
                'mobile' => '03316668834',
                'email' => 'steve@mail.com',
                'password' => '$2y$10$5KWBQVO9FFN1FJLLhV.2weOLdxcC87WRaDGHhP0xvYVozQgB/6ryO',
                'image' =>  '',
                'status' => 1
            ],[
                'id' => 4,
                'name' => 'mudasser',
                'type' => 'admin',
                'mobile' => '03316668834',
                'email' => 'mudasser@mail.com',
                'password' => Hash::make("mudasser@123"),
                'image' =>  '',
                'status' => 1
            ],
        ];

        DB::table('admins')->insert($adminRecords);
    }
}
