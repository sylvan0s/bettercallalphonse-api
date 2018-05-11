<?php

namespace App\Repository;

use App\Entity\UserEnergyChoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserEnergyChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEnergyChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEnergyChoice[]    findAll()
 * @method UserEnergyChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEnergyChoiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserEnergyChoice::class);
    }

//    /**
//     * @return UserEnergyChoice[] Returns an array of UserEnergyChoice objects
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
    public function findOneBySomeField($value): ?UserEnergyChoice
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
