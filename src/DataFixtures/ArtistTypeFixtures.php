<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\ArtistType;

class ArtistTypeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fixtures = [
          [
              'artist'=>'bob-sull',
              'type'=>'comedien',
          ],
          [
              'artist'=>'marc-flynn',
              'type'=>'metteur-en-scene',
          ],
          [
              'artist'=>'fred-durand',
              'type'=>'comedien',
          ],
          [
              'artist'=>'marc-flynn',
              'type'=>'dramaturge',
          ],
          [
              'artist'=>'bob-sull',
              'type'=>'metteur-en-scene',
          ],
          [
              'artist'=>'fred-durand',
              'type'=>'metteur-en-scene',
          ],
          [
              'artist'=>'marc-flynn',
              'type'=>'comedien',
          ],
        ];
        
        foreach($fixtures as $data) {
            $artistType = new ArtistType();
            $artistType->setArtist($this->getReference($data['artist']));
            $artistType->setType($this->getReference($data['type']));
                        
            $manager->persist($artistType);
            
            $this->addReference("{$data['artist']}-{$data['type']}", $artistType);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            ArtistFixtures::class,
            TypeFixtures::class,
        ];
    }

}
