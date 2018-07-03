<?php
namespace App\EventListener;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\UserSuggestionLike;
use App\Entity\UserSuggestionMegaLike;
use App\Repository\UserSuggestionLikeRepository;
use App\Repository\UserSuggestionMegaLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LikeSubscriber implements EventSubscriberInterface
{
    private $tokenStorage;
    private $entityManager;
    private $userSuggestionLike;
    private $userSuggestionMegaLike;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager,
                                UserSuggestionLikeRepository $userSuggestionLike, UserSuggestionMegaLikeRepository
                                $userSuggestionMegaLike)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
        /** @var \App\Repository\UserSuggestionLikeRepository userSuggestionLike */
        $this->userSuggestionLike = $userSuggestionLike;
        $this->userSuggestionMegaLike = $userSuggestionMegaLike;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                ['onPreValidate', EventPriorities::PRE_VALIDATE],
                ['onPostValidate', EventPriorities::POST_VALIDATE]
            ]
        ];
    }

    public function onPreValidate(GetResponseForControllerResultEvent $event)
    {
        // Initialisation
        $controller = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$controller instanceof UserSuggestionMegaLike && !$controller instanceof UserSuggestionLike ||
            Request::METHOD_POST !== $method) {
            return;
        }

        if($controller instanceof UserSuggestionMegaLike) {
            $element = $this->userSuggestionMegaLike->findOneBy(['user' => $controller->getUser(), 'suggestion'
            => $controller->getSuggestion()]);
        } else {
            $element = $this->userSuggestionLike->findOneBy(['user' => $controller->getUser(), 'suggestion'
            => $controller->getSuggestion()]);
        }

        if($element !== null) {
            $event->setResponse( new JsonResponse(
                "This operation is not authorized",
                JsonResponse::HTTP_CONFLICT
            ));
            $event->stopPropagation();

        }
    }
    public function onPostValidate(GetResponseForControllerResultEvent $event)
    {
        // Initialisation
        $controller = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$controller instanceof UserSuggestionMegaLike && !$controller instanceof UserSuggestionLike ||
            Request::METHOD_POST !== $method) {
            return;
        }

        if($controller instanceof UserSuggestionMegaLike) {
            $element = $this->userSuggestionLike->findOneBy(['user' => $controller->getUser(), 'suggestion'
            => $controller->getSuggestion()]);
        } else {
            $element = $this->userSuggestionMegaLike->findOneBy(['user' => $controller->getUser(), 'suggestion'
            => $controller->getSuggestion()]);
        }

        if($element !== null) {
            $this->entityManager->remove($element);
            $this->entityManager->flush();
        }

    }
}