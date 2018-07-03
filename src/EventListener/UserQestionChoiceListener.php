<?php

namespace App\EventListener;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\UserQuestionChoice;
use App\Repository\UserQuestionChoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserQestionChoiceListener implements EventSubscriberInterface
{

    private $userQestionChoiceRepository;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserQuestionChoiceRepository
    $userQuestionChoiceRepository)
    {
        $this->entityManager = $entityManager;
        /** @var \App\Repository\UserQuestionChoiceRepository userQestionChoiceRepository */
        $this->userQestionChoiceRepository = $userQuestionChoiceRepository;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                ['onPreWrite', EventPriorities::PRE_WRITE]
            ]
        ];
    }

    public function onPreWrite(GetResponseForControllerResultEvent $event)
    {
        // Initialisation
        $controller = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $questionChoices = [];

        if (!$controller instanceof UserQuestionChoice || (Request::METHOD_POST !== $method && Request::METHOD_PUT
                !== $method)) {
            return;
        }
        $isContaine = $controller->getQuestion()->getQuestionChoices()->contains($controller->getQuestionChoice());

        if(Request::METHOD_POST === $method) {
            $creationDate = (new \DateTime('now'));
            $criteria = [
                'user' => $controller->getUser(),
                'question' => $controller->getQuestion(),
                'questionChoice' => $controller->getQuestionChoice(),
                'creationDate' => $creationDate
            ];

            $questionChoices = $this->userQestionChoiceRepository->findElement($criteria);
        }

        if (count($questionChoices) > 0 || !$isContaine) {
            $event->setResponse(new JsonResponse(
                "This operation is not authorized",
                JsonResponse::HTTP_METHOD_NOT_ALLOWED
            ));
            $event->stopPropagation();
        }
    }
}
