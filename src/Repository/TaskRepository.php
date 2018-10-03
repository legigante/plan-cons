<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Task::class);
    }


    public function getFrise($filters = [], $sorts = [])
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.project', 'p')
            ->addSelect('p')
            ->innerJoin('t.tasklist', 'tl')
            ->addSelect('tl')
            ->innerJoin('t.users', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getMinMax($filters = [], $sorts = [])
    {

        $em = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('max1', 'max');
        $rsm->addScalarResult('min1', 'min');

        $query = $em->createNativeQuery('SELECT MAX(max1) AS max1, MIN(min1) AS min1 FROM (SELECT MAX(t.date_end) AS max1, MIN(t.date_rla) AS min1 FROM task t UNION SELECT MAX(t.date_expected_end) AS max1, MIN(t.date_strat) AS min1 FROM task t UNION SELECT MAX(t.date_recallage) AS max1, MIN(t.date_start) AS min1 FROM task t) AS t', $rsm);
        $r = $query->getResult();

        return ['max'=>$r[0]['max'], 'min'=>$r[0]['min']];

    }

}
