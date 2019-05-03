<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Representation;
use App\Entity\Show;
use App\Entity\Location;

class RepresentationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fixtures = [
          [
              'the_show'=>'ayiti',
              'the_location'=>'belfius-art-collection',
              'the_date'=> new \DateTime('2012-10-12 13:30:00'),
          ],
          [
              'the_show'=>'ayiti',
              'the_location'=>'theatre-royal-parc',
              'the_date'=> new \DateTime('2012-10-12 20:30:00'),
          ],
          [
              'the_show'=>'cible-mouvante',
              'the_location'=>null,
              'the_date'=> new \DateTime('2012-10-12 20:30:00'),
          ],
          [
              'the_show'=>'cible-mouvante',
              'the_location'=>null,
              'the_date'=> new \DateTime('2012-10-14 20:30:00'),
          ],
          [
              'the_show'=>'ceci-n-est-pas-un-chanteur-belge',
              'the_location'=>null,
              'the_date'=> new \DateTime('2012-10-14 20:30:00'),
          ],
        ];
        
        foreach($fixtures as $data) {
            $representation = new Representation();
            $representation->setTheShow($this->getReference($data['the_show']));
            
            if($data['the_location']!=null) {
                $representation->setTheLocation($this->getReference($data['the_location']));
            }

            $representation->setTheDate($data['the_date']);
            
            $manager->persist($representation);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            ShowFixtures::class,
            LocationFixtures::class,
        ];
    }

}
