<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\MeasurementEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MeasurementEntry>
 */
class MeasurementEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeasurementEntry::class);
    }

    public function findByLocation(Location $location) 
    {
        $gb = $this->createQueryBuilder('m');
        $gb->where('m.location = :location')
            ->setParameter('location', $location)
            ->andWhere('m.dateTime > :now')
            ->setParameter('now', new \DateTime('now'));

            $query = $gb->getQuery();
            $result = $query->getResult();

            return $result;
    }

    //    /**
    //     * @return MeasurementEntry[] Returns an array of MeasurementEntry objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MeasurementEntry
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
