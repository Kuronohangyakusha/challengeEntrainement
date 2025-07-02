<?php
namespace App\Entity;
class Employe{
    protected int $id;
    protected string $nom;
    protected string $tel;
    protected ?Service $service = null;
    protected Type $type;

    public function __construct(int $id, string $nom, string $tel, Type $type) {
        $this->id = $id;
        $this->nom = $nom;
        $this->tel = $tel;
        $this->type = $type;
    }
}