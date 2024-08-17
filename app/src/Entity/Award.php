<?php

namespace App\Entity;

use App\Entity\Enum\AwardEnum;
use App\Entity\Trait\IdTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\AwardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AwardRepository::class)]
class Award
{
    use IdTrait;
    use TimestampableTrait;

    #[ORM\Column(type: 'string', length: 100, enumType: AwardEnum::class)]
    private ?AwardEnum $type = null;

    #[ORM\ManyToOne(inversedBy: 'awards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getType(): ?AwardEnum
    {
        return $this->type;
    }

    public function setType(AwardEnum $type): static
    {
        $this->type = $type;

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

    public function getIcon(): string
    {
        return AwardEnum::getIcon($this->type);
    }

    public function getLabel(): string
    {
        return 'ui.award.' . $this->type->value;
    }
}
