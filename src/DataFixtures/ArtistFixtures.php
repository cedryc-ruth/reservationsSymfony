<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Artist;
use Cocur\Slugify\Slugify;

class ArtistFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $artists = [
          ['firstname'=>'Bob','lastname'=>'Sull'],  
          ['firstname'=>'Marc','lastname'=>'flynn'],  
          ['firstname'=>'Fred','lastname'=>'Durand'],  
        ];
        
        foreach($artists as $a) {
            $artist = new Artist();
            $artist->setFirstname($a['firstname']);
            $artist->setLastname($a['lastname']);
            
            $manager->persist($artist);
            
            $slugger = new Slugify();
            $reference = $slugger->slugify($a['firstname']." ".$a['lastname']);

            $this->addReference($reference, $artist);
        }
        
        $manager->flush();
    }
}
