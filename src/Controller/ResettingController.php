<?php
namespace App\Controller;


use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Configuration;

class ResettingController
{
    private $eventDispatcher;
    private $userManager;
    private $container;

    public function __construct(EventDispatcherInterface $eventDispatcher, UserManagerInterface $userManager,
                                ContainerInterface $container)
    {
        /** @var eventDispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $this->eventDispatcher = $eventDispatcher;
        /** @var userManager \FOS\UserBundle\Model\UserManagerInterface */
        $this->userManager = $userManager;
        /** @var container \Symfony\Component\DependencyInjection\ContainerInterface */
        $this->container = $container;
    }

    /**
     * Custom route to do Get operation over User entity with all nested relations
     * It uses ParamConverter usage to reduce the responsability of the controller
     *
     * @Configuration\Route(
     *     name="user_reset_password",
     *     path="/api/user/resetting/reset/{token}",
     *     methods={"POST"}
     * )
     */
    public function restPassword(Request $request, $token)
    {
        if (null === $token) {
            return new JsonResponse('You must submit a token.', JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $this->userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            return new JsonResponse(
                // no translation provided for this in \FOS\UserBundle\Controller\ResettingController
                sprintf('The user with "confirmation token" does not exist for value "%s"', $token),
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('reset_password_service');
        $form = $formFactory->createForm([
            'csrf_protection'    => false,
            'allow_extra_fields' => true,
        ]);

        $form->setData($user);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }

        $event = new FormEvent($form, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);

        $this->userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            return new JsonResponse(
                $this->container->get('translator')->trans('resetting.flash.success', [], 'FOSUserBundle'),
                JsonResponse::HTTP_OK
            );
        }

        // unsure if this is now needed / will work the same
        $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_COMPLETED, new FilterUserResponseEvent($user,
            $request,
            $response));

        return new JsonResponse(
            $this->container->get('translator')->trans('resetting.flash.success', [], 'FOSUserBundle'),
            JsonResponse::HTTP_OK
        );
    }

}