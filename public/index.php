<?php
require_once '../vendor/autoload.php';

 

use App\Entity\Employe;
use App\Entity\Admin;
use App\Entity\TypeEnum;
use App\Entity\SpecialiteEnum; 
use App\Entity\Service;
use App\Entity\Manager; 
use App\Entity\Developper; 

$service = new Service(1,"DRH");
$manager= new Manager(1,"Ndeye",'770689591',$service);
$Developper = new Developper(1,'Bakary','770689591',);