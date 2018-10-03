<?php

namespace App\Repository;

use App\Entity\Tasklist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tasklist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tasklist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tasklist[]    findAll()
 * @method Tasklist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TasklistRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tasklist::class);
    }


    public function getLists()
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.users', 'u')
            ->addSelect('u')
            ->orderBy('t.name')
            ->getQuery()
            ->getResult()
        ;
    }




    public function getDefaultTasks(){
        return $this->createQueryBuilder('t')
            ->leftJoin('t.users', 'u')
            ->addSelect('u')
            ->where('t.is_default = 1')
            ->orderBy('t.name')
            ->getQuery()
            ->getResult()
            ;
    }

}
