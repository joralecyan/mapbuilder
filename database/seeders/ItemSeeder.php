<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = ['Tree', 'House', 'Water', 'Ground', 'Goblin', 'Ruin', 'Hill'];
        if(!count(Item::all())){
            foreach($items as $item){
                Item::create([
                    'name' => $item
                ]);
            }
        }
    }
}

