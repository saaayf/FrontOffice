<?php

namespace App\Repository;

use App\Entity\Motive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Motive>
 *
 * @method Motive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Motive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Motive[]    findAll()
 * @method Motive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Motive::class);
    }

//    /**
//     * @return Motive[] Returns an array of Motive objects
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

//    public function findOneBySomeField($value): ?Motive
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
