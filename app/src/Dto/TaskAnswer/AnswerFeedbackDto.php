<?php

namespace App\Dto\TaskAnswer;

class AnswerFeedbackDto
{
    public function __construct(
        private readonly string $feedback,
        private readonly bool $isCorrect,
        private readonly int $points = 0
    )
    {
    }

    public function getFeedback(): string
    {
        return $this->feedback;
    }

    public function getIsCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function getPoints(): int
    {
        return $this->points;
    }
}