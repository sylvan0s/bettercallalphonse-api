<?php

namespace App\Repository;

use App\Entity\UserSuggestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserSuggestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSuggestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSuggestion[]    findAll()
 * @method UserSuggestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSuggestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserSuggestion::class);
    }

//    /**
//     * @return UserSuggestion[] Returns an array of UserSuggestion objects
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
    public function findOneBySomeField($value): ?UserSuggestion
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
