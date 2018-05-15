<?php

namespace App\Repository;

use App\Entity\UserPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserPhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPhoto[]    findAll()
 * @method UserPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPhotoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserPhoto::class);
    }

//    /**
//     * @return UserPhoto[] Returns an array of UserPhoto objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserPhoto
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
