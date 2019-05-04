<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Type;
use Cocur\Slugify\Slugify;

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
            
            $slugger = new Slugify();
            $reference = $slugger->slugify($t['type']);
            
            $this->addReference($reference, $type);
        }
        
        $manager->flush();
    }
}
