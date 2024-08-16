<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum UserRole: string
{
    case ROLE_USER = 'ROLE_USER';
    case ROLE_ADMIN = 'ROLE_ADMIN';

    public function label(): string
    {
        return match ($this) {
            UserRole::ROLE_USER => 'ui.roles.role_user',
            UserRole::ROLE_ADMIN => 'ui.roles.role_admin',
        };
    }

    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans($this->label());
    }
}
