<?php

namespace App\Service\TaskAnswer;

use App\Dto\Task\TaskDto;
use App\Dto\TaskAnswer\AnswerFeedbackDto;
use App\Dto\TaskAnswer\TaskAnswerDto;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Entity\Enum\TwoIntervalsTypeEnum;
use App\Entity\User;
use App\Service\Statistic\TaskStatisticServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Task\AbstractTask;
use App\Entity\Task\FourNoteChord;
use App\Entity\Task\Interval;
use App\Entity\Task\IntervalChain;
use App\Entity\Task\RelativePitchSound;
use App\Entity\Task\Scale;
use App\Entity\Task\ThreeNoteChord;
use App\Entity\Task\TwoIntervals;
use App\Repository\AbstractTaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskAnswerService implements TaskAnswerServiceInterface
{
    public function __construct(
        private readonly AbstractTaskRepository        $abstractTaskRepository,
        private readonly EntityManagerInterface        $em,
        private readonly TranslatorInterface           $translator,
        private readonly TaskStatisticServiceInterface $taskStatisticService,
        private readonly Security                      $security,
    )
    {
    }


    public function handleAnswer(TaskAnswerDto $dto, AbstractTask $task): AnswerFeedbackDto
    {
        switch ($task->getType()) {
            case TaskTypeEnum::RelativePitchSound:
                /** @var RelativePitchSound $task */
                $feedback = $this->handleRelativePitchSoundAnswer($dto, $task);
                break;
            case TaskTypeEnum::Interval:
                /** @var Interval $task */
                $feedback = $this->handleIntervalAnswer($dto, $task);
                break;
            case TaskTypeEnum::TwoIntervals:
                /** @var TwoIntervals $task */
                $feedback = $this->handleTwoIntervalsAnswer($dto, $task);
                break;
            case TaskTypeEnum::IntervalChain:
                /** @var IntervalChain $task */
                $feedback = $this->handleIntervalChainAnswer($dto, $task);
                break;
            case TaskTypeEnum::ThreeNoteChord:
                /** @var ThreeNoteChord $task */
                $feedback = $this->handleThreeNoteChordAnswer($dto, $task);
                break;
            case TaskTypeEnum::FourNoteChord:
                /** @var FourNoteChord $task */
                $feedback = $this->handleFourNoteChordAnswer($dto, $task);
                break;
            case TaskTypeEnum::Scale:
                /** @var Scale $task */
                $feedback = $this->handleScaleAnswer($dto, $task);
                break;
            default:
                throw new \InvalidArgumentException('Invalid task type');
        }

        /** @var User $user */
        $user = $this->security->getUser();

        if ($feedback->getIsCorrect()) {
            $this->taskStatisticService->addStatistic($user, $task);
        }

        return $feedback;
    }

    private function handleRelativePitchSoundAnswer(TaskAnswerDto $dto, RelativePitchSound $task): AnswerFeedbackDto
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if ($task->getCorrectAnswer() === $dto->getRelativePitchSoundAnswer()) {
            $feedback = 'ui.answer.correct';
            $isCorrect = true;
            $points = $this->taskStatisticService->determinePoints($user, $task);
        } else {
            $feedback = 'ui.answer.incorrect';
            $isCorrect = false;
            $points = 0;
        }

        return new AnswerFeedbackDto(
            $this->translator->trans($feedback, ['%points%' => $points]),
            $isCorrect,
            $points
        );
    }

    private function handleIntervalAnswer(TaskAnswerDto $dto, Interval $task): AnswerFeedbackDto
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if ($task->getIntervalType() === $dto->getIntervalAnswer()) {
            $feedback = 'ui.answer.correct';
            $isCorrect = true;
            $points = $this->taskStatisticService->determinePoints($user, $task);
        } else {
            $feedback = 'ui.answer.incorrect';
            $isCorrect = false;
            $points = 0;
        }

        return new AnswerFeedbackDto(
            $this->translator->trans($feedback, ['%points%' => $points]),
            $isCorrect,
            $points
        );
    }

    private function handleTwoIntervalsAnswer(TaskAnswerDto $dto, TwoIntervals $task): AnswerFeedbackDto
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if ($task->getTwoIntervalsTypeEnum() === TwoIntervalsTypeEnum::IntervalSquare) {
            $isFirstIntervalCorrect = $task->getFirstIntervalType() === $dto->getFirstIntervalAnswer();
            $isSecondIntervalCorrect = $task->getSecondIntervalType() === $dto->getSecondIntervalAnswer();
            $isUpperEdgeIntervalCorrect = $task->getUpperEdgeIntervalType() === $dto->getUpperEdgeIntervalAnswer();
            $isLowerEdgeIntervalCorrect = $task->getLowerEdgeIntervalType() === $dto->getLowerEdgeIntervalAnswer();


            if (
                $isFirstIntervalCorrect
                && $isSecondIntervalCorrect
                && $isUpperEdgeIntervalCorrect
                && $isLowerEdgeIntervalCorrect
            ) {
                $feedback = 'ui.answer.correct';
                $points = $this->taskStatisticService->determinePoints($user, $task);

                return new AnswerFeedbackDto(
                    $this->translator->trans($feedback, ['%points%' => $points]),
                    true,
                    $points
                );
            }

            if (
                $isFirstIntervalCorrect
                && $isSecondIntervalCorrect
                && ((!$isUpperEdgeIntervalCorrect) || (!$isLowerEdgeIntervalCorrect))
            ) {
                $feedback = 'ui.answer.incorrectEdgeInterval';
                $points = 0;

                return new AnswerFeedbackDto(
                    $this->translator->trans($feedback, ['%points%' => $points]),
                    false,
                    $points
                );
            }

            $feedback = 'ui.answer.incorrect';
            $points = 0;


            return new AnswerFeedbackDto(
                $this->translator->trans($feedback, ['%points%' => $points]),
                false,
                $points
            );
        }


        if ($task->getTwoIntervalsTypeEnum() === TwoIntervalsTypeEnum::Normal) {
            if (
                $task->getFirstIntervalType() === $dto->getFirstIntervalAnswer()
                && $task->getSecondIntervalType() === $dto->getSecondIntervalAnswer()
            ) {
                $feedback = 'ui.answer.correct';
                $isCorrect = true;
                $points = $this->taskStatisticService->determinePoints($user, $task);

            } else {
                $feedback = 'ui.answer.incorrect';
                $isCorrect = false;
                $points = 0;
            }

            return new AnswerFeedbackDto(
                $this->translator->trans($feedback, ['%points%' => $points]),
                $isCorrect,
                $points
            );
        }

        throw new \InvalidArgumentException('Invalid two intervals type');
    }


    private function handleIntervalChainAnswer(TaskAnswerDto $dto, IntervalChain $task): AnswerFeedbackDto
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if ($task->getIntervalType() === $dto->getIntervalAnswer()) {
            $feedback = 'ui.answer.correct';
            $isCorrect = true;
            $points = $this->taskStatisticService->determinePoints($user, $task);
        } else {
            $feedback = 'ui.answer.incorrect';
            $isCorrect = false;
            $points = 0;
        }

        return new AnswerFeedbackDto(
            $this->translator->trans($feedback, ['%points%' => $points]),
            $isCorrect,
            $points
        );
    }


    private function handleThreeNoteChordAnswer(TaskAnswerDto $dto, ThreeNoteChord $task): AnswerFeedbackDto
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if (
            $task->getShouldStudentRecogniseInversion()
            && $task->getChord() !== ThreeNoteChordTypeEnum::Augmented
        ) {
            if (
                $task->getChord() === $dto->getThreeNoteChordAnswer()
                && $task->getInversion() === $dto->getInversionAnswer()

            ) {
                $feedback = 'ui.answer.correct';
                $points = $this->taskStatisticService->determinePoints($user, $task);

                return new AnswerFeedbackDto(
                    $this->translator->trans($feedback, ['%points%' => $points]),
                    true,
                    $points
                );
            }

            if (
                $task->getChord() === $dto->getThreeNoteChordAnswer()
                && $task->getInversion() !== $dto->getInversionAnswer()
            ) {
                $feedback = 'ui.answer.incorrectInversion';
                $points = 0;

                return new AnswerFeedbackDto(
                    $this->translator->trans($feedback, ['%points%' => $points]),
                    false,
                    $points
                );
            }

            $feedback = 'ui.answer.incorrect';
            $isCorrect = false;
            $points = 0;

            return new AnswerFeedbackDto(
                $this->translator->trans($feedback, ['%points%' => $points]),
                false,
                $points
            );
        }

        if ($task->getChord() === $dto->getThreeNoteChordAnswer()) {
            $feedback = 'ui.answer.correct';
            $isCorrect = true;
            $points = $this->taskStatisticService->determinePoints($user, $task);
        } else {
            $feedback = 'ui.answer.incorrect';
            $isCorrect = false;
            $points = 0;
        }

        return new AnswerFeedbackDto(
            $this->translator->trans($feedback, ['%points%' => $points]),
            $isCorrect,
            $points
        );
    }

    private function handleFourNoteChordAnswer(TaskAnswerDto $dto, FourNoteChord $task): AnswerFeedbackDto
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if (
            $task->getFourNoteChord() === $dto->getFourNoteChordAnswer()
        ) {
            $feedback = 'ui.answer.correct';
            $isCorrect = true;
            $points = $this->taskStatisticService->determinePoints($user, $task);
        } else {
            $feedback = 'ui.answer.incorrect';
            $isCorrect = false;
            $points = 0;
        }

        return new AnswerFeedbackDto(
            $this->translator->trans($feedback, ['%points%' => $points]),
            $isCorrect,
            $points
        );
    }


    private function handleScaleAnswer(TaskAnswerDto $dto, Scale $task): AnswerFeedbackDto
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if (
            $task->getScaleType() === $dto->getScaleAnswer()
        ) {
            $feedback = 'ui.answer.correct';
            $isCorrect = true;
            $points = $this->taskStatisticService->determinePoints($user, $task);
        } else {
            $feedback = 'ui.answer.incorrect';
            $isCorrect = false;
            $points = 0;
        }

        return new AnswerFeedbackDto(
            $this->translator->trans($feedback, ['%points%' => $points]),
            $isCorrect,
            $points
        );
    }
}
