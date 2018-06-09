<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function findAPage($offset = 1, $tricksPerPage)
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults($tricksPerPage)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult()
        ;
    }


    public function findNbPages($tricksPerPage)
    {
        $nbTricks = $this->createQueryBuilder('t')
                        ->select('COUNT(t)')
                        ->getQuery()
                        ->getSingleScalarResult();

        $nbPages = (int) $nbTricks/$tricksPerPage;
        $nbPages = (int) $nbPages;
        if ($nbTricks%$tricksPerPage != 0) {
            $nbPages++;
        }

        return $nbPages;
    }
}
