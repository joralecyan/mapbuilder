<?php

/**
 * @param $type
 * @return int|mixed
 */
function m_per_page($type = 'per_page')
{
    return session()->get($type, 20);
}





