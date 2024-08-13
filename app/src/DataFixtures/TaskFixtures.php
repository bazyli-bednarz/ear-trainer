<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Enum\FourNoteChordTypeEnum;
use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\InversionTypeEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\ScaleTypeEnum;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Entity\Enum\TwoIntervalsTypeEnum;
use App\Entity\Node;
use App\Entity\Task\FourNoteChord;
use App\Entity\Task\Interval;
use App\Entity\Task\IntervalChain;
use App\Entity\Task\RelativePitchSound;
use App\Entity\Task\Scale;
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
            ['1. Jaki to interwał?', 'Rozpoznaj zagrany interwał!', NoteEnum::C4, IntervalEnum::Tritone, false, 15],
            ['2. Jaki to interwał?', 'Rozpoznaj zagrany interwał!', NoteEnum::C4, IntervalEnum::MajorThird, true, 15],
            ['3. Jaki to interwał?', 'Rozpoznaj zagrany interwał!', NoteEnum::C4, IntervalEnum::PerfectFifth, false, 15],
            ['4. Jaki to interwał?', 'Rozpoznaj zagrany interwał!', NoteEnum::C4, IntervalEnum::PerfectFourth, true, 15],
        ];



        foreach ($exampleIntervals as $index => $exampleInterval) {
            $task = new Interval();
            $task
                ->setName($exampleInterval[0])
                ->setDescription($exampleInterval[1])
                ->setFirstNote($exampleInterval[2])
                ->setIntervalType($exampleInterval[3])
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
            ['1. Jakie to dwa interwały?', 'Rozpoznaj zagrane interwały!', NoteEnum::C4, NoteEnum::G4, IntervalEnum::PerfectFourth, IntervalEnum::PerfectFifth, false, false, TwoIntervalsTypeEnum::Normal, 20],
            ['2. Jakie to dwa interwały?', 'Rozpoznaj zagrane interwały!', NoteEnum::C4, NoteEnum::C4,  IntervalEnum::MajorThird, IntervalEnum::MajorThird, false, true, TwoIntervalsTypeEnum::Normal, 20],
            ['3. Jakie to dwa interwały?', 'Rozpoznaj zagrane interwały!', NoteEnum::C4, NoteEnum::D4,  IntervalEnum::Tritone, IntervalEnum::MajorNinth, false, true, TwoIntervalsTypeEnum::Normal, 20],
            ['4. Jakie to dwa interwały?', 'Rozpoznaj zagrane interwały!', NoteEnum::C4, NoteEnum::D4,  IntervalEnum::Tritone, IntervalEnum::PerfectUnison, true, false, TwoIntervalsTypeEnum::IntervalSquare, 20],
        ];

        foreach ($exampleTwoIntervals as $index => $exampleInterval) {
            $task = new TwoIntervals();
            $task
                ->setName($exampleInterval[0])
                ->setDescription($exampleInterval[1])
                ->setFirstNote($exampleInterval[2])
                ->setSecondNote($exampleInterval[3])
                ->setFirstIntervalType($exampleInterval[4])
                ->setSecondIntervalType($exampleInterval[5])
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

        $exampleMajorChords = [
            ['1. Rozpoznaj akord', 'Rozpoznaj zagrany akord durowy!', NoteEnum::C4, ThreeNoteChordTypeEnum::Major, InversionTypeEnum::NoInversion, false, false, 20],
            ['2. Rozpoznaj akord', 'Rozpoznaj zagrany akord durowy!', NoteEnum::G4, ThreeNoteChordTypeEnum::Major, InversionTypeEnum::NoInversion, false, false, 20],
            ['3. Rozpoznaj akord', 'Rozpoznaj zagrany akord durowy!', NoteEnum::F4, ThreeNoteChordTypeEnum::Major, InversionTypeEnum::NoInversion, false, false, 20],
            ['4. Rozpoznaj akord', 'Rozpoznaj zagrany akord durowy!', NoteEnum::E4, ThreeNoteChordTypeEnum::Major, InversionTypeEnum::NoInversion, true, false, 20],
        ];

        foreach ($exampleMajorChords as $index => $exampleChord) {
            $task = new ThreeNoteChord();
            $task
                ->setName($exampleChord[0])
                ->setDescription($exampleChord[1])
                ->setFirstNote($exampleChord[2])
                ->setChord($exampleChord[3])
                ->setInversion($exampleChord[4])
                ->setIsHarmonic($exampleChord[5])
                ->setShouldStudentRecogniseInversion($exampleChord[6])
                ->setPoints($exampleChord[7]);

            if ($index > 0) {
                $task->setPreviousTask($this->getReference('task-major-chord-' . $exampleMajorChords[$index - 1][0]));
            }

            $task->setNode($this->getReference('node-chords-Akordy durowe'));
            $manager->persist($task);
            $this->addReference('task-major-chord-' . $exampleMajorChords[$index][0], $task);
        }

        $exampleMinorChords = [
            ['1. Rozpoznaj akord', 'Rozpoznaj zagrany akord molowy!', NoteEnum::C4, ThreeNoteChordTypeEnum::Minor, InversionTypeEnum::NoInversion, false, false, 20],
            ['2. Rozpoznaj akord', 'Rozpoznaj zagrany akord molowy!', NoteEnum::DSharp4, ThreeNoteChordTypeEnum::Minor, InversionTypeEnum::NoInversion, false, false, 20],
            ['3. Rozpoznaj akord', 'Rozpoznaj zagrany akord molowy!', NoteEnum::E4, ThreeNoteChordTypeEnum::Minor, InversionTypeEnum::NoInversion, false, false, 20],
            ['4. Rozpoznaj akord', 'Rozpoznaj zagrany akord molowy!', NoteEnum::F4, ThreeNoteChordTypeEnum::Minor, InversionTypeEnum::NoInversion, true, false, 20],
        ];

        foreach ($exampleMinorChords as $index => $exampleChord) {
            $task = new ThreeNoteChord();
            $task
                ->setName($exampleChord[0])
                ->setDescription($exampleChord[1])
                ->setFirstNote($exampleChord[2])
                ->setChord($exampleChord[3])
                ->setInversion($exampleChord[4])
                ->setIsHarmonic($exampleChord[5])
                ->setShouldStudentRecogniseInversion($exampleChord[6])
                ->setPoints($exampleChord[7]);

            if ($index > 0) {
                $task->setPreviousTask($this->getReference('task-minor-chord-' . $exampleMinorChords[$index - 1][0]));
            }

            $task->setNode($this->getReference('node-chords-Akordy molowe'));
            $manager->persist($task);
            $this->addReference('task-minor-chord-' . $exampleMinorChords[$index][0], $task);
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

        $exampleFourNoteChords = [
            ['1. Rozpoznaj akord', 'Rozpoznaj zagrany akord czterodźwiękowy!', NoteEnum::C4, FourNoteChordTypeEnum::Dominant7, false, 25],
            ['2. Rozpoznaj akord', 'Rozpoznaj zagrany akord czterodźwiękowy!', NoteEnum::C4, FourNoteChordTypeEnum::MajorMajor7, false, 30],
            ['3. Rozpoznaj akord', 'Rozpoznaj zagrany akord czterodźwiękowy!', NoteEnum::C4, FourNoteChordTypeEnum::MinorMajor7, false, 30],
            ['4. Rozpoznaj akord', 'Rozpoznaj zagrany akord czterodźwiękowy!', NoteEnum::C4, FourNoteChordTypeEnum::MinorMinor7, false, 30],
        ];

        foreach ($exampleFourNoteChords as $index => $exampleChord) {
            $task = new FourNoteChord();
            $task
                ->setName($exampleChord[0])
                ->setDescription($exampleChord[1])
                ->setFirstNote($exampleChord[2])
                ->setFourNoteChord($exampleChord[3])
                ->setIsHarmonic($exampleChord[4])
                ->setPoints($exampleChord[5])
            ;

            if ($index > 0) {
                $task->setPreviousTask($this->getReference('task-four-note-chord-' . $exampleFourNoteChords[$index - 1][0]));
            }

            $task->setNode($this->getReference('node-chords-Akordy czterodźwiękowe'));
            $manager->persist($task);
            $this->addReference('task-four-note-chord-' . $exampleFourNoteChords[$index][0], $task);
        }

        $exampleScales = [
            ['1. Rozpoznaj skalę', 'Rozpoznaj zagrane dźwięki skali!', NoteEnum::C4, ScaleTypeEnum::Major, 20],
            ['2. Rozpoznaj skalę', 'Rozpoznaj zagrane dźwięki skali!', NoteEnum::C4, ScaleTypeEnum::Minor, 20],
            ['3. Rozpoznaj skalę', 'Rozpoznaj zagrane dźwięki skali!', NoteEnum::C4, ScaleTypeEnum::HarmonicMinor, 20],
            ['4. Rozpoznaj skalę', 'Rozpoznaj zagrane dźwięki skali!', NoteEnum::C4, ScaleTypeEnum::MelodicMinor, 20],
        ];

        foreach ($exampleScales as $index => $scale) {
            $task = new Scale();
            $task
                ->setName($scale[0])
                ->setDescription($scale[1])
                ->setFirstNote($scale[2])
                ->setScaleType($scale[3])
                ->setPoints($scale[4])
            ;

            if ($index > 0) {
                $task->setPreviousTask($this->getReference('task-scale-' . $exampleScales[$index - 1][0]));
            }

            $task->setNode($this->getReference('node-scales-Poznaj skale'));
            $manager->persist($task);
            $this->addReference('task-scale-' . $exampleScales[$index][0], $task);
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
