<?php
namespace App\Entity;

abstract class Employee {
    protected int $id;
    protected string $nom;
    protected string $tel;
    protected ?Service $service = null;
    protected TypeEnum $type;

    public function __construct(int $id, string $nom, string $tel, TypeEnum $type) {
        $this->id = $id;
        $this->nom = $nom;
        $this->tel = $tel;
        $this->type = $type;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getTel(): string {
        return $this->tel;
    }

    public function getType(): TypeEnum {
        return $this->type;
    }

    public function getService(): ?Service {
        return $this->service;
    }

    public function setService(?Service $service): void {
        $this->service = $service;
    }
}