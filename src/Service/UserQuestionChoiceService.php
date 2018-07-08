<?php

namespace App\Service;

use App\Entity\EntityBase;
use App\Entity\User;
use App\Repository\UserQuestionChoiceRepository;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserQuestionChoiceService extends BaseService
{
    private $userQuestionChoiceRepository;

    public function __construct(UserManagerInterface $userManager, TokenStorageInterface $stokenStorage,
                                AuthorizationCheckerInterface $authorizationChecker, UserQuestionChoiceRepository
                                $userQuestionChoiceRepository)
    {
        parent::__construct($userManager, $stokenStorage, $authorizationChecker);
        /** @var \App\Repository\UserQuestionChoiceRepository userQuestionChoiceRepository */
        $this->userQuestionChoiceRepository= $userQuestionChoiceRepository;
    }

    public function GetChoicesGroupedByIdQuestion($idQuestion)
    {
        if(!$this->authorizationChecker->isGranted(User::ROLE_ADMIN)) {
            throw new \LogicException('Only admins can see this.');
        }

        // Initialisation
        $since = $this->getStartOfMonth(new \DateTime(), EntityBase::PERIODICITY_6_MONTH);
        $criteria = [
            'idQuestion' => $idQuestion,
            'since' => $since
        ];

        $elements = $this->userQuestionChoiceRepository->GetChoicesGroupedByIdQuestion($criteria);

        return $elements;
    }

}