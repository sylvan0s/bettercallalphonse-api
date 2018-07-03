<?php
/**
 * Created by PhpStorm.
 * User: Zakariae
 * Date: 01/07/2018
 * Time: 15:12
 */

namespace App\EventListener;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class OrderedQuestionSubscriber implements EventSubscriberInterface
{
    private $questionRepository;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, QuestionRepository $questionRepository)
    {
        $this->entityManager = $entityManager;
        /** @var \App\Repository\QuestionRepository questionRepository */
        $this->questionRepository = $questionRepository;
    }

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
        if (!$controller instanceof Question || (Request::METHOD_POST !== $method && Request::METHOD_PUT
                !== $method && Request::METHOD_DELETE !== $method)) {
            return;
        }
        $questions = $this->questionRepository->findOtherElements(['enabled' => true, 'ordered' => $controller->getOrdered(),
            'id' => $controller->getId()]);

        $i = $controller->getOrdered();
        foreach ($questions as $question)
        {
            $i++;
            $question->setOrdered($i);
            $this->entityManager->persist($question);
        }
        $this->entityManager->flush();
    }
}