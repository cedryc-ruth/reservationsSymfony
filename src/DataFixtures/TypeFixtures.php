<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Type;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $types = [
            ['type'=>'scénographe'],
            ['type'=>'metteur en scène'],
            ['type'=>'comédien'],
            ['type'=>'dramaturge'],
           
        ];
        
        foreach($types as $t) {
            $type = new Type();
            $type->setType($t['type']);
            
            $manager->persist($type);
        }
        
        $manager->flush();
    }
}
