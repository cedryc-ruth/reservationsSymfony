<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Role;

class RoleFixtures extends Fixture
{
     public function load(ObjectManager $manager)
    {
        $roles = [
            ['role'=>'admin'],
            ['role'=>'user'],
           
        ];
        
        foreach($roles as $r) {
            $role = new Role();
            $role->setRole($r['role']);
            
            $this->addReference($r['role'], $role);
            
            $manager->persist($role);
        }
        
        $manager->flush();
    }
}
