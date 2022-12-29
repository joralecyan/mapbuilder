<?php

function m_per_page(string $type = 'per_page'): int
{
    return session()->get($type, 20);
}

function m_empty($element): bool
{
    return in_array($element, [0, 6]);
}

function m_tree($element): bool
{
    return $element == 1;
}

function m_goblin($element): bool
{
    return $element == 5;
}

function m_hill($element): bool
{
    return $element == 7;
}

function m_house($element): bool
{
    return $element == 2;
}

function m_water($element): bool
{
    return $element == 3;
}

function m_ground($element): bool
{
    return $element == 4;
}

function m_ruins_coordinates(): array
{
    return [[1, 5], [2, 1], [2, 9], [8, 1], [8, 9], [9, 5]];
}

function m_hills_coordinates(): array
{
    return [[1, 3], [2, 8], [5, 5], [8, 2], [9, 7]];
}


function m_is_safe(&$M, $row, $col, &$visited): bool
{
    global $ROW, $COL;

    return ($row >= 0) && ($row < $ROW) &&
        ($col >= 0) && ($col < $COL) &&
        ($M[$row][$col] &&
            !isset($visited[$row][$col]));
}

function m_DFS(&$M, $row, $col, &$visited): void
{
    $rowNbr = array(-1, -1, -1, 0,
        0, 1, 1, 1);
    $colNbr = array(-1, 0, 1, -1,
        1, -1, 0, 1);

    $visited[$row][$col] = true;

    for ($k = 0; $k < 8; ++$k)
        if (m_is_safe($M, $row + $rowNbr[$k],
            $col + $colNbr[$k], $visited))
            m_DFS($M, $row + $rowNbr[$k],
                $col + $colNbr[$k], $visited);
}







