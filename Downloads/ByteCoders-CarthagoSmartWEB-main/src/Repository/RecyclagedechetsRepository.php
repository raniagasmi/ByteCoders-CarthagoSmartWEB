<?php

namespace App\Repository;

use App\Entity\Recyclagedechets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recyclagedechets>
 *
 * @method Recyclagedechets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recyclagedechets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recyclagedechets[]    findAll()
 * @method Recyclagedechets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecyclagedechetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recyclagedechets::class);
    }

//    /**
//     * @return Recyclagedechets[] Returns an array of Recyclagedechets objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Recyclagedechets
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findByMultipleCriteria($searchQuery)
{
    return $this->createQueryBuilder('r')
        ->andWhere('r.idRecyc LIKE :searchQuery')
        ->orWhere('r.pointrecyclage LIKE :searchQuery')
        ->setParameter('searchQuery', '%' . $searchQuery . '%')
        ->getQuery()
        ->getResult();
}
}
