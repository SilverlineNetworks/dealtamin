<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::insert([
            [
                'name' => 'Jaipur, India',
                'status' => 'active',
            ],
            [
                'name' => 'New York, USA',
                'status' => 'active',
            ],
        ]);
    }
}
