<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $exampleAdmins = [
            ['admin1@eartrainer.com', 'Administrator Kacper', 'zaq1@WSX', ['ROLE_USER', 'ROLE_ADMIN']],
            ['admin2@eartrainer.com', 'Administrator Przemek', 'zaq1@WSX', ['ROLE_USER', 'ROLE_ADMIN']],
            ['admin3@eartrainer.com', 'Administrator Martyna', 'zaq1@WSX', ['ROLE_USER', 'ROLE_ADMIN']],
        ];

        foreach ($exampleAdmins as $adminData) {
            $admin = new User();
            $admin->setEmail($adminData[0]);
            $admin->setUsername($adminData[1]);
            $admin->setPassword($this->passwordHasher->hashPassword($admin, $adminData[2]));
            $admin->setRoles($adminData[3]);
            $manager->persist($admin);
        }

        $exampleUsers = [
            ['user1@eartrainer.com', 'Kasia', 'zaq1@WSX', ['ROLE_USER']],
            ['user2@eartrainer.com', 'Adam', 'zaq1@WSX', ['ROLE_USER']],
            ['user3@eartrainer.com', 'Krzysztof', 'zaq1@WSX', ['ROLE_USER']],
            ['user4@eartrainer.com', 'Żaneta', 'zaq1@WSX', ['ROLE_USER']],
            ['user5@eartrainer.com', 'Karol', 'zaq1@WSX', ['ROLE_USER']],
            ['user6@eartrainer.com', 'Justyna', 'zaq1@WSX', ['ROLE_USER']],
        ];

        foreach ($exampleUsers as $userData) {
            $user = new User();
            $user->setEmail($userData[0]);
            $user->setUsername($userData[1]);
            $user->setPassword($this->passwordHasher->hashPassword($user, $userData[2]));
            $user->setRoles($userData[3]);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
