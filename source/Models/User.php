<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;
use Source\Core\Password;

class User extends DataLayer
{

    public function __construct()
    {
        parent::__construct("users", ['first_name', 'last_name', 'email', 'password']);
    }

    public function newUser(string $first_name, string $last_name, string $email, string $password, string $idTotal = null): User
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = (new Password($password))->getHash();
        if ($idTotal) {
            $this->id_total = $idTotal;
        }
        return $this;
    }


    public function save(): bool
    {
        $email = $this->find("email= :email", "email={$this->email}", "id");

        if ($email->count() > 0) {
            $this->fail = "Email ja cadastrado";
            return false;
        }
        return parent::save();

    }


}