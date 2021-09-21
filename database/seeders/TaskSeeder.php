<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!count(Task::all())){

            // Ruins
            Task::create([
                'title' => 'Fort Ruins',
                'type' => 'ruin'
            ]);
            Task::create([
                'title' => 'Temple Ruins',
                'type' => 'ruin'
            ]);

            // Goblins
            $orcs = Task::create([
                'title' => 'Onslaught of Orcs',
                'type' => 'goblin',
                'direction' => 'left'
            ]);
            $orcs->figures()->sync([16]);
            $orcs->items()->sync([5]);
            $gnolls = Task::create([
                'title' => 'Gnolls Raid',
                'type' => 'goblin',
                'direction' => 'right'
            ]);
            $gnolls->figures()->sync([17]);
            $gnolls->items()->sync([5]);
            $trolls = Task::create([
                'title' => 'Trolls Raid',
                'type' => 'goblin',
                'direction' => 'left'
            ]);
            $trolls->figures()->sync([4]);
            $trolls->items()->sync([5]);
            $goblins = Task::create([
                'title' => 'Goblins Attack',
                'type' => 'goblin',
                'direction' => 'right'
            ]);
            $goblins->figures()->sync([18]);
            $goblins->items()->sync([5]);

            //Basic
            $anomaly = Task::create([
                'title' => 'Anomaly',
                'type' => 'basic',
                'duration' => 0
            ]);
            $anomaly->figures()->sync([15]);
            $anomaly->items()->sync([1, 2, 3, 4, 5]);
            $forgotten_forest = Task::create([
                'title' => 'Forgotten Forest',
                'type' => 'basic',
                'duration' => 1
            ]);
            $forgotten_forest->figures()->sync([13, 14]);
            $forgotten_forest->items()->sync([1]);
            $grounds = Task::create([
                'title' => 'Grounds',
                'type' => 'basic',
                'duration' => 1
            ]);
            $grounds->figures()->sync([11, 12]);
            $grounds->items()->sync([4]);
            $fields_river = Task::create([
                'title' => 'Fields River',
                'type' => 'basic',
                'duration' => 2
            ]);
            $fields_river->figures()->sync([10]);
            $fields_river->items()->sync([4, 3]);
            $fishing_village = Task::create([
                'title' => 'Fishing Village',
                'type' => 'basic',
                'duration' => 2
            ]);
            $fishing_village->figures()->sync([9]);
            $fishing_village->items()->sync([2, 3]);
            $garden = Task::create([
                'title' => 'Garden',
                'type' => 'basic',
                'duration' => 2
            ]);
            $garden->figures()->sync([8]);
            $garden->items()->sync([1, 4]);
            $forest_huts = Task::create([
                'title' => 'Forest Huts',
                'type' => 'basic',
                'duration' => 2
            ]);
            $forest_huts->figures()->sync([7]);
            $forest_huts->items()->sync([1, 2]);
            $great_river = Task::create([
                'title' => 'Great River',
                'type' => 'basic',
                'duration' => 1
            ]);
            $great_river->figures()->sync([5, 6]);
            $great_river->items()->sync([3]);
            $farm = Task::create([
                'title' => 'Farm',
                'type' => 'basic',
                'duration' => 2
            ]);
            $farm->figures()->sync([4]);
            $farm->items()->sync([2, 4]);
            $town = Task::create([
                'title' => 'Town',
                'type' => 'basic',
                'duration' => 1
            ]);
            $town->figures()->sync([2, 3]);
            $town->items()->sync([2]);
            $swamp = Task::create([
                'title' => 'Swamp',
                'type' => 'basic',
                'duration' => 2
            ]);
            $swamp->figures()->sync([1]);
            $swamp->items()->sync([1, 3]);
        }
    }
}
