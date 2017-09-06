<?php

use Illuminate\Database\Seeder;

class SubstationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Substation::create([
            'location_id' => 41,
            'name' => "Niš Sever"
        ]);

        \App\Substation::create([
            'location_id' => 42,
            'name' => "Niš Istok"
        ]);

        \App\Substation::create([
            'location_id' => 61,
            'name' => "Niš Jug"
        ]);

        \App\Substation::create([
            'location_id' => 90,
            'name' => "Niš Zapad"
        ]);
    }
}
