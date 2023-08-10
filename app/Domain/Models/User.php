<?php

declare(strict_types=1);

namespace Catapult\Domain\Models;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity 
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
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
    * @ORM\OneToMany(targetEntity="Token", mappedBy="users")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $token;

    /**
     * return protected "password" property with getter
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * return protected "id" property with getter
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}