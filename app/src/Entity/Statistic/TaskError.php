<?php

namespace App\Entity\Statistic;

use App\Entity\Trait\IdTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Entity\User;
use App\Repository\Statistic\TaskErrorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskErrorRepository::class)]
#[ORM\Table(name: 'task_errors')]
class TaskError
{
    use IdTrait;
    use TimestampableTrait;

    #[ORM\Column]
    private ?int $taskId = null;

    #[ORM\ManyToOne(inversedBy: 'taskErrors')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getTaskId(): ?int
    {
        return $this->taskId;
    }

    public function setTaskId(int $taskId): static
    {
        $this->taskId = $taskId;

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
