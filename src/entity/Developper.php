<?php

namespace App\Entity;

class Developpeur extends Employee {
    private Specialite $specialite;

    public function __construct(int $id, string $nom, string $tel, Type $type, Specialite $specialite) {
        parent::__construct($id, $nom, $tel, $type);
        $this->specialite = $specialite;
    }

}