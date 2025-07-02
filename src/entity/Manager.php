<?php
namespace App\Entity;

class Manager extends Employee {
    private float $prime;

    public function __construct(int $id, string $nom, string $tel, Type $type, float $prime) {
        parent::__construct($id, $nom, $tel, $type);
        $this->prime = $prime;
    }
 }