<?php

namespace App\Repository;

use App\Entity\Omniva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class OmnivaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Omniva::class);
    }

    public function selectSpecifiedDataOfPostMachines(array $criteria)
    {
        $query = $this->createQueryBuilder('pm')
            ->select('pm.id', 'pm.zipCode', 'pm.name', 'pm.a0Name', 'pm.a1Name',
                'pm.a2Name', 'pm.a3Name', 'pm.a4Name', 'pm.a5Name', 'pm.a6Name',
                'pm.a7Name', 'pm.a8Name')
            ->andWhere('pm.zipCode LIKE :zipCodeCriteria')
            ->setParameter('zipCodeCriteria',
                '%' . ($criteria['zipCode'] ?? null) . '%')
            ->andWhere('pm.name LIKE :nameCriteria')
            ->setParameter('nameCriteria',
                '%' . ($criteria['name'] ?? null) . '%');

        if (!empty($criteria['address'])) {
            $this->applyAddressFilter($query, $criteria);
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    public function deleteOldPostMachinesData()
    {
        return $this->createQueryBuilder('od')
            ->delete()
            ->getQuery()
            ->execute();
    }

    private function applyAddressFilter(
        QueryBuilder $query,
        array $criteria
    ): void {
        $partAddresses = array_filter(explode(' ', $criteria['address']));

        foreach ($partAddresses as $key => $partAddress) {

            $query->andWhere(
                    'pm.a0Name LIKE :address0Criteria' . $key
                    . ' or pm.a1Name LIKE :address1Criteria' . $key
                    . ' or pm.a2Name LIKE :address2Criteria' . $key
                    . ' or pm.a3Name LIKE :address3Criteria' . $key
                    . ' or pm.a4Name LIKE :address4Criteria' . $key
                    . ' or pm.a5Name LIKE :address5Criteria' . $key
                    . ' or pm.a6Name LIKE :address6Criteria' . $key
                    . ' or pm.a7Name LIKE :address7Criteria' . $key
                    . ' or pm.a8Name LIKE :address8Criteria' . $key
                );

            for ($i = 0; $i <= 8; $i++) {
                $query->setParameter('address' . $i . 'Criteria' . $key,
                    '%' . $partAddress . '%');
            }
        }
    }
}
