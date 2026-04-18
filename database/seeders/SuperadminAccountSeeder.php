<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SuperadminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $account = [
            [
                'fname' => "John Bryan",
                'mname' => "Argota",
                'lname' => "Javellana",
                'gender' => 'MALE',
                'birthday' => Carbon::parse('2002-07-11'),
                'email' => 'johnbryanjavellana@gmail.com',
                'password' => bcrypt("Johnbryan#07112002"),
                'role' => "SUPERADMIN",
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        User::insert($account);
    }
}
