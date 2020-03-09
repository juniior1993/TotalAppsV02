<?php


namespace Source\Core;


class Password
{

    private string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function getHash(): string
    {
        return password_hash($this->password, CONF_PASSWORD_ALGO, CONF_PASSWORD_COST);
    }

    public function verify(string $hash): bool
    {
        return password_verify($this->password, $hash);
    }

    public function needHehash(string $hash): bool
    {
        return password_needs_rehash($hash, CONF_PASSWORD_ALGO, CONF_PASSWORD_COST);
    }


}