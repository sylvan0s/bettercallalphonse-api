<?php

namespace App\Repository;

use App\Entity\UserQuestionChoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserQuestionChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserQuestionChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserQuestionChoice[]    findAll()
 * @method UserQuestionChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserQuestionChoiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserQuestionChoice::class);
    }

    public function findElement($criteria)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.user = :user')
            ->andWhere('q.questionChoice = :questionChoice')
            ->andWhere('q.question = :question')
            ->andWhere('DATE_FORMAT(q.creationDate, \'%Y-%m\') = DATE_FORMAT(:dateCreation,  \'%Y-%m\')')
            ->setParameter('user', $criteria['user'])
            ->setParameter('question', $criteria['question'])
            ->setParameter('questionChoice', $criteria['questionChoice'])
            ->setParameter('dateCreation', $criteria['creationDate'])
            ->getQuery()
            ->getResult();
    }

    public function GetChoicesGroupedByIdQuestion($criteria)
    {
        return $this->createQueryBuilder('uqc')
                    ->select('qc.id, qc.libelle, DATE_FORMAT(uqc.creationDate, \'%Y-%m\') creationDate, COUNT(\'qc.id\') nbChoice')
                    ->join('uqc.questionChoice', 'qc')
                    ->join('uqc.question', 'q')
                    ->where('q.id = :id')
                    ->andWhere('uqc.creationDate >= :since')
                    ->setParameter('id', $criteria['idQuestion'])
                    ->setParameter('since', $criteria['since'])
                    ->groupBy('qc.id, qc.libelle, creationDate')
                    ->orderBy('creationDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }
}
