<?php

use Illuminate\Database\Seeder;

class VehiclePivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_pivot')->insert(
            [ 
                ["name" => "truck", "created_at" => NOW(), "updated_at" => NOW()], 
                ["name" => "cistern", "created_at" => NOW(), "updated_at" => NOW()]
            ]
        );
    }
}
