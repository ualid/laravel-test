<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::firstOrCreate([
            "name" => "new"
        ]);
        Status::firstOrCreate([
            "name" => "active"
        ]);
        Status::firstOrCreate([
            "name" => "suspended"
        ]);
        Status::firstOrCreate([
            "name" => "cancelled"
        ]);
    }
}
