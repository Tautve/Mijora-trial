<?php

namespace App\Repository;

use App\Entity\DatabaseSynchronisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DatabaseSynchronisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatabaseSynchronisation::class);
    }
}
