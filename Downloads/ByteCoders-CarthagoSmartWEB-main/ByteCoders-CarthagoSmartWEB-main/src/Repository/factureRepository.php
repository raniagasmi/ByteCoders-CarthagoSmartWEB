<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Facture>
 *
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class factureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    /**
     * @return Facture[] Returns an array of Facture objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBySearchQuery(string $searchQuery): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.libelle LIKE :searchQuery OR f.montant LIKE :searchQuery')
            ->setParameter('searchQuery', '%'.$searchQuery.'%')
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }


    public function findOneBySomeField($value): ?Facture
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findByMultipleCriteria($searchQuery)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.idFacture LIKE :searchQuery')
            ->orWhere('f.libelle LIKE :searchQuery')
            //->orWhere('f.estPayee LIKE :searchQuery')
            ->orWhere('f.type LIKE :searchQuery')
            ->setParameter('searchQuery', '%' . $searchQuery . '%')
            ->getQuery()
            ->getResult();
    }
}
