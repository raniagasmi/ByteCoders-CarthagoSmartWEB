<?php

namespace App\Repository;

use App\Entity\Collectdechets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Collectdechets>
 *
 * @method Collectdechets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collectdechets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collectdechets[]    findAll()
 * @method Collectdechets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectdechetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collectdechets::class);
    }

//    /**
//     * @return Collectdechets[] Returns an array of Collectdechets objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Collectdechets
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
