<?php
namespace App\Entity;

class Service {
    private int $id;
    private string $nom;
    private array $employes = [];
    private ?Employee $manager = null;

    public function __construct(int $id, string $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function getManager(): ?Employee {
        return $this->manager;
    }

    public function setManager(?Employee $manager): void {
        $this->manager = $manager;
    }

    public function getEmployes(): array {
        return $this->employes;
    }

    public function addEmploye(Employee $employe): void {
        $this->employes[] = $employe;
    }
}
