<?php

namespace App\Services;

use App\Models\Board;
use App\Models\BoardPoint;
use App\Models\Game;
use App\Models\Mission;

class PointsService
{
    /**
     * @param Game $game
     * @return void
     */
    public function calculateGamePoints(Game $game): void
    {
        $stages = explode(',', $game->season->stages);
        foreach ($game->boards as $board) {
            $this->calculateBoardPoints($board->points, $stages);
        }
    }

    /**
     * @param BoardPoint $boardPoint
     * @param array $stages
     * @return int
     */
    public function calculateBoardPoints(BoardPoint $boardPoint, array $stages): int
    {
        $points = $boardPoint->coins;
        foreach ($stages as $stage) {
            $mission = $boardPoint->board->game->missions()->where('stage', $stage)->first();
            $points += $this->calculateMissionPoints($mission, $boardPoint->board);
        }

        $boardPoint->update([implode('', $stages) . '_points' => $points]);

        return $points;
    }

    /**
     * @param Mission $mission
     * @param Board $board
     * @return int
     */
    public function calculateMissionPoints(Mission $mission, Board $board): int
    {
        return $this->{'calculate' . str_replace(' ', '', $mission->title)}($board);
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateCalderas(Board $board): int
    {
        $points = 0;
        $map = $board->map;
        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                $current = $map[$i][$j];
                $right = $map[$i][$j + 1] ?? true;
                $left = $map[$i][$j - 1] ?? true;
                $up = $map[$i + 1][$j] ?? true;
                $down = $map[$i - 1][$j] ?? true;
                if (!$current && $right && $left && $up && $down) {
                    $points++;
                }
            }
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateLostPrincipality(Board $board): int
    {
        $points = 0;
        $map = $board->map;
        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                $current = $map[$i][$j];
                $right = $map[$i][$j + 1] ?? true;
                $left = $map[$i][$j - 1] ?? true;
                $up = $map[$i + 1][$j] ?? true;
                $down = $map[$i - 1][$j] ?? true;
                if (!$current && $right && $left && $up && $down) {
                    $points++;
                }
            }
        }

        return $points;
    }


}
