<?php

namespace App\Services;

use App\Events\GameEvent;
use App\Models\Game;
use App\Models\GameMission;
use App\Models\GameTask;
use App\Models\Mission;
use App\Models\Season;
use App\Models\Task;

class GameService
{

    /**
     * @param Game $game
     * @return void
     */
    public function startGame(Game $game): void
    {
        $this->storeMissions($game);
        $this->newTask($game);
        //  (new GameEvent($game->id, 'Started'))->emit(); // Todo work after socket integration
    }


    /**
     * @param Game $game
     * @return void
     */
    public function storeMissions(Game $game): void
    {
        $treeMissions = Mission::whereType('tree')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $figureMissions = Mission::whereType('figure')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $houseMissions = Mission::whereType('house')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $waterGroundMissions = Mission::whereType('water_ground')->inRandomOrder()->take(1)->pluck('id')->toArray();
        $missions = array_merge($treeMissions, $figureMissions, $houseMissions, $waterGroundMissions);
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
     * @return void
     */
    public function newTask(Game $game): void
    {
        $seasonUsedTasksIds = $game->tasks()->where('season_id', $game->season_id)
            ->pluck('task_id')->toArray();
        $duration = Task::whereIn('id', $seasonUsedTasksIds)->sum('duration');
        if ($duration >= $game->season->duration) {
            (new PointsService())->calculateGamePoints($game);
            if ($game->season->stages != Season::LAST) {
                $game->update(['season_id' => ++$game->season_id]);
            }else{
                $game->update(['status' => Game::STATUS_COMPLETED]);
                BoardService::markWinner($game);
                return;
            }
        }
        $usedTasksIds = $game->tasks()->pluck('task_id')->toArray();
        $tasks = Task::whereNotIn('id', $seasonUsedTasksIds)
            ->where('type', '!=', Task::TYPE_GOBLIN);
        $usedAttackCount = $game->tasks()->whereHas('task', function ($q) {
            return $q->where('type', Task::TYPE_GOBLIN);
        })->count();
        $attacks = Task::whereNotIn('id', $usedTasksIds)->where('type', Task::TYPE_GOBLIN)->take($game->season_id - $usedAttackCount);
        $task = $attacks->unionAll($tasks)->inRandomOrder()->first();

        GameTask::create([
            'game_id' => $game->id,
            'task_id' => $task->id,
            'season_id' => $game->season_id
        ]);
    }
}
