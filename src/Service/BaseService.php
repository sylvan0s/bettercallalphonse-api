<?php

namespace App\Service;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class BaseService
{
    protected $userManager;
    protected $stokenStorage;
    protected $authorizationChecker;

    public function __construct(UserManagerInterface $userManager, TokenStorageInterface $stokenStorage,
                                AuthorizationCheckerInterface $authorizationChecker)
    {
        /** @var userManager \FOS\UserBundle\Model\UserManagerInterface */
        $this->userManager = $userManager;
        /** @var stokenStorage \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage */
        $this->stokenStorage = $stokenStorage;
        /** @var \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface authorizationChecker */
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    protected function getUser()
    {
        if (!$this->stokenStorage) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->stokenStorage->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }

    protected function getStart($month, $interval)
    {
        // Initialisation
        $plage = new \DateInterval($interval);
        $plage->invert = 1; //Make it negative.
        return  $month->add($plage);
    }

    protected function getStartOfMonth($month, $interval)
    {
        $since = $this->getStart($month, $interval);

        return $since->modify('first day of this month');
    }
}