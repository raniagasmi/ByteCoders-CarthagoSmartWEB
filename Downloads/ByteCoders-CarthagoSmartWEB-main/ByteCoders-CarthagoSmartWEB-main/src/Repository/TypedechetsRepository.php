<?php

// TypedechetsRepository.php

namespace App\Repository;

use App\Entity\Typedechets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Typedechets>
 *
 * @method Typedechets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typedechets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typedechets[]    findAll()
 * @method Typedechets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypedechetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typedechets::class);
    }

    //  /**
//  * @return Typedechets[] Returns an array of Typedechets objects
//    */
//  public function findByExampleField($value): array
//  {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//           ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Typedechets
//    {
//       return $this->createQueryBuilder('t')
//         ->andWhere('t.exampleField = :val')
//           ->setParameter('val', $value)
//         ->getQuery()
//        ->getOneOrNullResult()
//      ;
//}

    public function findByMultipleCriteria($searchQuery)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id LIKE :searchQuery')
            ->orWhere('t.name LIKE :searchQuery')
            ->orWhere('t.categorie LIKE :searchQuery')
            ->setParameter('searchQuery', '%' . $searchQuery . '%')
            ->getQuery()
            ->getResult();
    }
}
