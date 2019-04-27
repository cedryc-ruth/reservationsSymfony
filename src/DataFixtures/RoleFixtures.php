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
          ['role'=>'membre'],
        ];
        
        foreach($roles as $r) {
            $role = new Role();
            $role->setRole($r['role']);
            
            $manager->persist($role);
        }

        $manager->flush();
    }
}
