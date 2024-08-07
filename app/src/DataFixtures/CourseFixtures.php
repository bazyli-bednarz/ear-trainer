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
            'Interwały',
            'Akordy',
            'Skale',
        ];

        foreach ($exampleCourses as $exampleCourse) {
            $course = new Course();
            $course->setName($exampleCourse);
            $manager->persist($course);
        }

        $manager->flush();
    }
}
