<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use Cocur\Slugify\Slugify;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            ['name'=>'inconnue'],
            ['name'=>'théâtre'],
            ['name'=>'danse'],
            ['name'=>'one man show'],
        ];
        
        foreach($categories as $c) {
            $cat = new Category();
            $cat->setName($c['name']);
            
            $manager->persist($cat);
            
            $slugger = new Slugify();
            $reference = $slugger->slugify($c['name']);
            
            $this->addReference($reference, $cat);
        }
        
        $manager->flush();
    }
}
