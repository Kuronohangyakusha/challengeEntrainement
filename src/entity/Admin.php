<?php
namespace App\Entity;

class Admin extends Employee {
    private string $login;
    private string $password;

    public function __construct(int $id, string $nom, string $tel, string $login, string $password) {
        parent::__construct($id, $nom, $tel, TypeEnum::Admin);
        $this->login = $login;
        $this->password = $password;
    }

    public function getLogin(): string {
        return $this->login;
    }
}