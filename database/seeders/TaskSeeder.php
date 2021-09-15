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
            Task::create([
                'title' => 'Onslaught of Orcs',
                'type' => 'goblin',
                'direction' => 'left'
            ]);
            Task::create([
                'title' => 'Gnolls Raid',
                'type' => 'goblin',
                'direction' => 'right'
            ]);
            Task::create([
                'title' => 'Trolls Raid',
                'type' => 'goblin',
                'direction' => 'left'
            ]);
            Task::create([
                'title' => 'Goblin Attack',
                'type' => 'goblin',
                'direction' => 'right'
            ]);

            //Basic
            Task::create([
                'title' => 'Anomaly',
                'type' => 'basic',
                'duration' => 0
            ]);
            Task::create([
                'title' => 'Forgotten Forest',
                'type' => 'basic',
                'duration' => 1
            ]);
            Task::create([
                'title' => 'The Grounds',
                'type' => 'basic',
                'duration' => 1
            ]);
            Task::create([
                'title' => 'River in the Fields',
                'type' => 'basic',
                'duration' => 2
            ]);
            Task::create([
                'title' => 'Fishing Village',
                'type' => 'basic',
                'duration' => 2
            ]);
            Task::create([
                'title' => 'Garden',
                'type' => 'basic',
                'duration' => 2
            ]);
            Task::create([
                'title' => 'Forest Huts',
                'type' => 'basic',
                'duration' => 2
            ]);
            Task::create([
                'title' => 'Great River',
                'type' => 'basic',
                'duration' => 1
            ]);
            Task::create([
                'title' => 'Farm',
                'type' => 'basic',
                'duration' => 2
            ]);
            Task::create([
                'title' => 'Town',
                'type' => 'basic',
                'duration' => 1
            ]);
            Task::create([
                'title' => 'Swamp',
                'type' => 'basic',
                'duration' => 2
            ]);
        }
    }
}
