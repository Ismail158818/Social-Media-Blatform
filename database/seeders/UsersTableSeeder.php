<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users =[
            [
                'name' => 'ismail',
                'email' => 'ismail@ismail.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 1,
            ],
            [
                'name' => 'ismail2',
                'email' => 'ismail@ismail2.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 2,
            ],
            [
                'name' => 'ismail3',
                'email' => 'ismail@ismail3.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd4',
                'email' => 'abd4@abd4.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd5',
                'email' => 'abd4@abd5.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd6',
                'email' => 'abd4@abd6.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd7',
                'email' => 'abd4@abd7.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd8',
                'email' => 'abd4@abd8.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd9',
                'email' => 'abd4@abd9.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd10',
                'email' => 'abd4@abd10.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd11',
                'email' => 'abd4@abd11.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd12',
                'email' => 'abd4@abd12.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd13',
                'email' => 'abd4@abd13.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd14',
                'email' => 'abd4@abd14.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],
            [
                'name' => 'abd15',
                'email' => 'abd4@abd15.com',
                'password' => Hash::make('123456'),
                'phone_number' => '0933333333',
                'role_id' => 3,
            ],

        ];
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}
