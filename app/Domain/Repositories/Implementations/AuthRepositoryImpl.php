<?php

declare(strict_types=1);

namespace Catapult\Domain\Repositories\Implementations;

use Carbon\Carbon;
use Noodlehaus\Config;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use Catapult\Domain\Models\Auth;
use Catapult\Domain\Models\User;
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
    public function saveToken($data) : array
    {
        $user = json_decode($data);

        return $this->check($user);
        return [
            'email' => $user->email,
            'password' => password_hash($user->password, PASSWORD_DEFAULT),
        ];
    }

    /**
     * Generates a 32 character long token string
     *
     * @param int $uId User Id
     *
     * @return string Perosnal Access Token
     */
    private function _generatePersonalAccessToken($uId)  : string
    {
        return bin2hex(openssl_random_pseudo_bytes(32, true));
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
        $this->_storeTokenHash($hash, $uId);
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
        $this->revokeToken($uId);
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
     * @return Boolean
     */
    public function check($user)
    {
        $query = $query = $this->db
        ->getRepository(User::class)
        ->findOneBy(['email' => $user->email]);
    
        dd($query->fetchObject());
    }
}