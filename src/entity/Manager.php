<?php
namespace App\Entity;

class Manager extends Employee {
    private float $prime;

    public function __construct(int $id, string $nom, string $tel, float $prime) {
        parent::__construct($id, $nom, $tel, TypeEnum::Manager);
        $this->prime = $prime;
    }

    public function getPrime(): float {
        return $this->prime;
    }
}