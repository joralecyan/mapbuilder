<?php

namespace Database\Seeders;

use App\Models\Figure;
use Illuminate\Database\Seeder;

class FigureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!count(Figure::all())) {
            Figure::create([
                'figure' => [
                    [1, 0, 0],
                    [1, 1, 1],
                    [1, 0, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 0],
                    [1, 1],
                ],
                'is_extra' => 1
            ]);
            Figure::create([
                'figure' => [
                    [1, 1, 1],
                    [1, 1, 0],
                    [0, 0, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 0, 0],
                    [1, 1, 0],
                    [1, 0, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 0, 0],
                    [1, 0, 0],
                    [1, 0, 0]
                ],
                'is_extra' => 1
            ]);
            Figure::create([
                'figure' => [
                    [0, 0, 1],
                    [0, 1, 1],
                    [1, 1, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [0, 0, 1, 1],
                    [1, 1, 1, 0],
                    [0, 0, 0, 0],
                    [0, 0, 0, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 1, 1],
                    [0, 0, 1],
                    [0, 0, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 1, 1, 1],
                    [0, 0, 0, 0],
                    [0, 0, 0, 0],
                    [0, 0, 0, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 1, 1],
                    [1, 0, 0],
                    [1, 0, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 0],
                    [1, 0]
                ],
                'is_extra' => 1
            ]);
            Figure::create([
                'figure' => [
                    [0, 1, 0],
                    [1, 1, 1],
                    [0, 1, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 0],
                    [0, 1]
                ],
                'is_extra' => 1
            ]);
            Figure::create([
                'figure' => [
                    [1, 0, 0],
                    [1, 1, 0],
                    [0, 1, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 0, 1],
                    [1, 0, 1],
                    [0, 0, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 1, 0],
                    [1, 0, 0],
                    [1, 1, 0]
                ]
            ]);
            Figure::create([
                'figure' => [
                    [1, 0, 0],
                    [0, 1, 0],
                    [0, 0, 1]
                ]
            ]);
        }
    }
}
