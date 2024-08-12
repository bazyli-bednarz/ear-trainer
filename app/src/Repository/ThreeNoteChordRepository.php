<?php

namespace App\Repository;

use App\Entity\Task\ThreeNoteChord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ThreeNoteChord>
 */
class ThreeNoteChordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThreeNoteChord::class);
    }
}
