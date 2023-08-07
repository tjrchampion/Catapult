<?php

declare(strict_types=1);

namespace Catapult\Domain\Models;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity 
 * @ORM\Table(name="tokens")
 */
class Token
{
    /**
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id 
     * @ORM\Column(name="id", type="bigint", nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(name="user_id", type="integer")
     */
    protected $user_id;

    /**
     * @ORM\Column(name="token", type="string")
     */
    protected $token;

    /**
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @ORM\Column(name="abilities", type="json_array", nullable=false)
     */
    protected $abilities;
}