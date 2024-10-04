<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function findOneByCityAndCountry(string $city, string $country): ?Location
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.city = :city')
            ->andWhere('l.country = :country')
            ->setParameter('city', $city)
            ->setParameter('country', $country)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByCity(string $city): ?Location
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.city = :city')
            ->setParameter('city', $city)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
