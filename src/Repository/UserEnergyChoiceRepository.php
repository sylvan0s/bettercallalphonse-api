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

    public function GetEnergyAvgGroupedDay($criteria)
    {

        $uQuery = $this->createQueryBuilder('ue');
        return $uQuery
                    ->select('DATE_FORMAT(ue.creationDate, \'%Y-%m-%d\') creationDate, '.
                                $uQuery->expr()->avg('ue.note') . ' AS weightedScore')
                    ->andWhere('DATE_FORMAT(ue.creationDate, \'%Y-%m-%d\') >= DATE_FORMAT(:since, \'%Y-%m-%d\')')
                    ->setParameter('since', $criteria['since'])
                    ->groupBy('creationDate')
                    ->orderBy('creationDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    public function getUserHasVotedToday($criteria)
    {
        return $this->createQueryBuilder('ue')
		    ->select('ue.id, ue.note')
		   ->andWhere('ue.user = :user')
                    ->andWhere('DATE_FORMAT(ue.creationDate, \'%Y-%m-%d\') >= DATE_FORMAT(:since, \'%Y-%m-%d\')')
                    ->setParameter('since', $criteria['since'])
		   ->setParameter('user', $criteria['user'])
                    ->getQuery()
                    ->getResult();
    }



    public function getUserEnergy($criteria)
    {

	return $this->createQueryBuilder('ue')
                    ->select('ue.note')
                    ->andWhere('ue.user = :user')
		    ->setParameter('user', $criteria['user'])
                    ->getQuery()
                    ->getResult();

    }
}
