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

    /**
     * @return Trick[] Returns an array of Trick objects
     */

    public function findAPage($offset = 1, $tricksPerPage)
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'ASC')
            ->setMaxResults($tricksPerPage)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return int Returns hte number of tricks in database
     */

    public function fingNbPages($tricksPerPage)
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
