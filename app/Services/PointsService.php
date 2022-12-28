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
                $right = $map[$i][$j + 1] ?? 1;
                $left = $map[$i][$j - 1] ?? 1;
                $up = $map[$i + 1][$j] ?? 1;
                $down = $map[$i - 1][$j] ?? 1;
                if (m_empty($current) && !m_empty($right) && !m_empty($left) && !m_empty($up) && !m_empty($down)) {
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
        $map = $board->map;
        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                if (!m_empty($map[$i][$j])) {
                    $map[$i][$j] = 1;
                } else {
                    $map[$i][$j] = 0;
                }
            }
        }

        $max = 0;
        $maxArray = [];

        for ($i = 0; $i < 2; $i++) {
            $maxArray[$i] = array_fill(0, count($map), 0);
        }

        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                $entries = $map[$i][$j];
                if ($entries) {
                    if ($j) {
                        $entries = 1 + min($maxArray[1][$j - 1], min($maxArray[0][$j - 1], $maxArray[1][$j]));
                    }
                }
                $maxArray[0][$j] = $maxArray[1][$j];
                $maxArray[1][$j] = $entries;
                $max = max($max, $entries);
            }
        }

        return 3 * $max;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateBrokenRoads(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        for ($k = 1; $k <= count($map); $k++) {
            $m = 0;
            for ($i = count($map) - $k; $i < count($map); $i++) {
                if (!m_empty($map[$i][abs(count($map) - $i - $k)])) {
                    $m++;
                }
            }
            if ($m == $k) {
                $points += 3;
            }
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateVastExpanses(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                if (m_empty($map[$i][$j])) {
                    break;
                }
                if($j == count($map) - 1){
                    $points += 6;
                }
            }
            for ($j = 0; $j < count($map); $j++) {
                if (m_empty($map[$j][$i])) {
                    break;
                }
                if($j == count($map) - 1){
                    $points += 6;
                }
            }
        }

        return $points;
    }


}
