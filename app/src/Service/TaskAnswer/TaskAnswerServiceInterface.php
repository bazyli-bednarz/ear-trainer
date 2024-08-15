<?php

namespace App\Service\TaskAnswer;


use App\Dto\TaskAnswer\AnswerFeedbackDto;
use App\Dto\TaskAnswer\TaskAnswerDto;
use App\Entity\Task\AbstractTask;

interface TaskAnswerServiceInterface
{

    public function handleAnswer(TaskAnswerDto $dto, AbstractTask $task): AnswerFeedbackDto;

}