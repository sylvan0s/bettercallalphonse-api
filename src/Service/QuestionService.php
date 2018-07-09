<?php

namespace App\Service;

use App\Repository\QuestionRepository;
use App\Repository\UserQuestionChoiceRepository;
use Faker\Provider\DateTime;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class QuestionService extends ServiceBase
{
    CONST COLORSARR = ['#1', '#2', '#3', '#4'];
    private $userQuestionChoiceRepository;
    private $questionRepository;

    public function __construct(UserManagerInterface $userManager, TokenStorageInterface $stokenStorage,
                                AuthorizationCheckerInterface $authorizationChecker, UserQuestionChoiceRepository
                                $userQuestionChoiceRepository, QuestionRepository $questionRepository)
    {
        parent::__construct($userManager, $stokenStorage, $authorizationChecker);
        /** @var \App\Repository\UserQuestionChoiceRepository userQuestionChoiceRepository */
        $this->userQuestionChoiceRepository= $userQuestionChoiceRepository;
        /** @var \App\Repository\QuestionRepository userQuestionChoiceRepository */
        $this->questionRepository = $questionRepository;
    }

    public function GetChoicesGroupedByIdQuestion($idQuestion)
    {
        if(!$this->authorizationChecker->isGranted("ROLE_ADMIN")) {
            throw new \LogicException('Only admins can see this.');
        }

        // Initialisation
        $since = $this->getStartOfMonth(new \DateTime(), 'P6M');
        $criteria = [
            'idQuestion' => $idQuestion,
            'since' => $since
        ];

        $elements = $this->userQuestionChoiceRepository->GetChoicesGroupedByIdQuestion($criteria);

        return $elements;
    }

    private function getStartOfMonth($month, $interval)
    {
        // Initialisation
        $plage = new \DateInterval($interval);
        $plage->invert = 1; //Make it negative.
        $since = $month->add($plage);

        return $since->modify('first day of this month');
    }

}