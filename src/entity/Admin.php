<?php
namespace App\Entity;
 
class Admin extends Employee {
    private string $login;
    private string $password;

    public function __construct(int $id, string $nom, string $tel, Type $type, string $login, string $password) {
        parent::__construct($id, $nom, $tel, $type);
        $this->login = $login;
        $this->password = $password;
    }
 
}