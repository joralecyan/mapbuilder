<?php


namespace App\Services;


use App\Models\Game;
use App\Models\GameMission;
use App\Models\Mission;

class GameService
{
    /**
     * @param Game $game
     */
    public function storeMissions(Game $game): void
    {
        $tree_mission = Mission::wherType('tree')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $figure_mission = Mission::wherType('figure')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $house_mission = Mission::wherType('house')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $water_ground_mission = Mission::wherType('water_ground')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $missions = array_merge($tree_mission, $figure_mission, $house_mission, $water_ground_mission);
        $missions_steps = ['A', 'B', 'C', 'D'];
        foreach ($missions as $key => $value){
            GameMission::create([
                'game_id' => $game->id,
                'mission_id' => $value,
                'step' => $missions_steps[$key],
            ]);
        }
        $game->status = Game::STATUS_ACTIVE;
        $game->save();

    }
}
