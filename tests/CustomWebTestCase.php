<?php

namespace App\Tests;

use App\Repository\OmnivaRepository;
use App\Service\OmnivaService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomWebTestCase extends WebTestCase
{
    public function getEntityManager(): EntityManager
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function truncateEntities(): void
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    protected function getMockOmnivaService(): OmnivaService
    {
        $omnivaRepository = $this->createMock(OmnivaRepository::class);

        return new OmnivaService($omnivaRepository);
    }
}
