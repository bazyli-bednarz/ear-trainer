<?php

namespace App\Entity\Statistic;

use App\Entity\Trait\IdTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Entity\User;
use App\Repository\Statistic\ExperienceStatisticRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceStatisticRepository::class)]
class ExperienceStatistic
{
    use IdTrait;
    use TimestampableTrait;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
