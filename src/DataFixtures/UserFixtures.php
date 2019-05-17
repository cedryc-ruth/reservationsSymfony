<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

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
                'role'=>'user',
                'firstname'=>'Fred',
                'lastname'=>'Sull',
                'email'=>'fred@sull.com',
                'langue'=>'en',
            ],
        ];
        
        foreach($users as $u) {
            $user = new User();
            $user->setLogin($u['login']);
            $user->setPassword($this->passwordEncoder->encodePassword($user,$u['password']));
            $user->setRole($this->getReference($u['role']));
            $user->setFirstname($u['firstname']);
            $user->setLastname($u['lastname']);
            $user->setEmail($u['email']);
            $user->setLangue($u['langue']);
            
            $manager->persist($user);
            
            $this->addReference($u['login'], $user);
        }
        
        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            RoleFixtures::class,
        ];
        
    }

}
