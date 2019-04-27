<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'login'=>'bob',
                'password'=>'123',
                'role'=>'admin',
                'firstname'=>'Bob',
                'lastname'=>'Sull',
                'email'=>'bob@sull.com',
                'langue'=>'fr',
                ],
            [
                'login'=>'fred',
                'password'=>'123',
                'role'=>'membre',
                'firstname'=>'Fred',
                'lastname'=>'Sull',
                'email'=>'fred@sull.com',
                'langue'=>'en',
            ],
        ];
        
        foreach($users as $u) {
            $user = new User();
            $user->setLogin($u['login']);
            $user->setPassword(password_hash($u['password'], PASSWORD_BCRYPT));
            $user->setRole($this->getReference($u['role']));
            $user->setFirstname($u['firstname']);
            $user->setLastname($u['lastname']);
            $user->setEmail($u['email']);
            $user->setLangue($u['langue']);
            
            $manager->persist($user);
        }
        
        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            RoleFixtures::class,
        ];
        
    }

}
