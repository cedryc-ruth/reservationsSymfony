<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Show;
use App\DataFixtures\LocationFixtures;

class ShowFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fixtures = [
          [
              'slug'=>'ayiti',
              'title'=>'Ayiti',
              'poster_url'=>'images/ayiti.jpg',
              'location'=>'belfius-art-collection',
              'bookable'=>1,
              'price'=>9.50,
          ],
          [
              'slug'=>'cible-mouvante',
              'title'=>'Cible Mouvante',
              'poster_url'=>'images/cible.jpg',
              'location'=>'la-samaritaine',
              'bookable'=>1,
              'price'=>8.50,
          ],
          [
              'slug'=>'ceci-n-est-pas-un-chanteur-belge',
              'title'=>'Ceci n\'est pas un chanteur belge',
              'poster_url'=>'images/claudebelgesaison220.jpg',
              'location'=>'belfius-art-collection',
              'bookable'=>0,
              'price'=>7.50,
          ],
        ];
        
        foreach($fixtures as $data) {
            $show = new Show();
            $show->setSlug($data['slug']);
            $show->setTitle($data['title']);
            $show->setPosterUrl($data['poster_url']);
            $show->setLocation($this->getReference($data['location']));
            $show->setBookable($data['bookable']);
            $show->setPrice($data['price']);
            
            $manager->persist($show);
            
            $this->addReference($data['slug'], $show);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            LocationFixtures::class,  
        ];
    }

}
