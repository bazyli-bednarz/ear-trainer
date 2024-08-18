<?php

namespace App\Service\User;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserService.
 */
class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    )
    {
    }

    public function upgradePassword(User $user, string $password): void
    {
        $user->setPassword($password);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function updateUsername(User $user, string $username): void
    {
        $user->setUsername($username);

        $this->em->persist($user);
        $this->em->flush();
    }
}
