<?php

namespace Database\Seeders;

use App\Models\Mission;
use Illuminate\Database\Seeder;

class MissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!count(Mission::all())) {
            //figure
            Mission::create([
              'title' => 'Calderas',
              'type' => 'figure',
              'description' => 'Score 1 point for each unfilled space that surrounds a filled space or edge on all four sides of a realm card.',
            ]);
            Mission::create([
                'title' => 'Lost Principality',
                'type' => 'figure',
                'description' => 'Get 3 points for each square along one side of the largest square of all filled squares.',
            ]);
            Mission::create([
                'title' => 'Broken Roads',
                'type' => 'figure',
                'description' => 'Score 3 points for each fully filled square diagonal that touches the left and bottom edges of the realm map.',
            ]);
            Mission::create([
                'title' => 'Vast Expanses',
                'type' => 'figure',
                'description' => 'Get 6 points for each row or column that is completely filled with cells.',
            ]);
            //tree
            Mission::create([
                'title' => 'Giant Tree',
                'type' => 'tree',
                'description' => 'Get 1 point for each forest space surrounded on four sides by filled spaces or edges of the realm map.',
            ]);
            Mission::create([
                'title' => 'Mountain Forest',
                'type' => 'tree',
                'description' => 'Get 3 points for each mountain tile connected to another mountain tile by an area of forest tiles.',
            ]);
            Mission::create([
                'title' => 'Sentinel Forest',
                'type' => 'tree',
                'description' => 'Earn 1 point for each forest space adjacent to the edge of the realm map.',
            ]);
            Mission::create([
                'title' => 'Green Edge',
                'type' => 'tree',
                'description' => 'Get 1 point for every row and every column that contains at least 1 forest square. The same cell can be counted simultaneously for both the row and the column.',
            ]);
            //house
            Mission::create([
                'title' => 'Community',
                'type' => 'house',
                'description' => 'Score 8 points for each area of 6 or more settlement tiles.',
            ]);
            Mission::create([
                'title' => 'Promised Land',
                'type' => 'house',
                'description' => 'Score 3 points for each area of settlement tiles adjacent to areas of three or more different terrain types.',
            ]);
            Mission::create([
                'title' => 'Great City',
                'type' => 'house',
                'description' => 'Get 1 point for each square in the largest area of settlement squares that is not adjacent to any mountain square.',
            ]);
            Mission::create([
                'title' => 'Outpost',
                'type' => 'house',
                'description' => 'Get 2 points for each space in the second largest area of settlement tiles (it may be the largest of the largest such area).',
            ]);

            //water_ground
            Mission::create([
                'title' => 'Goldmine',
                'type' => 'water_ground',
                'description' => 'Get 1 point for each pool tile adjacent to a ruin tile. Get 3 points for each square of fields drawn on the square of the ruins.',
            ]);
            Mission::create([
                'title' => 'Untouched Shores',
                'type' => 'water_ground',
                'description' => 'Get 3 points for each area of the field cells that is not adjacent to the water cells and the edges of the realm map. Get 3 points for each area of water cells that is not adjacent to the field cells and the edges of the realm map.',
            ]);
            Mission::create([
                'title' => 'Wizards Valley',
                'type' => 'water_ground',
                'description' => 'Get 2 points for each pond space adjacent to a mountain tile. Get 1 point for each square of the fields adjacent to the square of the mountains.',
            ]);
            Mission::create([
                'title' => 'Lakeside',
                'type' => 'water_ground',
                'description' => 'Get 1 point for each square of the fields adjacent to at least one square of the reservoir. Get 1 point for each cell of the reservoir that is adjacent to at least one cell of the fields.',
            ]);

        }
    }
}
