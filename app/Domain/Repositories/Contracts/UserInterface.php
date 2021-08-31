<?php

declare(strict_types=1);

namespace Docufiy\Domain\Repositories\Contracts;

interface UserInterface
{
    /**
     * get interface for impl
     *
     * @return array
     */
    public function get() : array;
}