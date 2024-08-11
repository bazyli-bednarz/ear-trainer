<?php

namespace App\Entity\Trait;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait SluggableTrait
{
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Gedmo\Slug(fields: ['name'])]
    protected ?string $slug = null;


    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

}