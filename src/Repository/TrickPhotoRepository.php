<?php

namespace App\Repository;

use App\Entity\TrickPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrickPhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickPhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickPhoto[]    findAll()
 * @method TrickPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickPhotoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrickPhoto::class);
    }

//    /**
//     * @return TrickPhoto[] Returns an array of TrickPhoto objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrickPhoto
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
