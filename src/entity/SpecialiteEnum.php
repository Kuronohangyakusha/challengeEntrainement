<?php

namespace App\Entity;


enum SpecialiteEnum: string {
    case FullStack = 'FullStack';
    case FrontEnd = 'FrontEnd';
    case BackEnd = 'BackEnd';
}