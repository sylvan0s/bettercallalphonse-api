<?php

namespace App\Repository;

use App\Entity\UserSuggestionLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserSuggestionLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSuggestionLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSuggestionLike[]    findAll()
 * @method UserSuggestionLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSuggestionLikeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserSuggestionLike::class);
    }

//    /**
//     * @return UserSuggestionLike[] Returns an array of UserSuggestionLike objects
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
    public function findOneBySomeField($value): ?UserSuggestionLike
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
