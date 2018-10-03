<?php

namespace App\Repository;

use App\Entity\Propertydate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Propertydate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Propertydate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Propertydate[]    findAll()
 * @method Propertydate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertydateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Propertydate::class);
    }

//    /**
//     * @return Propertydate[] Returns an array of Propertydate objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Propertydate
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
