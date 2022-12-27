<?php

/**
 * @param string $type
 * @return mixed
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function m_per_page(string $type = 'per_page'): int
{
    return session()->get($type, 20);
}





