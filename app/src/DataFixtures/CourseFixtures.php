<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $exampleCourses = [
            ['Interwały', 'Interwały to odstępy czasowe pomiędzy dźwiękami. Naucz się je rozpoznawać!', 'course-intervals'],
            ['Akordy', 'Akordy to dźwięki, które brzmią jednocześnie. Poznaj ich tajniki!', 'course-chords'],
            ['Skale', 'Skale to sekwencje dźwięków ułożonych według pewnego schematu. Poznaj je!', 'course-scales'],
        ];

        foreach ($exampleCourses as $exampleCourse) {
            $course = new Course();
            $course->setName($exampleCourse[0]);
            $course->setDescription($exampleCourse[1]);
            $manager->persist($course);

            $this->addReference($exampleCourse[2], $course);
        }

        $manager->flush();
    }
}
