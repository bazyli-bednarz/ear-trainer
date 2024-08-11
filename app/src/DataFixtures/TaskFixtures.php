<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Enum\NoteEnum;
use App\Entity\Node;
use App\Entity\Task\Interval;
use App\Entity\Task\RelativePitchSound;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $exampleRelativePitchSounds = [
            ['1. Który dźwięk jest wyższy?', 'Wyższy jest pierwszy dźwięk, drugi dźwięk, czy może są identyczne?', NoteEnum::C5, NoteEnum::G5, 10],
            ['2. Który dźwięk jest wyższy?', 'Wyższy jest pierwszy dźwięk, drugi dźwięk, czy może są identyczne?', NoteEnum::G5, NoteEnum::C5, 10],
            ['3. Który dźwięk jest wyższy?', 'Wyższy jest pierwszy dźwięk, drugi dźwięk, czy może są identyczne?', NoteEnum::C4, NoteEnum::CSharp4, 10],
            ['4. Który dźwięk jest wyższy?', 'Wyższy jest pierwszy dźwięk, drugi dźwięk, czy może są identyczne?', NoteEnum::G5, NoteEnum::G5, 10],
        ];

        foreach ($exampleRelativePitchSounds as $index => $exampleRelativePitchSound) {
            $task = new RelativePitchSound();
            $task
                ->setName($exampleRelativePitchSound[0])
                ->setDescription($exampleRelativePitchSound[1])
                ->setFirstNote($exampleRelativePitchSound[2])
                ->setSecondNote($exampleRelativePitchSound[3])
                ->setPoints($exampleRelativePitchSound[4]);

            if ($index > 0) {
                $task->setPreviousTask($this->getReference('task-relative-pitch-sound-' . $exampleRelativePitchSounds[$index - 1][0]));
            }

            $task->setNode($this->getReference('node-intervals-Pierwsze kroki'));
            $manager->persist($task);
            $this->addReference('task-relative-pitch-sound-' . $exampleRelativePitchSound[0], $task);
        }

        $exampleIntervals = [
            ['1. Jaki to interwał?', 'Rozpoznaj zagrany interwał!', NoteEnum::C4, NoteEnum::G4, false, 15],
            ['2. Jaki to interwał?', 'Rozpoznaj zagrany interwał!', NoteEnum::C4, NoteEnum::C4, true, 15],
            ['3. Jaki to interwał?', 'Rozpoznaj zagrany interwał!', NoteEnum::C4, NoteEnum::CSharp4, false, 15],
            ['4. Jaki to interwał?', 'Rozpoznaj zagrany interwał!', NoteEnum::C4, NoteEnum::FSharp4, true, 15],
        ];



        foreach ($exampleIntervals as $index => $exampleInterval) {
            $task = new Interval();
            $task
                ->setName($exampleInterval[0])
                ->setDescription($exampleInterval[1])
                ->setFirstNote($exampleInterval[2])
                ->setSecondNote($exampleInterval[3])
                ->setIsHarmonic($exampleInterval[4])
                ->setPoints($exampleInterval[5]);

            if ($index > 0) {
                $task->setPreviousTask($this->getReference('task-interval-' . $exampleIntervals[$index - 1][0]));
            }

            $task->setNode($this->getReference('node-intervals-Interwały proste'));
            $manager->persist($task);
            $this->addReference('task-interval-' . $exampleIntervals[$index][0], $task);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            NodeFixtures::class,
        ];
    }
}
