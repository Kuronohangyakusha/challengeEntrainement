<?php
namespace App\Entity;

class Developper extends Employee {
    private SpecialiteEnum $specialite;

    public function __construct(int $id, string $nom, string $tel, SpecialiteEnum $specialite) {
        parent::__construct($id, $nom, $tel, TypeEnum::Developpeur);
        $this->specialite = $specialite;
    }

    public function getSpecialite(): SpecialiteEnum {
        return $this->specialite;
    }
}