<?php

namespace App\Repository;

use App\Entity\Task\FourNoteChord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FourNoteChord>
 */
class FourNoteChordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FourNoteChord::class);
    }
}
