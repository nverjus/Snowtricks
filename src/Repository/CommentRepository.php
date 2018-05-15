<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findAPage($trickId, $offset = 1, $commentsPerPage)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.trick', 't')
            ->where('t.id = :trickId')
            ->setParameter('trickId', $trickId)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults($commentsPerPage)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return int Returns hte number of comments for a trick in database
     */

    public function findNbPages($trickId, $commentsPerPage)
    {
        $nbComments = $this->createQueryBuilder('c')
                        ->select('COUNT(t)')
                        ->leftJoin('c.trick', 't')
                        ->where('t.id = :trick_id')
                        ->setParameter('trick_id', $trickId)
                        ->getQuery()
                        ->getSingleScalarResult();

        $nbPages = (int) $nbComments/$commentsPerPage;
        $nbPages = (int) $nbPages;
        if ($nbComments%$commentsPerPage != 0) {
            $nbPages++;
        }

        return $nbPages;
    }
}
