<?php
/**
 * Created by PhpStorm.
 * User: Zakariae
 * Date: 08/07/2018
 * Time: 17:34
 */

namespace App\Service;

use App\Entity\EntityBase;
use App\Entity\User;
use App\Repository\UserEnergyChoiceRepository;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserEnergyChoiceService extends BaseService
{
    private $userEnergyChoiceRepository;

    public function __construct(UserManagerInterface $userManager, TokenStorageInterface $stokenStorage,
                                AuthorizationCheckerInterface $authorizationChecker, UserEnergyChoiceRepository
                                $userEnergyChoiceRepository)
    {
        parent::__construct($userManager, $stokenStorage, $authorizationChecker);
        /** @var \App\Repository\UserEnergyChoiceRepository userEnergyChoiceRepository */
        $this->userEnergyChoiceRepository = $userEnergyChoiceRepository;
    }

    public function GetEnergyAvgGroupedDayForAdmin()
    {
        if(!$this->authorizationChecker->isGranted(User::ROLE_ADMIN))
        {
            throw new \LogicException('Only admins can see this.');
        }

        $criteria['since'] = $this->getStart(new \DateTime(), EntityBase::PERIODICITY_7_DAY);

        return $this->userEnergyChoiceRepository->GetEnergyAvgGroupedDay($criteria);
    }

    public function GetEnergyAvgGroupedDay()
    {
        $criteria['since'] = $this->getStart(new \DateTime(), EntityBase::PERIODICITY_0_DAY);

        return $this->userEnergyChoiceRepository->GetEnergyAvgGroupedDay($criteria);
    }

    public function getUserHasVotedToday()
    {
        $criteria = [
            'since' => $this->getStart(new \DateTime(), EntityBase::PERIODICITY_0_DAY),
	    'user' => $this->getUser()
        ];

        return $this->userEnergyChoiceRepository->getUserHasVotedToday($criteria);
    }

    public function getUserEnergy()
    {
       $criteria = [
            'user' => $this->getUser()
        ];
        return $this->userEnergyChoiceRepository->getUserEnergy($criteria);
    }
}
