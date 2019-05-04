<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Reservation;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fixtures = [
          [
              'representation'=>'ayiti-20121012133000',
              'user'=>'bob',
              'places'=>2,
          ],
          [
              'representation'=>'cible-mouvante-20121012203000',
              'user'=>'fred',
              'places'=>1,
          ],
          [
              'representation'=>'ceci-n-est-pas-un-chanteur-belge-20121014203000',
              'user'=>'bob',
              'places'=>5,
          ]
        ];
        
        foreach($fixtures as $data) {
            $reservation = new Reservation();
            $reservation->setRepresentation($this->getReference($data['representation']));
            $reservation->setUser($this->getReference($data['user']));
            $reservation->setPlaces($data['places']);
                        
            $manager->persist($reservation);
            
            $this->addReference("{$data['representation']}-{$data['user']}", $reservation);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            RepresentationFixtures::class,
            UserFixtures::class,
        ];
    }

}
