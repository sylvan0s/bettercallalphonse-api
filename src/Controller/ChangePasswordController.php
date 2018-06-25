<?php
namespace App\Controller;


use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Configuration;

class ChangePasswordController
{
    private $eventDispatcher;
    private $userManager;
    private $stokenStorage;

    public function __construct(EventDispatcherInterface $eventDispatcher, UserManagerInterface $userManager,
                                TokenStorageInterface $stokenStorage, ContainerInterface $container)
    {
        /** @var eventDispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $this->eventDispatcher = $eventDispatcher;
        /** @var userManager \FOS\UserBundle\Model\UserManagerInterface */
        $this->userManager = $userManager;
        /** @var stokenStorage \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage */
        $this->stokenStorage = $stokenStorage;
        /** @var container \Symfony\Component\DependencyInjection\ContainerInterface */
        $this->container = $container;
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
    public function getUser()
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

    /**
     * Custom route to do Get operation over User entity with all nested relations
     * It uses ParamConverter usage to reduce the responsability of the controller
     *
     * @Configuration\Route(
     *     name="user_change_password",
     *     path="/api/user/changepassword",
     *     methods={"POST"}
     * )
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('change_password_service');
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
        $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

        $this->userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            return new JsonResponse(
                $this->container->get('translator')->trans('change_password.flash.success', [], 'FOSUserBundle'),
                JsonResponse::HTTP_OK
            );
        }

        // unsure if this is now needed / will work the same
        $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user,
            $request,
            $response));

        return new JsonResponse(
            $this->container->get('translator')->trans('change_password.flash.success', [], 'FOSUserBundle'),
            JsonResponse::HTTP_OK
        );
    }
}