<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!count(Season::all())){
            Season::create([
               'name' => 'Spring',
               'duration' => 8,
               'steps' => 'A,B'
            ]);
            Season::create([
                'name' => 'Summer',
                'duration' => 8,
                'steps' => 'B,C'
            ]);
            Season::create([
                'name' => 'Autumn',
                'duration' => 7,
                'steps' => 'C,D'
            ]);
            Season::create([
                'name' => 'Winter',
                'duration' => 6,
                'steps' => 'D,A'
            ]);
        }
    }
}
