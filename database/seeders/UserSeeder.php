<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::firstOrCreate(
            [
                "name" => "UserAdmin",
                "email" => "user@admin.com",

            ],
            ["password" => bcrypt(1234),]
        );
    }
}
