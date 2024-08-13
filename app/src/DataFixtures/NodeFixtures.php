<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Node;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $exampleNodesIntervals = [
            ['Pierwsze kroki', 'Zaczynamy od podstaw. Poznaj interwały!', 'bi bi-stars'],
            ['Interwały proste', 'Interwały proste to odstępy między dźwiękami, które są w obrębie jednej oktawy.', 'bi bi-music-note'],
            ['Interwały złożone', 'Interwały złożone to odstępy między dźwiękami, które przekraczają jedną oktawę.', 'bi bi-music-note-beamed'],
            ['Interwały - zaawansowane ćwiczenia', 'Rozpoznawanie interwałów to kluczowa umiejętność każdego muzyka.', 'fa-solid fa-music'],
        ];

        foreach ($exampleNodesIntervals as $index => $nodeExample) {
            $node = new Node();
            $node
                ->setName($nodeExample[0])
                ->setDescription($nodeExample[1])
                ->setIcon($nodeExample[2])
            ;

            if ($index > 0) {
                $node->setPreviousNode($this->getReference('node-intervals-' . $exampleNodesIntervals[$index - 1][0]));
            }

            $node->setCourse($this->getReference('course-intervals'));

            $manager->persist($node);

            $this->addReference('node-intervals-' . $nodeExample[0], $node);
        }

        $exampleNodesChords = [
            ['Pierwsze kroki', 'Zaczynamy od podstaw. Poznaj akordy!', 'bi bi-stars'],
            ['Akordy durowe', 'Akordy durowe to akordy, które brzmią radośnie.', 'bi bi-emoji-laughing-fill'],
            ['Akordy molowe', 'Akordy molowe to akordy, które brzmią smutno.', 'bi bi-emoji-frown-fill'],
            ['Akordy trójdźwiękowe', 'Akordy trójdźwiękowe składają się z trzech dźwięków.', 'bi bi-music-note-list'],
            ['Akordy czterodźwiękowe', 'Akordy czterodźwiękowe składają się z czterech dźwięków.', 'bi bi-music-note-beamed'],
        ];

        foreach ($exampleNodesChords as $index => $nodeExample) {
            $node = new Node();
            $node
                ->setName($nodeExample[0])
                ->setDescription($nodeExample[1])
                ->setIcon($nodeExample[2])
            ;

            if ($index > 0) {
                $node->setPreviousNode($this->getReference('node-chords-' . $exampleNodesChords[$index - 1][0]));
            }

            $node->setCourse($this->getReference('course-chords'));

            $manager->persist($node);

            $this->addReference('node-chords-' . $nodeExample[0], $node);
        }

        $exampleNodesScales = [
            ['Poznaj skale', 'Zaczynamy od podstaw. Poznaj skale!', 'bi bi-stars'],
            ['Skale dur i moll', 'Skale dur i moll to podstawa w muzyce.', 'bi bi-music-note'],
        ];

        foreach ($exampleNodesScales as $index => $nodeExample) {
            $node = new Node();
            $node
                ->setName($nodeExample[0])
                ->setDescription($nodeExample[1])
                ->setIcon($nodeExample[2])
            ;

            if ($index > 0) {
                $node->setPreviousNode($this->getReference('node-scales-' . $exampleNodesScales[$index - 1][0]));
            }

            $node->setCourse($this->getReference('course-scales'));

            $manager->persist($node);

            $this->addReference('node-scales-' . $nodeExample[0], $node);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CourseFixtures::class,
        ];
    }
}
