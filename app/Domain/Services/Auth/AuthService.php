<?php

namespace Docufiy\Domain\Services\Auth;

class AuthService
{

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
        $token = _generatePersonalAccessToken($uId);
        $hash = $this->_hashToken();
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
        // Rovoke the users previous token
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
    }

    /**
     * Gets Token Expiry Time from config
     *
     * @return string Token Expiry Time
     */
    private function _getTokenExpiryTimeFromConfig() : string
    {
        $config = $container->get('config');
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
}
