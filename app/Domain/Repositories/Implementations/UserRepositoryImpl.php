<?php

declare(strict_types=1);

namespace Docufiy\Domain\Repositories\Implementations;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Docufiy\Domain\Models\User;
use Laminas\Diactoros\Response\JsonResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Docufiy\Domain\Repositories\Contracts\UserInterface;

class UserRepositoryImpl implements UserInterface
{

    public function __construct(EntityManager $db)
    {
        $this->db = $db;
    }

    public function get() : array
    {
        $query = $this->db
            ->getRepository(User::class)
            ->createQueryBuilder('c')
            ->getQuery();
        
        return $query->getResult(Query::HYDRATE_ARRAY);

    }
}