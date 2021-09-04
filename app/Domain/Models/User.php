<?php

declare(strict_types=1);

namespace Docufiy\Domain\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
    * @ManyToOne(targetEntity="Token")
    * @JoinColumn(name="id", referencedColumnName="user_id")
    */
    private $token;
}