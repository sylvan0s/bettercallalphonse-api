<?php
namespace App\Controller;


use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
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
    private $tokenGenerator;

    public function __construct(EventDispatcherInterface $eventDispatcher, UserManagerInterface $userManager,
                                ContainerInterface $container, TokenGeneratorInterface $tokenGenerator)
    {
        /** @var eventDispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $this->eventDispatcher = $eventDispatcher;
        /** @var userManager \FOS\UserBundle\Model\UserManagerInterface */
        $this->userManager = $userManager;
        /** @var container \Symfony\Component\DependencyInjection\ContainerInterface */
        $this->container = $container;
        $this->tokenGenerator = $tokenGenerator;
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
    public function restPasswordAction(Request $request, $token)
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
        ]);

        $form->setData($user);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            foreach ($form->getErrors(true, true) as $key => $error)
            {
                $error = $error->getMessage() . "\n";
            }
            return new JsonResponse(
                // no translation provided for this in \FOS\UserBundle\Controller\ResettingController
                sprintf('"%s"', $error),
                JsonResponse::HTTP_BAD_REQUEST
            );
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

    /**
     * Custom route to do Get operation over User entity with all nested relations
     * It uses ParamConverter usage to reduce the responsability of the controller
     *
     * @Configuration\Route(
     *     name="user_reset_request",
     *     path="/api/user/resetting/request",
     *     methods={"POST"}
     * )
     */
    public function restRequestAction(Request $request)
    {
        $username = $request->request->get('username');

        /** @var $user UserInterface */
        $user = $this->container->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        /* Dispatch init event */
        $event = new GetResponseNullableUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        if (null === $user) {
            return new JsonResponse(
                'User not recognised',
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_REQUEST, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            return new JsonResponse(
                $this->container->get('translator')->trans('password_already_requested', [], 'FOSUserBundle'),
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }

        /* Dispatch confirm event */
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_CONFIRM, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $this->container->get('user.mailer.rest')->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->container->get('fos_user.user_manager')->updateUser($user);

        /* Dispatch completed event */
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_COMPLETED, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        return new JsonResponse(
            $this->container->get('translator')->trans(
                'resetting.check_email',
                [ '%tokenLifetime%' => floor($this->container->getParameter('fos_user.resetting.token_ttl') / 3600) ],
                'FOSUserBundle'
            ),
            JsonResponse::HTTP_OK
        );
    }



}