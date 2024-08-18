<?php

namespace App\Dto\User;

use App\Entity\User;

class UpdateUserDataDto
{

    private ?string $username;
        private ?string $oldPassword;
        private ?string $newPassword;


    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function setNewPassword(?string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    public function setOldPassword(?string $oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }



    public static function fromEntity(User $user): self
    {
        $dto = new self();
        $dto->setUsername($user->getUsername());
        $dto->setOldPassword($user->getPassword());
        $dto->setNewPassword($user->getPassword());

        return $dto;
    }
}