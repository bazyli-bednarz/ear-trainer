<?php

namespace App\Dto\User;

class UserExperienceDto
{
    public function __construct(
        public readonly int $id,
        public readonly int $experience,
        public readonly int $level,
        public readonly string $username,
        public readonly int $currentExperience,
        public readonly int $experienceToLevelUp,
    )
    {
    }
}