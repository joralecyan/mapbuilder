<?php

namespace App\Services;

use App\Models\Board;
use App\Models\BoardPoint;
use App\Models\Game;
use App\Models\Mission;

class PointsService
{
    /**
     * @var array
     */
    protected array $map = [];

    /**
     * @var array
     */
    protected array $execute = [];

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

        $points -= $this->calculateGoblins($boardPoint->board);

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
    public function calculateGoblins(Board $board): int
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
                if (m_empty($current)) {
                    if (m_goblin($right) || m_goblin($left) || m_goblin($up) || m_goblin($down)) {
                        $points++;
                    }
                }
            }
        }

        return $points;
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
                if ($j == count($map) - 1) {
                    $points += 6;
                }
            }
            for ($j = 0; $j < count($map); $j++) {
                if (m_empty($map[$j][$i])) {
                    break;
                }
                if ($j == count($map) - 1) {
                    $points += 6;
                }
            }
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateGiantTree(Board $board): int
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
                if (m_tree($current) && !m_empty($right) && !m_empty($left) && !m_empty($up) && !m_empty($down)) {
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
    public function calculateMountainForest(Board $board): int
    {
        $map = $board->map;

        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                if (!m_hill($map[$i][$j]) && !m_tree($map[$i][$j])) {
                    $map[$i][$j] = 0;
                }
            }
        }

        $this->map = $map;
        $coordinates = [];
        for ($i = 0; $i < count($this->map); ++$i) {
            for ($j = 0; $j < count($this->map); ++$j) {
                if (m_tree($this->map[$j][$i])) {
                    if ($this->blankHills($i, $j) > 0 && count($this->execute) > 1) {
                        $coordinates = array_merge($coordinates, $this->execute);
                    }
                }
                $this->execute = [];
            }
        }

        $points = count(array_unique($coordinates)) * 3;
        $this->execute = [];

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateSentinelForest(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        for ($i = 0; $i < count($map); $i++) {
            if (m_tree($map[0][$i])) {
                $points++;
            }
        }

        for ($i = 0; $i < count($map); $i++) {
            if (m_tree($map[count($map) - 1][$i])) {
                $points++;
            }
        }

        for ($i = 1; $i < count($map) - 1; $i++) {
            if (m_tree($map[$i][0])) {
                $points++;
            }
        }

        for ($i = 1; $i < count($map) - 1; $i++) {
            if (m_tree($map[$i][count($map) - 1])) {
                $points++;
            }
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateGreenEdge(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                if (m_tree($map[$i][$j])) {
                    $points++;
                    break;
                }
            }
            for ($j = 0; $j < count($map); $j++) {
                if (m_tree($map[$j][$i])) {
                    $points++;
                    break;
                }
            }
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateCommunity(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                if (m_house($map[$i][$j])) {
                    $map[$i][$j] = 1;
                } else {
                    $map[$i][$j] = 0;
                }
            }
        }

        $this->map = $map;

        for ($i = 0; $i < count($this->map); ++$i) {
            for ($j = 0; $j < count($this->map); ++$j) {
                if ($this->map[$j][$i] == 1) {
                    if ($this->blank($i, $j) >= 6) {
                        $points += 8;
                    }
                }
            }
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculatePromisedLand(Board $board): int
    {
        $points = 0;
        $map = $board->map;
        $this->map = $map;
        for ($i = 0; $i < count($this->map); ++$i) {
            for ($j = 0; $j < count($this->map); ++$j) {
                if (m_house($this->map[$j][$i])) {
                    if ($this->blankFull($i, $j) > 0 && $this->execute >= 3) {
                        $this->execute = [];
                        $points += 3;
                    }
                }
            }
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateGreatCity(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                if (m_house($map[$i][$j])) {
                    $map[$i][$j] = 1;
                } elseif (!m_hill($map[$i][$j])) {
                    $map[$i][$j] = 0;
                }
            }
        }

        $this->map = $map;
        $areas = [];
        for ($i = 0; $i < count($this->map); ++$i) {
            for ($j = 0; $j < count($this->map); ++$j) {
                if ($this->map[$j][$i] == 1) {
                    $area = $this->blank($i, $j, true);
                    if ($area > 0 && $area < 1000) {
                        $areas[] = $area;
                    }
                }
            }
        }
        if (count($areas)) {
            rsort($areas);
            $points = $areas[0];
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateOutpost(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                if (m_house($map[$i][$j])) {
                    $map[$i][$j] = 1;
                } else {
                    $map[$i][$j] = 0;
                }
            }
        }

        $this->map = $map;

        $areas = [];
        for ($i = 0; $i < count($this->map); ++$i) {
            for ($j = 0; $j < count($this->map); ++$j) {
                if ($this->map[$j][$i] == 1) {
                    $area = $this->blank($i, $j);
                    if ($area > 0) {
                        $areas[] = $area;
                    }
                }
            }
        }

        if (count($areas) >= 2) {
            rsort($areas);
            $points = $areas[1] * 2;
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateGoldmine(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        $ruins = m_ruins_coordinates();

        foreach ($ruins as $ruin) {
            if (m_ground($map[$ruin[0]][$ruin[1]])) {
                $points += 3;
            }
            if (m_water($map[$ruin[0]][$ruin[1] + 1])) {
                $points += 1;
            }
            if (m_water($map[$ruin[0]][$ruin[1] - 1])) {
                $points += 1;
            }
            if (m_water($map[$ruin[0] + 1][$ruin[1]])) {
                $points += 1;
            }
            if (m_water($map[$ruin[0] - 1][$ruin[1]])) {
                $points += 1;
            }
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateUntouchedShores(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                if (!m_ground($map[$i][$j]) && !m_water($map[$i][$j])) {
                    $map[$i][$j] = 0;
                }
            }
        }

        $this->map = $map;

        for ($i = 0; $i < count($this->map); ++$i) {
            for ($j = 0; $j < count($this->map); ++$j) {
                if (m_ground($this->map[$j][$i])) {
                    if ($this->blankUntouched($i, $j, 3) > 0 && !count($this->execute)) {
                        $points += 3;
                    }
                    $this->execute = [];
                }
            }
        }

        $this->map = $map;

        for ($i = 0; $i < count($this->map); ++$i) {
            for ($j = 0; $j < count($this->map); ++$j) {
                if (m_water($this->map[$j][$i])) {
                    if ($this->blankUntouched($i, $j, 4) > 0 && !count($this->execute)) {
                        $points += 3;
                    }
                    $this->execute = [];
                }
            }
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateWizardsValley(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        $hills = m_hills_coordinates();

        foreach ($hills as $hill) {
            if (m_water($map[$hill[0]][$hill[1] + 1])) {
                $points += 2;
            }
            if (m_water($map[$hill[0]][$hill[1] - 1])) {
                $points += 2;
            }
            if (m_water($map[$hill[0] + 1][$hill[1]])) {
                $points += 2;
            }
            if (m_water($map[$hill[0] - 1][$hill[1]])) {
                $points += 2;
            }

            if (m_ground($map[$hill[0]][$hill[1] + 1])) {
                $points += 1;
            }
            if (m_ground($map[$hill[0]][$hill[1] - 1])) {
                $points += 1;
            }
            if (m_ground($map[$hill[0] + 1][$hill[1]])) {
                $points += 1;
            }
            if (m_ground($map[$hill[0] - 1][$hill[1]])) {
                $points += 1;
            }
        }

        return $points;
    }

    /**
     * @param Board $board
     * @return int
     */
    public function calculateLakeside(Board $board): int
    {
        $points = 0;
        $map = $board->map;

        for ($i = 0; $i < count($map); $i++) {
            for ($j = 0; $j < count($map); $j++) {
                $current = $map[$i][$j];
                $right = $map[$i][$j + 1] ?? 0;
                $left = $map[$i][$j - 1] ?? 0;
                $up = $map[$i + 1][$j] ?? 0;
                $down = $map[$i - 1][$j] ?? 0;
                if (m_water($current) && (m_ground($right) || m_ground($left) || m_ground($up) || m_ground($down))) {
                    $points++;
                }
                if (m_ground($current) && (m_water($right) || m_water($left) || m_water($up) || m_water($down))) {
                    $points++;
                }
            }
        }

        return $points;
    }

    /**
     * @param int $x
     * @param int $y
     * @param bool $withHills
     * @return int
     */
    private function blank(int $x, int $y, bool $withHills = false): int
    {
        if ($x < 0 || $x >= count($this->map) || $y < 0 || $y >= count($this->map) || $this->map[$y][$x] == 0 || $this->map[$y][$x] == 7) {
            return 0;
        }

        if ($withHills && (m_hill($this->map[$y][$x - 1] ?? 0) || m_hill($this->map[$y][$x + 1] ?? 0) || m_hill($this->map[$y - 1][$x] ?? 0) || m_hill($this->map[$y + 1][$x] ?? 0))) {
            return 1000;
        }

        $this->map[$y][$x] = 0;

        return 1 + $this->blank($x - 1, $y, $withHills) + $this->blank($x + 1, $y, $withHills) + $this->blank($x, $y - 1, $withHills) + $this->blank($x, $y + 1, $withHills);
    }

    /**
     * @param int $x
     * @param int $y
     * @param int $element
     * @return int
     */
    private function blankUntouched(int $x, int $y, int $element): int
    {
        if ($x < 0 || $x >= count($this->map) || $y < 0 || $y >= count($this->map) || $this->map[$y][$x] == 0) {
            return 0;
        }

        $neighbours = [$this->map[$y][$x - 1] ?? 1000, $this->map[$y][$x + 1] ?? 1000, $this->map[$y - 1][$x] ?? 1000, $this->map[$y + 1][$x] ?? 1000];

        if (in_array($element, $neighbours)) {
            $this->execute[] = $element;
        }

        if (in_array(1000, $neighbours)) {
            $this->execute[] = 1000;
        }

        $this->map[$y][$x] = 0;

        return 1 + $this->blankUntouched($x - 1, $y, $element) + $this->blankUntouched($x + 1, $y, $element) + $this->blankUntouched($x, $y - 1, $element) + $this->blankUntouched($x, $y + 1, $element);
    }


    /**
     * @param int $x
     * @param int $y
     * @return int
     */
    private function blankFull(int $x, int $y): int
    {
        if ($x < 0 || $x >= count($this->map) || $y < 0 || $y >= count($this->map) || !m_house($this->map[$y][$x])) {
            return 0;
        }

        $neighbours = [$this->map[$y][$x - 1] ?? 0, $this->map[$y][$x + 1] ?? 0, $this->map[$y - 1][$x] ?? 0, $this->map[$y + 1][$x] ?? 0];
        $this->execute = array_merge($this->execute, array_unique($neighbours));
        if (in_array(0, $this->execute)) {
            unset($this->execute[array_search(0, $this->execute)]);
        }

        if (in_array(6, $this->execute)) {
            unset($this->execute[array_search(6, $this->execute)]);
        }

        if (in_array(2, $this->execute)) {
            unset($this->execute[array_search(2, $this->execute)]);
        }

        $this->map[$y][$x] = 0;

        return 1 + $this->blankFull($x - 1, $y) + $this->blankFull($x + 1, $y) + $this->blankFull($x, $y - 1) + $this->blankFull($x, $y + 1);
    }

    /**
     * @param int $x
     * @param int $y
     * @return int
     */
    private function blankHills(int $x, int $y): int
    {
        if ($x < 0 || $x >= count($this->map) || $y < 0 || $y >= count($this->map) || $this->map[$y][$x] == 0) {
            return 0;
        }

        if (m_hill($this->map[$y][$x - 1] ?? 0)) {
            $this->execute[] = $y . '_' . ($x - 1);
        }
        if (m_hill($this->map[$y][$x + 1] ?? 0)) {
            $this->execute[] = $y . '_' . ($x + 1);
        }
        if (m_hill($this->map[$y - 1][$x] ?? 0)) {
            $this->execute[] = ($y - 1) . '_' . $x;
        }
        if (m_hill($this->map[$y + 1][$x] ?? 0)) {
            $this->execute[] = ($y + 1) . '_' . $x;
        }

        $this->execute = array_unique($this->execute);

        $this->map[$y][$x] = 0;

        return 1 + $this->blankHills($x - 1, $y) + $this->blankHills($x + 1, $y) + $this->blankHills($x, $y - 1) + $this->blankHills($x, $y + 1);
    }


}
