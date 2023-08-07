<?php

declare(strict_types=1);

namespace Catapult\Domain\Repositories\Implementations;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Catapult\Domain\Models\User;
use Catapult\Domain\Repositories\Contracts\UserInterface;
use Predis\Client as Predis;
class UserRepositoryImpl implements UserInterface
{
    private $db;

    private $predis;

    public function __construct(EntityManager $db, Predis $predis)
    {
        $this->db = $db;
        $this->predis = $predis;
    }

    public function get() : array
    {
        $query = $this->db
        ->getRepository(User::class)
        ->createQueryBuilder('c')
        ->getQuery();
        
        $result = $query->getResult(Query::HYDRATE_ARRAY);
        $this->predis->set('users', json_encode($result));

        return $result;
    }
}