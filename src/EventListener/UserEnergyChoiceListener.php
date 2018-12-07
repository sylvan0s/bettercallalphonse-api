<?php

namespace App\EventListener;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\UserEnergyChoice;
use App\Entity\UserQuestionChoice;
use App\Repository\UserEnergyChoiceRepository;
use App\Repository\UserQuestionChoiceRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserEnergyChoiceListener implements EventSubscriberInterface
{

    private $userEnergyChoiceRepository;

    public function __construct(UserEnergyChoiceRepository $userEnergyChoiceRepository)
    {
        /** @var \App\Repository\UserEnergyChoiceRepository userEnergyChoiceRepository */
        $this->userEnergyChoiceRepository = $userEnergyChoiceRepository;
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
                ['onPostValidate', EventPriorities::POST_WRITE]
            ]
        ];
    }

    public function onPostValidate(GetResponseForControllerResultEvent $event)
    {
        // Initialisation
        $controller = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $questionChoices = [];

        if (!$controller instanceof UserEnergyChoice || (Request::METHOD_GET !== $method)) {
            return;
        }


    }
}
