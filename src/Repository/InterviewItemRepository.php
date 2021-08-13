<?php

namespace App\Repository;

use App\Entity\InterviewItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InterviewItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterviewItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterviewItem[]    findAll()
 * @method InterviewItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterviewItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterviewItem::class);
    }

    // /**
    //  * @return InterviewItem[] Returns an array of InterviewItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InterviewItem
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
