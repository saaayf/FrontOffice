<?php

namespace App\Repository;

use App\Entity\Entretient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entretient>
 *
 * @method Entretient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entretient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entretient[]    findAll()
 * @method Entretient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntretientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entretient::class);
    }

//    /**
//     * @return Entretient[] Returns an array of Entretient objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Entretient
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
