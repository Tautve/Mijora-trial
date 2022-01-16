<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class GeneralFunctionsService
{

    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function persistAndFlush(object $object): void
    {
        $this->em->persist($object);

        $this->em->flush();
    }
}
