<?php
/**
 * Created by PhpStorm.
 * User: Zakariae
 * Date: 01/07/2018
 * Time: 02:07
 */

namespace App\Doctrine;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Question;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Routing\RouterInterface;

class EnabledQuestion implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    const ADMIN_QUESTION_ADMIN_GET_COLLECTION = "api_questions_admin_get_collection";

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

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
        $context = $this->router->getContext();
        $matcher = $this->router->getMatcher();
        $parameters = $matcher->match($context->getPathInfo());

        if(Question::class === $resourceClass && $parameters['_route'] != self::ADMIN_QUESTION_ADMIN_GET_COLLECTION) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(sprintf('%s.enabled = :enabled', $rootAlias));
            $queryBuilder->setParameter('enabled', true);
        }
    }
}