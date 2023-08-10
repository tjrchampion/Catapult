<?php

declare(strict_types=1);

namespace Catapult\Domain\Repositories\Implementations;

use Exception;
use Carbon\Carbon;
use Noodlehaus\Config;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use Catapult\Domain\Models\Auth;
use Catapult\Domain\Models\User;
use Doctrine\ORM\NoResultException;
use Catapult\Exceptions\NotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use Catapult\Domain\Repositories\Contracts\AuthInterface;

class AuthRepositoryImpl implements AuthInterface
{
    private $db;
    
    private $config;

    private $container;

    public function __construct(EntityManager $db, Config $config)
    {
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * save a token to the db
     *
     * @return Object
     */
    public function saveToken($data)
    {
        $user = json_decode($data);

        $validUser = $this->check($user);
        
        try {

            if(is_object($validUser)) {
                return  [
                    'success' => true,
                    'token' => $this->getToken($validUser->getId())
                ];
            }

            throw new Exception('Sorry, we could not generate token at this time.');
            

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

    }

    /**
     * Generates a 256 character long token string
     *
     * @param int $uId User Id
     *
     * @return string Personal Access Token
     */
    private function _generatePersonalAccessToken($uId)  : string
    {
        return bin2hex(openssl_random_pseudo_bytes(256, $uId));
    }

    /**
     * Gets a new token for the user
     *
     * @param int $uId User Id
     *
     * @return string Personal Access Token
     */
    public function getToken(int $uId) : string
    {
        $token = $this->_generatePersonalAccessToken($uId);
        $hash = $this->_hashToken($token);
        //$this->_storeTokenHash($hash, $uId);
        return $token;
    }

    /**
     * Hashes the token
     *
     * @param string $token Personal Access Token
     *
     * @return string Hashes Token
     */
    private function _hashToken(string $token) : string
    {
        return password_hash($token, PASSWORD_DEFAULT);
    }

    // @todo write function to store token in database

    /**
     * Store hashed token in the database
     *
     * @param string $hash Hashed Token
     * @param int $uId User ID
     *
     * @return void
     */
    private function _storeTokenHash(string $hash, int $uId)
    {
        // Revoke the users previous token
        //$this->revokeToken($uId);
    }

    /**
     * Rovoke Access Token for user
     *
     * @todo write function that deletes token for user
     *
     * @return void
     */
    public function revokeToken()
    {
        //
    }

    /**
     * Gets Token Expiry Time from config
     *
     * @return string Token Expiry Time
     */
    private function _getTokenExpiryTimeFromConfig() : string
    {
        $config = $this->container->get('config');
        return $config->get('token.expiry');
    }

    /**
     * Checks if the token has expired
     *
     * @todo compare date with created_at date
     * 
     * @return void
     */
    public function checkIfTokenExpired()
    {
        $minutes = $this->_getTokenExpiryTimeFromConfig();
        $exipry = Carbon::now()->addMinutes($minutes)->timestamp;
    }

    /**
     * Is given password valid.
     *
     * @return User|array
     */
    public function check(object $user) : User|array
    {
        $query = $this->db
        ->getRepository(User::class)
        ->createQueryBuilder('u');

        $query->select('u')
            ->where('u.email = :email')    
            ->setParameter('email', $user->email);
            
        $result = $query->getQuery()->getSingleResult(); 

        try {
            if((!empty($user)) && password_verify($user->password, $result->getPassword())) {
                return $result;
            }
            throw new NotFoundException('Could find a user with these credentials.');
            
        } catch(NotFoundException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}