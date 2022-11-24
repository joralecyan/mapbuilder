<?php

namespace App\Services;

use App\Models\Game;
use App\Models\GameMission;
use App\Models\GameTask;
use App\Models\Mission;
use App\Models\Task;

class GameService
{
    /**
     * @param Game $game
     */
    public function storeMissions(Game $game): void
    {
        $tree_mission = Mission::whereType('tree')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $figure_mission = Mission::whereType('figure')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $house_mission = Mission::whereType('house')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $water_ground_mission = Mission::whereType('water_ground')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $missions = array_merge($tree_mission, $figure_mission, $house_mission, $water_ground_mission);
        $missions_stages = ['A', 'B', 'C', 'D'];
        foreach ($missions as $key => $value) {
            GameMission::create([
                'game_id' => $game->id,
                'mission_id' => $value,
                'stage' => $missions_stages[$key],
            ]);
        }
        $game->status = Game::STATUS_ACTIVE;
        $game->save();
    }

    /**
     * @param Game $game
     * @return Task
     */
    public function newTask(Game $game): Task
    {
        $season_used_tasks_ids = $game->tasks()->where('season_id', $game->season_id)->pluck('task_id')->toArray();
        $used_tasks_ids = $game->tasks()->pluck('task_id')->toArray();
        $tasks = Task::whereNotIn('id', $season_used_tasks_ids)
            ->where('type', '!=', Task::TYPE_GOBLIN);
        $attacks = Task::whereNotIn('id', $used_tasks_ids)->where('type', Task::TYPE_GOBLIN)->take($game->season_id);
        $task = $attacks->unionAll($tasks)->inRandomOrder()->first();
        GameTask::create([
            'game_id' => $game->id,
            'task_id' => $task->id,
            'season_id' => $game->season_id
        ]);

        return $task;
    }
}
