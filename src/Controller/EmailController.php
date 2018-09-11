<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmailController extends Controller
{
    /**
     * @Route("/send_register_email", name="send_register_email", methods={"POST"})
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
      $datas = json_decode($request->getContent());

      $register_email = (new \Swift_Message('Bienvenue sur Better Call Alphonse !'))
                        ->setFrom('noreply@alphonse.io')
                        ->setTo($datas->email)
                        ->setBody(
                          $this->renderView(
                            'email/index.html.twig',
                            array(
                              'username' => $datas->username,
                              'password' => $datas->password
                            )
                          ),
                          'text/html'
                        );

      $mailer->send($register_email);

      return new Response('Email envoyé', Response::HTTP_OK, array('content-type', 'application/json'));
    }
}
