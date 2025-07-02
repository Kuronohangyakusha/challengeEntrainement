<?php
namespace App\Entity;

enum TypeEnum: string {
    case Admin = 'Admin';
    case Developpeur = 'Developpeur';
    case Manager = 'Manager';
}

