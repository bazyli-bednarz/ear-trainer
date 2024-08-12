<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\InversionTypeEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Entity\Enum\TwoIntervalsTypeEnum;
use App\Entity\Node;
use App\Entity\Task\Interval;
use App\Entity\Task\IntervalChain;
use App\Entity\Task\RelativePitchSound;
use App\Entity\Task\ThreeNoteChord;
use App\Entity\Task\TwoIntervals;
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


        $exampleTwoIntervals = [
            ['1. Jakie to dwa interwały?', 'Rozpoznaj zagrane interwały!', NoteEnum::C4, NoteEnum::G4, NoteEnum::C4, NoteEnum::E4, false, false, TwoIntervalsTypeEnum::Normal, 20],
            ['2. Jakie to dwa interwały?', 'Rozpoznaj zagrane interwały!', NoteEnum::C4, NoteEnum::C4,  NoteEnum::C4, NoteEnum::F4, false, true, TwoIntervalsTypeEnum::Normal, 20],
            ['3. Jakie to dwa interwały?', 'Rozpoznaj zagrane interwały!', NoteEnum::C4, NoteEnum::D4,  NoteEnum::D4, NoteEnum::DSharp4, false, true, TwoIntervalsTypeEnum::Normal, 20],
            ['4. Jakie to dwa interwały?', 'Rozpoznaj zagrane interwały!', NoteEnum::C4, NoteEnum::D4,  NoteEnum::D4, NoteEnum::DSharp4, true, false, TwoIntervalsTypeEnum::IntervalSquare, 20],
        ];

        foreach ($exampleTwoIntervals as $index => $exampleInterval) {
            $task = new TwoIntervals();
            $task
                ->setName($exampleInterval[0])
                ->setDescription($exampleInterval[1])
                ->setFirstNote($exampleInterval[2])
                ->setSecondNote($exampleInterval[3])
                ->setThirdNote($exampleInterval[4])
                ->setFourthNote($exampleInterval[5])
                ->setIsFirstHarmonic($exampleInterval[6])
                ->setIsSecondHarmonic($exampleInterval[7])
                ->setTwoIntervalsTypeEnum($exampleInterval[8])
                ->setPoints($exampleInterval[9])
            ;

            if ($index > 0) {
                $task->setPreviousTask($this->getReference('task-two-intervals-' . $exampleTwoIntervals[$index - 1][0]));
            }

            $task->setNode($this->getReference('node-intervals-Interwały złożone'));
            $manager->persist($task);
            $this->addReference('task-two-intervals-' . $exampleTwoIntervals[$index][0], $task);
        }

        $exampleIntervalChain = [
            ['1. Łańcuch interwałowy', 'Jaki interwał tworzy łańcuch?', NoteEnum::C4, IntervalEnum::Tritone, false, 20],
            ['2. Łańcuch interwałowy', 'Jaki interwał tworzy łańcuch?', NoteEnum::C4, IntervalEnum::PerfectFifth, false, 20],
            ['3. Łańcuch interwałowy', 'Jaki interwał tworzy łańcuch?', NoteEnum::C4, IntervalEnum::PerfectFourth, false, 20],
            ['4. Łańcuch interwałowy', 'Jaki interwał tworzy łańcuch?', NoteEnum::C4, IntervalEnum::MajorThird, false, 20],
        ];

        foreach ($exampleIntervalChain as $index => $exampleInterval) {
            $task = new IntervalChain();
            $task
                ->setName($exampleInterval[0])
                ->setDescription($exampleInterval[1])
                ->setFirstNote($exampleInterval[2])
                ->setIntervalType($exampleInterval[3])
                ->setIsHarmonic($exampleInterval[4])
                ->setPoints($exampleInterval[5])
            ;

            if ($index > 0) {
                $task->setPreviousTask($this->getReference('task-interval-chain-' . $exampleIntervalChain[$index - 1][0]));
            }

            $task->setNode($this->getReference('node-intervals-Interwały - zaawansowane ćwiczenia'));
            $manager->persist($task);
            $this->addReference('task-interval-chain-' . $exampleIntervalChain[$index][0], $task);
        }


        $exampleThreeNoteChords = [
            ['1. Rozpoznaj akord', 'Rozpoznaj zagrany akord!', NoteEnum::C4, ThreeNoteChordTypeEnum::Major, InversionTypeEnum::NoInversion, false, false, 20],
            ['2. Rozpoznaj akord', 'Rozpoznaj zagrany akord!', NoteEnum::C4, ThreeNoteChordTypeEnum::Minor, InversionTypeEnum::NoInversion, false, false, 20],
            ['3. Rozpoznaj akord', 'Rozpoznaj zagrany akord!', NoteEnum::C4, ThreeNoteChordTypeEnum::Diminished, InversionTypeEnum::NoInversion, false, false, 20],
            ['4. Rozpoznaj akord', 'Rozpoznaj zagrany akord!', NoteEnum::C4, ThreeNoteChordTypeEnum::Augmented, InversionTypeEnum::NoInversion, false, false, 20],
        ];

        foreach ($exampleThreeNoteChords as $index => $exampleChord) {
            $task = new ThreeNoteChord();
            $task
                ->setName($exampleChord[0])
                ->setDescription($exampleChord[1])
                ->setFirstNote($exampleChord[2])
                ->setChord($exampleChord[3])
                ->setInversion($exampleChord[4])
                ->setIsHarmonic($exampleChord[5])
                ->setShouldStudentRecogniseInversion($exampleChord[6])
                ->setPoints($exampleChord[7])
            ;

            if ($index > 0) {
                $task->setPreviousTask($this->getReference('task-three-note-chord-' . $exampleThreeNoteChords[$index - 1][0]));
            }

            $task->setNode($this->getReference('node-chords-Akordy trójdźwiękowe'));
            $manager->persist($task);
            $this->addReference('task-three-note-chord-' . $exampleThreeNoteChords[$index][0], $task);
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
