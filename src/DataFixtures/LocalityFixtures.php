<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Locality;

class LocalityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $localities = [
          ['postal_code'=>'1000','locality'=>'Bruxelles'],  
          ['postal_code'=>'1020','locality'=>'Laeken'],  
          ['postal_code'=>'1030','locality'=>'Schaerbeek'],  
          ['postal_code'=>'1050','locality'=>'Ixelles'],  
          ['postal_code'=>'1090','locality'=>'Jette'],  
          ['postal_code'=>'1180','locality'=>'Uccle'],  
          ['postal_code'=>'4000','locality'=>'Liège'],  
          ['postal_code'=>'5000','locality'=>'Namur'],  
          ['postal_code'=>'6000','locality'=>'Charleroi'],  
        ];
        
        foreach($localities as $l) {
            $locality = new Locality();
            $locality->setPostalCode($l['postal_code']);
            $locality->setLocality($l['locality']);
            
            $manager->persist($locality);
        }

        $manager->flush();
    }
}
