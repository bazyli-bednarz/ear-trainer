<?php

namespace App\Service\User;

use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

interface UserServiceInterface
{
    public function updateUsername(User $user, string $username): void;
    public function upgradePassword(User $user, string $password): void;
}
