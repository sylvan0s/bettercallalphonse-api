<?php
namespace App\EventListener;
/**
 * Created by PhpStorm.
 * User: Zakariae
 * Date: 21/06/2018
 * Time: 07:00
 */
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class PasswordResettingListener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface {
    private $router;

    public function __construct(UrlGeneratorInterface $router) {
        $this->router = $router;
    }

    public static function getSubscribedEvents() {
        return [
            \FOS\UserBundle\FOSUserEvents::RESETTING_RESET_SUCCESS => 'onPasswordResettingSuccess',
        ];
    }

    public function onPasswordResettingSuccess(FormEvent $event) {
        $event->setResponse(new RedirectResponse($_SERVER['URL_APP']));
    }
}