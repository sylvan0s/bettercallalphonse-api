<?php

// api/src/Doctrine/CurrentUserExtension.php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\User;
use App\Entity\UserQuestionChoice;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    const MY_QUESTION_CHOICES_GET_COLLECTION = "api_user_question_choices_my_collection";
    const COLLABS_QUESTION_CHOICES_GET_COLLECTION = "api_user_question_choices_collabs_collection";

    private $tokenStorage;
    private $authorizationChecker;
    private $router;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $checker,
                                RouterInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $checker;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * {@inheritdoc}
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     *
     * @param QueryBuilder $queryBuilder
     * @param string       $resourceClass
     */
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass)
    {
        // Initialisation
        $context = $this->router->getContext();
        $matcher = $this->router->getMatcher();
        $parameters = $matcher->match($context->getPathInfo());
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof User
            && (User::class === $resourceClass)
            && !$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(sprintf('%s.id = :current_user', $rootAlias));
            $queryBuilder->setParameter('current_user', $user->getId());
        }

        if ($user instanceof User
            && UserQuestionChoice::class === $resourceClass
            && in_array($parameters['_route'], [self::MY_QUESTION_CHOICES_GET_COLLECTION,
                self::COLLABS_QUESTION_CHOICES_GET_COLLECTION]) ) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            if($parameters['_route'] === self::MY_QUESTION_CHOICES_GET_COLLECTION) {
                $queryBuilder->andWhere(sprintf('%s.user = :current_user', $rootAlias));
            } else {
                $queryBuilder->andWhere(sprintf('%s.user != :current_user', $rootAlias));
            }
            $queryBuilder->setParameter('current_user', $user->getId());
        }
    }
}
